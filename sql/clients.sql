-- Varun Deep Singh
-- 25 oct 2023
-- Inft2100 Section 3

-- The SQL file to create tables and add clients to the database
DROP SEQUENCE IF EXISTS client_id_seq CASCADE;
CREATE SEQUENCE client_id_seq START 5000;

DROP TABLE IF EXISTS clients CASCADE;
CREATE TABLE clients (
    id INT PRIMARY KEY DEFAULT nextval('client_id_seq'),
    EmailAddress VARCHAR(255) UNIQUE,
    FirstName VARCHAR(128),
    LastName VARCHAR(128),
    PhoneNumber VARCHAR(15),
    Extension INT,
    Sales_id INT NOT NULL,
    LogoPath VARCHAR(255),
    FOREIGN KEY (Sales_id) REFERENCES USERS(Id)
);
INSERT INTO clients(EmailAddress, FirstName, LastName, 
                    PhoneNumber, Extension, Sales_id,LogoPath) VALUES (
                        'test@gmail.com', 
                        'Sam', 
                        'Tom', 
                        '947-365-8975',
                        1,
                        1003,
                        'img1.png'
                    );