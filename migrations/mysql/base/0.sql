
-- Table for tracking which migrations have been applied to the current 
-- database.

CREATE TABLE IF NOT EXISTS version (
    label VARCHAR(25) NOT NULL,
    value INT NOT NULL DEFAULT 0,
    modification_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    creation_date TIMESTAMP NOT NULL,
    PRIMARY KEY (label),
    UNIQUE KEY label (label)
) ENGINE=InnoDB CHARSET=utf8;

INSERT IGNORE INTO version (label, value, creation_date) VALUES ('base', 0, NOW());
INSERT IGNORE INTO version (label, value, creation_date) VALUES ('site', 0, NOW());

INSERT IGNORE INTO version (label, value, creation_date) VALUES ('files', 0, NOW());

INSERT IGNORE INTO version (label, value, creation_date) VALUES ('pages', 0, NOW());

INSERT IGNORE INTO version (label, value, creation_date) VALUES ('records', 0, NOW());

INSERT IGNORE INTO version (label, value, creation_date) VALUES ('users', 0, NOW());
INSERT IGNORE INTO version (label, value, creation_date) VALUES ('user_roles', 0, NOW());