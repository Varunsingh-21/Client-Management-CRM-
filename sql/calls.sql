-- Varun Deep Singh
-- 25 octber 2023
-- Inft2100 Section 3

-- The SQL file to create tables and add call records to the database
DROP SEQUENCE IF EXISTS call_id_seq CASCADE;
CREATE SEQUENCE call_id_seq START 100;

DROP TABLE IF EXISTS calls CASCADE;
CREATE TABLE calls(
    id INT PRIMARY KEY DEFAULT nextval('call_id_seq'),
    time_of_call TIMESTAMP,
    client_id INT,
    notes VARCHAR(1024),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

INSERT INTO calls (time_of_call, notes, client_id)
VALUES
(
    '2021-09-07 16:29:08', 
    'Testing the system.',
    5000
);
SELECT * FROM calls;