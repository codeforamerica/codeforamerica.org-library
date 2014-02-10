Code for America dot Org slash Library
======================================

This repository controls the code behind the Code for America website Library
section, currently visible at [alpha.codeforamerica.org/library](http://alpha.codeforamerica.org/library/).

How to Edit
-----------

Library content lives in a GDocs spreadsheet, “CfA Library Taxonomy”. Edit it
on GDocs, it will be automatically imported to the Library every few minutes.

Install
-------

Use SQLite to initialize a `data.db` file:

    sqlite3 data.db < createdb.sql

Run `collect-data.py` as a cron task to update from *CfA Library Taxonomy*.
GDocs authentication is pulled from two environment variables, `GDOCS_USERNAME`
and `GDOCS_PASSWORD`. We use a single-purpose Google account with read-only
access to run the updates.

    GDOCS_USERNAME=<name> GDOCS_PASSWORD=<pass> python collect-data.py data.db

The app itself is written in PHP. View it in a web browser via Apache with
`mod_php` installed.
