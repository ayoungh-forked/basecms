
-- Table for tracking user accounts

CREATE TABLE IF NOT EXISTS users (
    id SERIAL,
    admin BOOL NOT NULL DEFAULT 0,
    developer BOOL NOT NULL DEFAULT 0,
    role BIGINT UNSIGNED NOT NULL DEFAULT 0,
    username VARCHAR(255) NOT NULL,
    password_hash TEXT NOT NULL,
    password_attempts INT NOT NULL DEFAULT 0,
    last_attempt INT NOT NULL DEFAULT 0,
    real_name TEXT NOT NULL DEFAULT '',
    modification_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    creation_date TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY username (username),
    KEY role (role)
) ENGINE=MyISAM CHARSET=utf8;

-- A default user account so that the admin backend can be accessed to set up
-- real users.

INSERT IGNORE INTO users (admin, developer, username, password_hash, creation_date) VALUES (1, 1, 'Admin', '5LKKPDUyib9yzNG/OgcPw0$2a$10$5LKKPDUyib9yzNG/OgcPwuHUhFDzXKU2SZuR8Q7NodJAYssALComq', NOW());