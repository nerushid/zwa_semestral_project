Database Technical Documentation: NestlyHomes
DBMS: MySQL Charset: utf8mb4_general_ci

1. Entity Description (Tables)
The database consists of three main tables handling users, real estate listings, and images.

1.1. Table users

Stores credentials for all registered users and administrators.

Column,Data Type,Constraints,Description
id,INT(11),"PK, AI",Unique user identifier.
firstname,VARCHAR(50),NOT NULL,User's first name.
surname,VARCHAR(50),NOT NULL,User's last name.
email,VARCHAR(100),UNIQUE,Email address (used for login).
pwd,VARCHAR(255),NOT NULL,Password hash (bcrypt/argon2 algorithm).
role,VARCHAR(20),Default: 'user',Access role: user (standard) or admin (administrator).
created_at,DATETIME,Default: NOW(),Account creation timestamp.

The main table containing property information. Each listing belongs to a specific user.

Column,Data Type,Constraints,Description
id,INT(11),"PK, AI",Unique listing identifier.
user_id,INT(11),FK,ID of the listing owner (references users.id).
praha,VARCHAR(50),NOT NULL,"Prague district ID. Stored as string (e.g., ""1"", ""10"")."
district,VARCHAR(50),NOT NULL,"Neighborhood name (e.g., ""Vinohrady"", ""Smíchov"")."
layout,VARCHAR(20),NOT NULL,"Apartment layout (e.g., ""1+kk"", ""3+1"")."
area,INT(11),NOT NULL,Floor area in square meters.
price,INT(11),NOT NULL,Monthly rent in CZK.
listing_description,TEXT,NULL,Detailed text description of the property.
created_at,DATETIME,Default: NOW(),Listing creation timestamp.

Stores file paths for uploaded images. Implements a one-to-many relationship (one listing -> multiple photos).

Column,Data Type,Constraints,Description
id,INT(11),"PK, AI",Unique record identifier.
listing_id,INT(11),FK,ID of the related listing (references listings.id).
image_path,VARCHAR(255),NOT NULL,Filename of the image stored on the server (in uploads/).

2. Relationships
The database implements the following relationships via Foreign Keys:

Users -> Listings (1:N)

Relation: users.id ↔ listings.user_id

Delete Rule (ON DELETE CASCADE): When a user is deleted, all their listings are automatically deleted.

Listings -> Images (1:N)

Relation: listings.id ↔ listing_images.listing_id

Delete Rule (ON DELETE CASCADE): When a listing is deleted, all associated image records are automatically deleted.