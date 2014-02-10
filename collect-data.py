''' Repopulate database from scratch.

Destroy data in people, items, item_tags, item_contacts, and item_contributors
tables, replace with new data from Google spreadsheet "CfA Library Taxonomy".

Assumes that scheme from createdb.sql is already in-place.

GDocs authentication is pulled from two environment variables, GDOCS_USERNAME
and GDOCS_PASSWORD. We use a single-purpose Google account with read-only access
to run the updates.
'''
from sys import argv
from time import time
from os import environ
from re import split
from itertools import chain
from multiprocessing import Pool
from sqlite3 import connect, IntegrityError
from hashlib import sha1

import gspread

def load_sheets(username, password):
    ''' Return a list of worksheets, except 'tbd' and 'Taxonomy'.
    '''
    gc = gspread.login(username, password)
    doc = gc.open('CfA Library Taxonomy')
    return [s for s in doc.worksheets() if s.title not in ('tbd', 'Taxonomy')]

def load_sheet_rows(sheet):
    ''' Return a list of sheet rows, with the first row as dictionary keys.
    '''
    rows = sheet.get_all_values()
    return [dict(zip(rows[0], row)) for row in rows[1:]]

def load_rows(username, password):
    ''' Return a list of all rows from all sheets.
    '''
    pool = Pool(processes=10)
    
    sheets = load_sheets(username, password)
    sheet_rows = pool.map(load_sheet_rows, sheets)
    
    pool.close()
    
    return list(chain(*sheet_rows))

def find_thumbnail(item):
    '''
    '''
    if item['format'] != 'Video':
        return item
    
    from urlparse import urlparse, parse_qs
    from urllib import urlopen
    from os.path import split
    from json import load
    
    try:
        _, host, path, _, query, _ = urlparse(item['link'])
    
        if host in ('youtube.com', 'www.youtube.com'):
            if 'v' in parse_qs(query):
                id = parse_qs(query)['v'][0]
                item['thumb_src'] = 'http://img.youtube.com/vi/%s/0.jpg' % id
                item['embed_href'] = '//www.youtube.com/embed/%s' % id
                
                if 'link' in parse_qs(query):
                    item['embed_href'] += '?list=%s' % parse_qs(query)['link'][0]
    
        if host in ('vimeo.com', 'www.vimeo.com'):
            id = split(path)[-1]
            info = load(urlopen('http://vimeo.com/api/v2/video/%s.json' % id))
            item['thumb_src'] = info[0]['thumbnail_large']
            item['embed_href'] = '//player.vimeo.com/video/%s?title=0&byline=0&portrait=0' % id
    
    except:
        pass
    
    return item

if __name__ == '__main__':

    (dbname, ) = argv[1:]
    items, people = [], []
    
    print 'Downloading...',
    start_time = time()
    
    for row in load_rows(environ['GDOCS_USERNAME'], environ['GDOCS_PASSWORD']):

        contributors = set()
        contacts = set()
        
        for name in split(r', *', row.get('Contributors', '').strip()):
            if name not in people:
                people.append(name)
            contributors.add(people.index(name))

        for name in split(r', *', row.get('Project Contact', '').strip()):
            if name not in people:
                people.append(name)
            contacts.add(people.index(name))
        
        tags = set(split(r', *', row.get('Tags/Keywords', '').strip()))
        locations = set(split(r' *; *', row.get('Location', '').strip()))
        programs = set(split(r', *', row.get('Program', '').strip()))
        
        item = dict(
            slug = row.get('Slug') or None,
            category = row.get('Category') or None,
            title = row.get('Title') or None,
            link = row.get('Link') or None,
            date = row.get('Date') or None,
            format = row.get('Format') or None,
            summary_txt = row.get('Summary Text') or None,
            content_htm = row.get('Content HTML') or None,
            thumb_src = None,
            embed_href = None,
            contributors = contributors,
            contacts = contacts,
            locations = locations,
            programs = programs,
            tags = tags,
            )
        
        if not item['title']:
           continue 
        
        items.append(item)
    
    print '%.3f seconds' % (time() - start_time)

    print 'Thumbnailing', len(items), 'items...',
    start_time = time()
    
    pool = Pool(processes=10)
    items = pool.map(find_thumbnail, items)
    pool.close()
    
    print '%.3f seconds' % (time() - start_time)

    print 'Saving', len(items), 'items...',
    start_time = time()
    
    with connect(dbname) as db:

        db.execute('DELETE FROM people')
        db.execute('DELETE FROM items')
        db.execute('DELETE FROM item_tags')
        db.execute('DELETE FROM item_locations')
        db.execute('DELETE FROM item_programs')
        db.execute('DELETE FROM item_contributors')
        db.execute('DELETE FROM item_contacts')

        db.executemany('INSERT INTO people (id, name) VALUES (?, ?)',
                       list(enumerate(people)))
        
        for item in items:

            # Generate an item ID based on five fields.
            fields = 'category title link date format'.split()
            value = repr([(k, item[k]) for k in sorted(fields)])
            item_id = sha1(value).hexdigest()[:16]
        
            try:
                db.execute('''INSERT INTO items
                              (id, slug, category, title, link, date, format,
                               summary_txt, content_htm, thumb_src, embed_href)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)''',
                           (item_id, item['slug'], item['category'], item['title'],
                            item['link'], item['date'], item['format'],
                            item['summary_txt'], item['content_htm'],
                            item['thumb_src'], item['embed_href'])
                           )

                db.executemany('INSERT INTO item_tags (item_id, tag) VALUES (?, ?)',
                               [(item_id, tag) for tag in item['tags']])
            
                db.executemany('INSERT INTO item_locations (item_id, location) VALUES (?, ?)',
                               [(item_id, location) for location in item['locations']])
            
                db.executemany('INSERT INTO item_programs (item_id, program) VALUES (?, ?)',
                               [(item_id, program) for program in item['programs']])
            
                db.executemany('INSERT INTO item_contributors (item_id, person_id) VALUES (?, ?)',
                               [(item_id, person_id) for person_id in item['contributors']])
            
                db.executemany('INSERT INTO item_contacts (item_id, person_id) VALUES (?, ?)',
                               [(item_id, person_id) for person_id in item['contacts']])

            except IntegrityError, e:
                print '--> Failed at "%(title)s" in %(category)s:' % item
                print '   ', e, '(integrity error)'
                raise
            
        db.execute('VACUUM')
    
    print '%.3f seconds' % (time() - start_time)
