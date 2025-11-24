-- Users table
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- TESTS
INSERT INTO users (firstname, surname, email, pwd) VALUES ('Ivan', 'Shcherbatiuk', 'ivavanjo@gmail.com', 'zxc123zxc123');

INSERT INTO users (firstname, surname, email, pwd) VALUES ('Valeriia', 'Kyryk', 'kyryk@gmail.com', 'qwe345qwe345');

UPDATE users SET email = 'iva.shcherbatiuk@gmail.com', pwd = '00002562' WHERE id = 1;


-- Listings table
CREATE TABLE listings (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    praha TINYINT NOT NULL,
    district VARCHAR(30),
    layout VARCHAR(5) NOT NULL,
    area INT(11) NOT NULL,
    price INT(11) NOT NULL,
    dscrpt TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    users_id INT(11) NOT NULL,
    FOREIGN KEY (users_id) REFERENCES users (id)
);

-- TEST
INSERT INTO listings (praha, district, layout, area, price, dscrpt, users_id) VALUES (5, 'Smichov', '1kk', 20, 15000, 'Poplatky jsou 2890CZK. Elekrina se prevadi na najemnika (cca 1000 CZK)', 2);

SELECT firstname, surname FROM users WHERE id = 2;

SELECT * FROM listings WHERE users_id = 1;

SELECT users.firstname, listing.* FROM users INNER JOIN listings ON users.id = listings.users_id;

SELECT users.id, users.firstname, listings.* FROM users LEFT JOIN listings ON users.id = listings.users_id;

SELECT users.id, users.firstname, users.surname, listings.* FROM users LEFT JOIN listings ON users.id = listings.users_id;