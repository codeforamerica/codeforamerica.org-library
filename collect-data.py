''' Repopulate database from scratch.

Destroy data in people, items, item_tags, item_contacts, and item_contributors
tables, replace with new data from Google spreadsheet "CfA Library Taxonomy".

Assumes that scheme from createdb.sql is already in-place.

'''
from sys import argv
from os import environ
from re import split
from itertools import chain
from multiprocessing import Pool
from sqlite3 import connect, IntegrityError

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

if __name__ == '__main__':

    (dbname, ) = argv[1:]
    items, people = [], []
    
    print 'Downloading...'
    
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
            contributors = contributors,
            contacts = contacts,
            locations = locations,
            programs = programs,
            tags = tags,
            )
        
        items.append(item)
    
    print 'Saving', len(items), 'items...'
    
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
        
        for (item_id, item) in enumerate(items):
            try:
                db.execute('''INSERT INTO items
                              (id, slug, category, title, link, date, format, summary_txt, content_htm)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)''',
                           (item_id, item['slug'], item['category'], item['title'],
                            item['link'], item['date'], item['format'],
                            item['summary_txt'], item['content_htm'])
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
