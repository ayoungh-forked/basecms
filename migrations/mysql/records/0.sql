
-- Track types of records (eg., blog posts, news items)

CREATE TABLE IF NOT EXISTS record_types (
    id SERIAL,
    name varchar(255) NOT NULL,
    additional_fields MEDIUMTEXT, -- stored as JSON
    modification_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    creation_date TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY name (name)
) ENGINE=MyISAM CHARSET=utf8;

-- The records themselves

CREATE TABLE IF NOT EXISTS records (
    id SERIAL,
    type_name VARCHAR(255),
    title TEXT,
    description TEXT,
    tags TEXT,
    content MEDIUMTEXT,
    additional_field_data MEDIUMTEXT,
    author BIGINT NOT NULL,
    draft BOOL NOT NULL DEFAULT 0,
    live BOOL NOT NULL DEFAULT 0,
    live_from DATETIME,
    live_until DATETIME,
    source VARCHAR(255),
    modification_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    creation_date TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    KEY type_name (type_name),
    KEY live (live),
    KEY live_from (live_from),
    KEY live_until (live_until),
    KEY draft (draft),
    KEY title (title(255)),
    KEY author (author),
    KEY source (source)
) ENGINE=MyISAM CHARSET=utf8;

