DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS item_tags;
DROP TABLE IF EXISTS item_locations;
DROP TABLE IF EXISTS people;
DROP TABLE IF EXISTS item_contributors;
DROP TABLE IF EXISTS item_contacts;

CREATE TABLE items
(
    id          UNSIGNED INTEGER PRIMARY KEY,
    category    TEXT,
    title       TEXT,
    link        TEXT,
    program     TEXT,
    date        TEXT,
    format      TEXT
);

CREATE TABLE item_tags
(
    item_id UNSIGNED INTEGER,
    tag     TEXT
);

CREATE TABLE item_locations
(
    item_id     UNSIGNED INTEGER,
    location    TEXT
);

CREATE TABLE people
(
    id      UNSIGNED INTEGER PRIMARY KEY,
    name    TEXT
);

CREATE TABLE item_contributors
(
    item_id     UNSIGNED INTEGER,
    person_id   UNSIGNED INTEGER
);

CREATE TABLE item_contacts
(
    item_id     UNSIGNED INTEGER,
    person_id   UNSIGNED INTEGER
);

CREATE INDEX item_categories ON items (category);
CREATE INDEX item_tag_items ON item_tags (item_id);
CREATE INDEX item_tag_tags ON item_tags (tag);
CREATE INDEX item_contributor_items ON item_contributors (item_id);
CREATE INDEX item_contributor_people ON item_contributors (person_id);
CREATE INDEX item_contact_items ON item_contacts (item_id);
CREATE INDEX item_contact_people ON item_contacts (person_id);
