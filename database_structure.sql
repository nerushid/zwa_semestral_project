# Database Documentation: NestlyHomes

## 1. Overview

The database is built on a relational model (MySQL/MariaDB) and consists of three main entities connected by One-to-Many relationships.

**Entities:**

* **Users**: Registered users and administrators.
* **Listings**: Real estate properties linked to a specific user.
* **Listing Images**: Images linked to a specific listing.

---

## 2. Table Structure

### Table: `users`

Stores authentication details and user roles.

| Column | Type | Attributes | Description |
| --- | --- | --- | --- |
| `id` | INT | PK, Auto Increment | Unique user identifier. |
| `firstname` | VARCHAR(50) | Not Null | User's first name. |
| `surname` | VARCHAR(50) | Not Null | User's last name. |
| `email` | VARCHAR(100) | Not Null | User email (used for login). |
| `pwd` | VARCHAR(255) | Not Null | Hashed password (Bcrypt/Argon2). |
| `role` | VARCHAR(20) | Default 'user' | Access level: 'user' or 'admin'. |
| `created_at` | DATETIME | Default CURRENT_TIMESTAMP | Account creation timestamp. |

### Table: `listings`

Stores property details.
**Relationship:** Belongs to `users` (`user_id`).

| Column | Type | Attributes | Description |
| --- | --- | --- | --- |
| `id` | INT | PK, Auto Increment | Unique listing identifier. |
| `user_id` | INT | FK | Reference to `users.id`. |
| `praha` | VARCHAR(50) | Not Null | Prague district ID stored as string (e.g., "1", "10"). |
| `district` | VARCHAR(50) | Not Null | District name (e.g., "Vinohrady", "Zličín"). |
| `layout` | VARCHAR(20) | Not Null | Apartment layout (e.g., "1+kk", "3+1"). |
| `area` | INT | Not Null | Floor area in square meters. |
| `price` | INT | Not Null | Monthly rent in CZK. |
| `listing_description` | TEXT | Nullable | Detailed description of the property. |
| `created_at` | TIMESTAMP | Default CURRENT_TIMESTAMP | Listing creation timestamp. |

### Table: `listing_images`

Stores file references for listing images.
**Relationship:** Belongs to `listings` (`listing_id`).

| Column | Type | Attributes | Description |
| --- | --- | --- | --- |
| `id` | INT | PK, Auto Increment | Unique image identifier. |
| `listing_id` | INT | FK | Reference to `listings.id`. |
| `image_path` | VARCHAR(255) | Not Null | Filename stored on server (e.g., `listing_13_hash.jpg`). |

---

## 3. Relationships and Constraints

### Foreign Keys

1. **Users to Listings:**
* `listings.user_id` references `users.id`.
* **Action:** `ON DELETE CASCADE`. If a user is deleted, all their listings are automatically deleted.


2. **Listings to Images:**
* `listing_images.listing_id` references `listings.id`.
* **Action:** `ON DELETE CASCADE`. If a listing is deleted, all associated database image records are automatically deleted.



---

## 4. Application Logic & Context

### Data Handling

* **Praha Field:** stored as `VARCHAR` in the database but represents numeric district IDs ("1", "2"... "10"). The frontend displays these as "Praha 1", "Praha 2", etc.
* **Images:** The database stores only the filename. The physical files are located in an `uploads/` directory. Thumbnail versions of images are prefixed with `thumb_` (e.g., `thumb_image.jpg`), handled by the application logic, not the DB.

### Security & Roles

* **Roles:** The `role` column in the `users` table determines permissions.
* `user`: Can create listings and manage only their own listings.
* `admin`: Has global permissions to delete any listing (implemented via session checks `$_SESSION['user_role'] === 'admin'`).



### Search & Filtering

* **Filtering:** The application constructs SQL queries dynamically based on user input.
* **Logic:**
* Exact matches for `praha` and `district`.
* Range comparisons (`>=`, `<=`) for `price` and `area`.
* `IN` clause for `layout` (e.g., `layout IN ('1+kk', '2+kk')`).