from sys import argv
from sqlite3 import connect

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
    
    contacts = [(id, name) for (id, name) in stuff]

    stuff = db.execute('''SELECT people.* FROM item_contributors
                      LEFT JOIN people ON people.id = item_contributors.person_id
                      WHERE item_id = ? AND people.name != ""''',
                   (item_id, ))
    
    contributors = [(id, name) for (id, name) in stuff]

if __name__ == '__main__':

    (dbname, ) = argv[1:]
    
    with connect(dbname) as db:
    
        for (item_id, item_slug) in db.execute('SELECT id, slug FROM items'):
            slug = item_slug or item_id
            
            print slug
            
            load_item(db, item_id)
            
