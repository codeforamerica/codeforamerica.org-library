DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS item_tags;
DROP TABLE IF EXISTS item_locations;
DROP TABLE IF EXISTS item_programs;
DROP TABLE IF EXISTS people;
DROP TABLE IF EXISTS item_contributors;
DROP TABLE IF EXISTS item_contacts;

CREATE TABLE items
(
    id          TEXT(16) PRIMARY KEY,
    slug        TEXT,
    category    TEXT,
    title       TEXT,
    link        TEXT,
    date        TEXT,
    format      TEXT,
    summary_txt TEXT,
    content_htm TEXT,
    thumb_src   TEXT,
    embed_href  TEXT
);

CREATE TABLE item_tags
(
    item_id TEXT(16),
    tag     TEXT
);

CREATE TABLE item_locations
(
    item_id     TEXT(16),
    location    TEXT
);

CREATE TABLE item_programs
(
    item_id     TEXT(16),
    program     TEXT
);

CREATE TABLE people
(
    id      UNSIGNED INTEGER PRIMARY KEY,
    name    TEXT
);

CREATE TABLE item_contributors
(
    item_id     TEXT(16),
    person_id   UNSIGNED INTEGER
);

CREATE TABLE item_contacts
(
    item_id     TEXT(16),
    person_id   UNSIGNED INTEGER
);

CREATE UNIQUE INDEX item_slugs ON items (slug);
CREATE INDEX item_categories ON items (category);
CREATE INDEX item_tag_items ON item_tags (item_id);
CREATE INDEX item_tag_tags ON item_tags (tag);
CREATE INDEX item_contributor_items ON item_contributors (item_id);
CREATE INDEX item_contributor_people ON item_contributors (person_id);
CREATE INDEX item_contact_items ON item_contacts (item_id);
CREATE INDEX item_contact_people ON item_contacts (person_id);
