
CREATE DATABASE IF NOT EXISTS guvi_portal;

USE guvi_portal;

CREATE TABLE IF NOT EXISTS users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    password_hash VARCHAR(255) NOT NULL,

    age VARCHAR(10) NULL,

    dob DATE NULL,

    contact VARCHAR(20) NULL,

    city VARCHAR(100) NULL,

    address TEXT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

