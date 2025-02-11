-- Varun Deep Singh
-- 11 Septemper 2023
-- Inft2100 Section 3

-- The SQL file to create tables and add users to the database

CREATE EXTENSION IF NOT EXISTS pgcrypto;
DROP SEQUENCE IF EXISTS users_id_seq CASCADE;
CREATE SEQUENCE users_id_seq START 1000;


DROP TABLE iF EXISTS users CASCADE;
CREATE TABLE users(
    Id INT PRIMARY KEY DEFAULT nextval('users_id_seq'),
    EmailAddress VARCHAR(255) UNIQUE,
    Password VARCHAR(255) NOT NULL,
    FirstName VARCHAR(255) NOT NULL,
    LastName VARCHAR(128) NOT NULL,
    CreatedTime TIMESTAMP,
    LastLoggedIn TIMESTAMP,
    phoneExtension VARCHAR(128),
    UserType VARCHAR(2)
);

INSERT INTO users(EmailAddress,Password,FirstName,LastName,CreatedTime,LastLoggedIn,phoneExtension,UserType) VALUES ('jdoe@dcmail.ca',
crypt('password',gen_salt('bf')),
'John',
'Doe',
'2023-09-05 19:10:25',
'2023-09-05 20:00:00',
'1211',
'a'
);
INSERT INTO users(EmailAddress,Password,FirstName,LastName,CreatedTime,LastLoggedIn,phoneExtension,UserType) VALUES ('varunsingh@dcmail.ca',
crypt('passwordv',gen_salt('bf')),
'Varun',
'Singh',
'2023-09-05 19:10:25',
'2023-09-05 20:00:00',
'1211',
'a'
);
INSERT INTO users(EmailAddress,Password,FirstName,LastName,CreatedTime,LastLoggedIn,phoneExtension,UserType) VALUES ('purvipatel@dcmail.ca',
crypt('passwordp',gen_salt('bf')),
'Purvi',
'Patel',
'2023-09-05 19:10:25',
'2023-09-05 20:00:00',
'1211',
'a'
);
INSERT INTO users(EmailAddress,Password,FirstName,LastName,CreatedTime,LastLoggedIn,phoneExtension,UserType) VALUES ('sales_1@dcmail.ca',
crypt('passwordp',gen_salt('bf')),
'sales',
'Person',
'2023-09-05 19:10:25',
'2023-09-05 20:00:00',
'1211',
's'
);
