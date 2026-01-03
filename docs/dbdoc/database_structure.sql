CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE listings (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    praha VARCHAR(50) NOT NULL,
    district VARCHAR(50) NOT NULL,
    layout VARCHAR(50) NOT NULL,
    area INT(11) NOT NULL,
    price INT(11) NOT NULL,
    listing_description TEXT DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE listing_images (
    id INT(11) NOT NULL AUTO_INCREMENT,
    listing_id INT(11) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (listing_id) REFERENCES listings (id) ON DELETE CASCADE
);