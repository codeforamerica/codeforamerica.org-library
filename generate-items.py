from sys import argv
from sqlite3 import connect
from tempfile import mkdtemp
from shutil import rmtree, move
from urllib import quote_plus

import yaml
from jinja2 import Environment, PackageLoader

_marker = "---\n"

def load_item(db, item_id):
    '''
    '''
    (row, ) = list(db.execute('''SELECT id, slug, category, title, link,
                                        date, format, summary_txt, content_htm,
                                        thumb_src, thumb_ratio, embed_href  
                                 FROM items WHERE id = ?''',
                              (item_id, )))
    
    cols = ('id', 'slug', 'category', 'title', 'link',
            'date', 'format','summary_txt', 'content_htm',
            'thumb_src', 'thumb_ratio', 'embed_href')
    
    return dict([(col, row or '') for (col, row) in zip(cols, row)])

def load_extras(db, item_id):
    '''
    '''
    stuff = db.execute('''SELECT tag FROM item_tags
                          WHERE item_id = ? AND tag != ""
                          ORDER BY tag COLLATE NOCASE''',
                       (item_id, ))
    
    tags = [tag for (tag, ) in stuff]
    
    stuff = db.execute('''SELECT location FROM item_locations
                      WHERE item_id = ? AND location != ""
                      ORDER BY location COLLATE NOCASE''',
                   (item_id, ))
    
    locations = [location for (location, ) in stuff]

    stuff = db.execute('''SELECT program FROM item_programs
                      WHERE item_id = ? AND program != ""
                      ORDER BY program COLLATE NOCASE''',
                   (item_id, ))
    
    programs = [program for (program, ) in stuff]

    stuff = db.execute('''SELECT people.* FROM item_contacts
                      LEFT JOIN people ON people.id = item_contacts.person_id
                      WHERE item_id = ? AND people.name != ""''',
                   (item_id, ))
    
    contacts = [name for (id, name) in stuff]

    stuff = db.execute('''SELECT people.* FROM item_contributors
                      LEFT JOIN people ON people.id = item_contributors.person_id
                      WHERE item_id = ? AND people.name != ""''',
                   (item_id, ))
    
    contributors = [name for (id, name) in stuff]
    
    return tags, locations, programs, contacts, contributors

def dump_jekyll_doc(front_matter, content, file):
    ''' Dump jekyll front matter and content to a file.
    
        To provide some guarantee of human-editable output, front matter
        is dumped using the newline-preserving block literal form.
        
        Sample output:
        
          ---
          "title": |-
            Greetings
          ---
          Hello world.
    '''
    # yaml.SafeDumper ensures best unicode output.
    dump_kwargs = dict(Dumper=yaml.SafeDumper, default_flow_style=False,
                       canonical=False, default_style='', indent=2,
                       allow_unicode=True)
    
    # Write front matter to the start of the file.
    #file.seek(0)
    #file.truncate()
    file.write(_marker)
    yaml.dump(front_matter, file, **dump_kwargs)

    # Write content to the end of the file.
    file.write(_marker)
    file.write(content.encode('utf8'))

if __name__ == '__main__':

    (dbname, ) = argv[1:]
    
    with connect(dbname) as db:
        items = list()
    
        for (item_id, item_slug) in db.execute('SELECT id, slug FROM items'):
            slug = item_slug or item_id
    
            item = load_item(db, item_id)
            values = load_extras(db, item_id)
            names = 'tags', 'locations', 'programs', 'contacts', 'contributors'
            front = [(key, val) for (key, val) in zip(names, values) if val]
            
            items.append((slug, item, dict(front)))
    
    jinja = Environment(loader=PackageLoader(__name__, '_templates'))
    jinja.filters['u'] = quote_plus

    template = jinja.get_template('item.html')
    dirname = mkdtemp()
    
    try:
        for (slug, item, front) in items:
            kwargs = dict(item)
            kwargs.update(front)
            html = template.render(**kwargs)
        
            try:
                with open('{0}/{1}.html'.format(dirname, slug), 'w') as file:
                    print file.name
                    dump_jekyll_doc(front, html, file)
            except IOError:
                print '!' * 30
    except:
        rmtree(dirname)
    else:
        rmtree('item')
        move(dirname, 'item')
        print 'moved to item'
