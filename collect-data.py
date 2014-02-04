from os import environ

import gspread

def load_sheets(username, password):
    '''
    '''
    gc = gspread.login(username, password)
    doc = gc.open('CfA Library Taxonomy')
    return [s for s in doc.worksheets() if s.title not in ('tbd', 'Taxonomy')]

if __name__ == '__main__':

    for sheet in load_sheets(environ['GDOCS_USERNAME'], environ['GDOCS_PASSWORD']):
        print sheet.title
        print sheet.row_values(1)
