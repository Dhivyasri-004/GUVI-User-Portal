# GUVI User Portal

A responsive user registration, authentication, and profile management web application developed as part of the GUVI internship assignment.

The application provides a complete user workflow:

```text
Register → Login → Profile → Update Profile → Logout
```

The project uses HTML, CSS, JavaScript, jQuery, Bootstrap, PHP, MySQL, Redis/Memurai, and MongoDB. Frontend and backend files are maintained separately, and all backend communication is performed using jQuery AJAX without traditional form submission.

---

## 📌 Project Overview

The **GUVI User Portal** is a web-based user authentication and profile management system.

The application allows users to:

* Register a new account
* Login using registered credentials
* Maintain login state using Browser LocalStorage
* Store authentication tokens in Redis
* View profile information
* Update additional profile details
* Logout securely
* Store user and profile information in MySQL
* Use prepared statements for MySQL operations
* Use Bootstrap for responsive design
* Use MongoDB as part of the configured technology stack

### Application Flow

```text
                    ┌──────────────┐
                    │   Register   │
                    └──────┬───────┘
                           ↓
                    ┌──────────────┐
                    │     Login    │
                    └──────┬───────┘
                           ↓
                    ┌──────────────┐
                    │   Profile    │
                    └──────┬───────┘
                           ↓
                    ┌──────────────┐
                    │Update Profile│
                    └──────┬───────┘
                           ↓
                    ┌──────────────┐
                    │    Logout    │
                    └──────────────┘
```

---

# ✨ Features

## 1. User Registration

Users can create a new account by providing:

* Full Name
* Email Address
* Password
* Confirm Password

### Registration Features

* Client-side validation
* Email format validation
* Password length validation
* Confirm password validation
* Duplicate email checking
* Secure password hashing
* MySQL database storage
* AJAX-based backend communication

### Registration Flow

```text
Register Page
      ↓
Enter User Details
      ↓
JavaScript Validation
      ↓
jQuery AJAX
      ↓
register.php
      ↓
MySQL
      ↓
Password Hashing
      ↓
User Created
      ↓
Login Page
```

---

## 2. User Login

Registered users can login using:

* Email Address
* Password

### Login Process

```text
User enters credentials
        ↓
jQuery AJAX
        ↓
PHP Backend
        ↓
MySQL User Lookup
        ↓
Password Verification
        ↓
Redis Token Created
        ↓
Token Returned to Browser
        ↓
Token Stored in LocalStorage
        ↓
Profile Page
```

Passwords are verified using PHP's secure password verification mechanism.

---

## 3. Profile Management

After successful login, users can view their profile information.

The profile page displays:

* Full Name
* Email Address
* Age
* Date of Birth
* Contact Number
* City
* Address

The registered name and email are displayed as read-only information.

Additional profile information can be updated by the user.

---

## 4. Profile Update

Users can update:

* Age
* Date of Birth
* Contact Number
* City
* Address

The profile update process includes client-side validation before the data is sent to the backend.

### Profile Update Flow

```text
Profile Page
      ↓
Enter / Edit Profile Details
      ↓
JavaScript Validation
      ↓
jQuery AJAX
      ↓
profile.php
      ↓
Redis Token Verification
      ↓
MySQL Prepared Statement
      ↓
Profile Updated
```

The updated information is stored in the MySQL `users` table.

---

## 5. LocalStorage Authentication

PHP Sessions are **not used** in this project.

After successful login, the backend generates a secure authentication token.

The token is returned to the browser and stored using Browser LocalStorage.

```text
Login Success
     ↓
Authentication Token
     ↓
Browser LocalStorage
     ↓
loginToken
```

The stored token is sent with AJAX requests when the user:

* Loads the profile
* Updates the profile
* Logs out

The backend verifies the token against Redis before allowing protected profile operations.

---

## 6. Redis Token Storage

Redis is used as the backend token store.

The project uses **Memurai**, a Redis-compatible server for Windows.

### Redis Configuration

```text
Host: 127.0.0.1
Port: 6379
```

### Token Structure

```text
login:<token> → user email
```

A secure random token is generated after successful login.

The token is stored in Redis with a **1-hour expiration time**.

```text
Login
  ↓
Generate Token
  ↓
Store Token in Redis
  ↓
TTL = 3600 seconds
```

When the user logs out, the corresponding Redis token is deleted.

---

## 7. MySQL Database

MySQL is used to store user account and profile information.

### Database

```text
guvi_portal
```

### Main Table

```text
users
```

### Users Table Structure

| Column          | Description                |
| --------------- | -------------------------- |
| `id`            | Unique user ID             |
| `name`          | User's full name           |
| `email`         | User's email address       |
| `password_hash` | Securely hashed password   |
| `age`           | User's age                 |
| `dob`           | Date of birth              |
| `contact`       | Contact number             |
| `city`          | User's city                |
| `address`       | User's address             |
| `created_at`    | Account creation timestamp |

All MySQL operations use **PDO prepared statements**.

No direct string-concatenated SQL queries are used for user input.

---

## 8. MongoDB

MongoDB is included in the project technology stack and configured for the application.

### MongoDB Configuration

```text
Server:   127.0.0.1:27017
Database: guvi_portal
Collection: profiles
```

The project includes:

* MongoDB PHP extension
* Composer MongoDB library
* MongoDB connection configuration

MongoDB is configured and available as part of the project environment. The primary user and profile data flow required by the assignment uses MySQL.

---

# 🎨 User Interface

The application uses a modern responsive interface designed for a clean user experience.

### UI Features

* Modern glassmorphism-style cards
* Gradient background design
* Responsive layouts
* Bootstrap components
* Bootstrap Icons
* Animated cards and elements
* Modern form controls
* Responsive navigation/actions
* Mobile-friendly profile layout
* Desktop and laptop support
* Custom CSS styling

The custom styling is maintained separately in:

```text
css/style.css
```

The interface is designed to remain functional and readable across different screen sizes.

---

# 🛠️ Technologies Used

## Frontend

* HTML5
* CSS3
* JavaScript
* jQuery
* Bootstrap 5
* Bootstrap Icons

## Backend

* PHP 8.x
* PDO

## Databases

* MySQL
* MongoDB

## Authentication / Token Storage

* Browser LocalStorage
* Redis
* Memurai

## Development Tools

* Visual Studio Code
* MySQL Workbench
* Composer
* XAMPP
* PHP Built-in Development Server

---

# 📂 Project Structure

```text
GUVI-User-Portal
│
├── README.md
├── composer.json
├── composer.lock
├── database.sql
│
├── index.html
├── register.html
├── login.html
├── profile.html
│
├── css
│   └── style.css
│
├── js
│   ├── register.js
│   ├── login.js
│   └── profile.js
│
├── php
│   ├── config.php
│   ├── db_mysql.php
│   ├── db_mongo.php
│   ├── redis.php
│   ├── register.php
│   ├── login.php
│   ├── profile.php
│   └── logout.php
│
├── vendor
│   └── Composer dependencies
│
└── composer files
```

---

# 🔐 Security Implementation

The application follows basic security practices for authentication and database operations.

## Password Hashing

Passwords are never stored as plain text.

PHP's password hashing function is used:

```php
password_hash($password, PASSWORD_DEFAULT);
```

During login, the stored password hash is verified using:

```php
password_verify($password, $user["password_hash"]);
```

This ensures that the original password is not stored directly in the database.

---

## Prepared Statements

All MySQL operations use PDO prepared statements.

Example:

```php
$stmt = $pdo->prepare(
    "SELECT id, name, email, password_hash
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->execute([$email]);
```

Prepared statements help protect the application from SQL injection attacks.

---

## Secure Authentication Token

After successful login, a cryptographically secure random token is generated:

```php
$token = bin2hex(random_bytes(32));
```

The token is stored in Redis and associated with the user's email.

The token automatically expires after one hour.

---

## No PHP Sessions

The application does not use PHP Sessions.

The following are not used:

```php
session_start();
```

or:

```php
$_SESSION
```

Instead, authentication is maintained using:

```text
Browser LocalStorage
        +
Redis
```

---

## Logout Security

During logout:

```text
Logout Request
      ↓
Redis Token Deleted
      ↓
LocalStorage Token Removed
      ↓
Login Page
```

This prevents the previously stored authentication token from continuing to authenticate the user.

---

# 📱 Responsive Design

Bootstrap 5 and custom CSS are used to make the application responsive.

The application supports:

* Desktop
* Laptop
* Tablet
* Mobile

Bootstrap grid classes such as:

```text
container
row
col-md-6
col-12
```

are used to create responsive layouts.

Additional responsive styling is maintained in:

```text
css/style.css
```

---

# 🔄 Application Flow

## Registration Flow

```text
Register Page
      ↓
Enter User Details
      ↓
Client-side Validation
      ↓
jQuery AJAX
      ↓
register.php
      ↓
MySQL
      ↓
Password Hashing
      ↓
User Created
      ↓
Login Page
```

---

## Login Flow

```text
Login Page
      ↓
Enter Email & Password
      ↓
jQuery AJAX
      ↓
login.php
      ↓
MySQL
      ↓
Password Verification
      ↓
Redis Token Created
      ↓
Token Returned
      ↓
LocalStorage
      ↓
Profile Page
```

---

## Profile Flow

```text
Profile Page
      ↓
Read Token from LocalStorage
      ↓
Send Token using AJAX
      ↓
Redis Token Verification
      ↓
MySQL
      ↓
Load Profile Information
```

---

## Update Flow

```text
Edit Profile
      ↓
JavaScript Validation
      ↓
jQuery AJAX
      ↓
profile.php
      ↓
Redis Token Verification
      ↓
MySQL Prepared Statement
      ↓
Profile Updated
```

---

## Logout Flow

```text
Logout Button
      ↓
jQuery AJAX
      ↓
logout.php
      ↓
Delete Token from Redis
      ↓
Remove Token from LocalStorage
      ↓
Login Page
```

---

# ⚙️ Installation and Setup

## 1. Install XAMPP

Install XAMPP with PHP and MySQL support.

Start MySQL before running the application.

---

## 2. Install PHP

Verify PHP installation using:

```powershell
php -v
```

The project was developed using PHP 8.x.

---

## 3. Create MySQL Database

Open **MySQL Workbench**.

Execute the contents of:

```text
database.sql
```

The script creates:

```text
guvi_portal
```

and the:

```text
users
```

table.

---

## 4. Configure MySQL

The MySQL configuration is stored in:

```text
php/config.php
```

Example local configuration:

```php
define("DB_HOST", "127.0.0.1");
define("DB_NAME", "guvi_portal");
define("DB_USER", "root");
define("DB_PASSWORD", "root");
```

If the local MySQL username or password is different, update the configuration accordingly.

> For public repositories, do not commit real database credentials. Use environment variables or placeholder values instead.

---

## 5. Configure MongoDB

Install MongoDB Server and make sure it is running.

The application is configured to connect to:

```text
mongodb://127.0.0.1:27017
```

The configured database is:

```text
guvi_portal
```

The MongoDB configuration is available in:

```text
php/config.php
```

---

## 6. Configure Redis / Memurai

Install and start **Memurai** on Windows.

The application expects Redis to run at:

```text
127.0.0.1:6379
```

The configuration is stored in:

```text
php/config.php
```

Configuration:

```php
define("REDIS_HOST", "127.0.0.1");
define("REDIS_PORT", 6379);
define("REDIS_SESSION_TTL", 3600);
```

---

## 7. Install Composer Dependencies

Open PowerShell inside the project directory:

```powershell
cd "C:\Users\Hp\OneDrive\Documents\GUVI-User-Portal"
```

Run:

```powershell
composer install
```

This installs the required PHP dependencies into:

```text
vendor/
```

The `vendor` folder is required when the application depends on the installed Composer packages.

---

# ▶️ Running the Application

Open PowerShell in the project directory:

```powershell
cd "C:\Users\Hp\OneDrive\Documents\GUVI-User-Portal"
```

Start the PHP development server:

```powershell
php -S localhost:8000
```

Open the application in a browser:

```text
http://localhost:8000/
```

---

# 🧪 Testing

The complete application should be tested using the following workflow.

## Test 1 — Registration

1. Open the application.
2. Click **Register**.
3. Enter a valid name.
4. Enter a valid email address.
5. Enter a password containing at least 6 characters.
6. Confirm the password.
7. Click **Register**.
8. Verify the registration success message.
9. Verify that the user is stored in MySQL.

---

## Test 2 — Login

1. Open the Login page.
2. Enter the registered email address.
3. Enter the correct password.
4. Click **Login**.
5. Verify the successful login message.
6. Verify that `loginToken` is stored in Browser LocalStorage.
7. Verify that the user is redirected to the Profile page.

---

## Test 3 — Profile

1. Verify that the user's name and email are displayed.
2. Enter:

   * Age
   * Date of Birth
   * Contact Number
   * City
   * Address
3. Click **Update Profile**.
4. Verify the successful update message.
5. Refresh the Profile page.
6. Verify that the updated information remains available.
7. Verify the updated information in MySQL Workbench if required.

---

## Test 4 — Logout

1. Click **Logout**.
2. Verify redirection to the Login page.
3. Verify that the LocalStorage login token is removed.
4. Try opening the Profile page directly.
5. Verify that the user is redirected to the Login page.

---

# 📋 GUVI Requirement Compliance

| Requirement                    | Implementation  |
| ------------------------------ | --------------- |
| Signup page                    | `register.html` |
| Login page                     | `login.html`    |
| Profile page                   | `profile.html`  |
| Profile update                 | `profile.php`   |
| Separate HTML/CSS/JS/PHP       | Implemented     |
| jQuery AJAX                    | Implemented     |
| No traditional form submission | Implemented     |
| Bootstrap responsive design    | Implemented     |
| MySQL                          | Implemented     |
| Prepared Statements            | Implemented     |
| LocalStorage                   | Implemented     |
| Redis                          | Implemented     |
| MongoDB                        | Configured      |
| PHP Session                    | Not used        |
| Password hashing               | Implemented     |
| Password verification          | Implemented     |
| Secure authentication token    | Implemented     |
| Token expiration               | Implemented     |
| Logout                         | Implemented     |
| Responsive UI                  | Implemented     |
| Profile management             | Implemented     |

---

# 📌 Important Notes

* Start MySQL before running the application.
* Ensure MongoDB Server is running.
* Ensure Memurai/Redis is running on port `6379`.
* Keep the `vendor` folder when submitting if required by the submission instructions.
* Do not remove `composer.json`.
* Do not remove `composer.lock`.
* The application uses PHP's built-in development server for local testing.
* The project is intended for local development and internship submission.
* Do not expose real production database credentials in a public repository.

---

# 📁 Important Files

| File               | Purpose                                      |
| ------------------ | -------------------------------------------- |
| `index.html`       | Home page                                    |
| `register.html`    | User registration page                       |
| `login.html`       | User login page                              |
| `profile.html`     | User profile page                            |
| `css/style.css`    | Application styling and responsive design    |
| `js/register.js`   | Registration AJAX and validation             |
| `js/login.js`      | Login AJAX and authentication token handling |
| `js/profile.js`    | Profile loading, updating, and logout        |
| `php/config.php`   | Application configuration                    |
| `php/db_mysql.php` | MySQL connection                             |
| `php/db_mongo.php` | MongoDB connection                           |
| `php/redis.php`    | Redis token management                       |
| `php/register.php` | Registration backend                         |
| `php/login.php`    | Login backend                                |
| `php/profile.php`  | Profile backend                              |
| `php/logout.php`   | Logout backend                               |
| `database.sql`     | MySQL database structure                     |
| `composer.json`    | Composer dependency configuration            |
| `composer.lock`    | Locked Composer dependency versions          |

---

# 🧩 Backend Architecture

The backend is separated into dedicated PHP files.

```text
Frontend
   │
   ├── HTML
   ├── CSS
   └── JavaScript / jQuery
          │
          │ AJAX
          ↓
      PHP Backend
          │
    ┌─────┼──────────┐
    ↓     ↓          ↓
  MySQL  Redis     MongoDB
```

### MySQL

Responsible for:

* User accounts
* Password hashes
* Profile information

### Redis

Responsible for:

* Authentication tokens
* Token-to-user mapping
* Token expiration
* Logout token deletion

### MongoDB

Configured as part of the application's database technology stack.

---

# 🔑 Authentication Architecture

The authentication process uses a browser token and Redis instead of PHP Sessions.

```text
             LOGIN
               │
               ↓
        Verify MySQL User
               │
               ↓
       Verify Password Hash
               │
               ↓
       Generate Secure Token
               │
               ↓
          Store in Redis
               │
               ↓
       Return Token to JS
               │
               ↓
      Store in LocalStorage
               │
               ↓
        Access Profile
               │
               ↓
       Send Token via AJAX
               │
               ↓
        Verify Redis Token
               │
               ↓
        Access MySQL Data
```

---

# 🛡️ Validation

The application performs validation on both the frontend and backend.

### Registration Validation

* Name cannot be empty.
* Name length is restricted.
* Email must be valid.
* Password must contain at least 6 characters.
* Password confirmation must match.
* Duplicate email addresses are rejected.

### Login Validation

* Email must be valid.
* Password cannot be empty.
* Invalid credentials are rejected.

### Profile Validation

* Age is required.
* Age must be within the accepted range.
* Date of birth is required.
* Future dates of birth are rejected.
* Contact number must contain exactly 10 digits.
* City and address can be updated as required.

---

# 📦 Submission Checklist

Before submitting the project, verify that the project folder contains:

```text
☑ README.md
☑ database.sql
☑ index.html
☑ register.html
☑ login.html
☑ profile.html
☑ css/style.css
☑ js/register.js
☑ js/login.js
☑ js/profile.js
☑ php/config.php
☑ php/db_mysql.php
☑ php/db_mongo.php
☑ php/redis.php
☑ php/register.php
☑ php/login.php
☑ php/profile.php
☑ php/logout.php
☑ composer.json
☑ composer.lock
☑ vendor/
```

Also verify:

```text
☑ MySQL tested
☑ Registration tested
☑ Login tested
☑ Profile update tested
☑ Refresh tested
☑ Logout tested
☑ LocalStorage tested
☑ Redis tested
☑ Direct profile access tested
☑ Responsive UI tested
☑ No temporary test files
☑ No PHP session usage
```

---

# 👩‍💻 Project Information

**Project Name:** GUVI User Portal

**Project Type:** User Registration, Authentication and Profile Management System

**Purpose:** GUVI Internship Assignment

### Technology Stack

```text
HTML5
CSS3
JavaScript
jQuery
Bootstrap 5
PHP 8
MySQL
Redis
Memurai
MongoDB
Composer
PDO
```

---

# ✅ Conclusion

The **GUVI User Portal** provides a complete user registration, authentication, and profile management workflow.

The project demonstrates:

* User registration
* Client-side and server-side validation
* Secure password hashing
* User authentication
* Browser LocalStorage-based login state
* Redis token management
* Token expiration
* MySQL user and profile storage
* PDO prepared statements
* AJAX-based frontend-backend communication
* Responsive Bootstrap design
* Modern user interface
* Profile management
* Secure logout
* Separate frontend and backend architecture

The application follows the required workflow:

```text
Register
   ↓
Login
   ↓
Profile
   ↓
Update Profile
   ↓
Logout
```

The project is ready for final testing and internship submission.
