from sys import argv
from sqlite3 import connect

import yaml

_marker = "---\n"

def load_item(db, item_id):
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
            
            values = load_item(db, item_id)
            names = 'tags', 'locations', 'programs', 'contacts', 'contributors'
            front = [(key, val) for (key, val) in zip(names, values) if val]
            
            items.append((slug, dict(front)))
    
    for (slug, front) in items:
        print slug, '...'
        
        try:
            with open('item/{0}.html'.format(slug), 'w') as file:
                dump_jekyll_doc(front, 'poop', file)
        except IOError:
            print '!' * 30
