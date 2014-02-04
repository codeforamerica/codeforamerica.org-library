from os import environ
from re import split
from itertools import chain
from multiprocessing import Pool

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

    items = []
    people = []
    
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

        item = dict(
            title = row.get('Title'),
            link = row.get('Link'),
            program = row.get('Program'),
            location = row.get('Location'),
            date = row.get('Date'),
            format = row.get('Format'),
            contributors = contributors,
            contacts = contacts,
            tags = tags,
            )
        
        items.append(item)
    
    print people
