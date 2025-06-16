CREATE DATABASE olx;

USE olx;

CREATE TABLE registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(15),
    gender ENUM('male', 'female') NOT NULL,
    role ENUM('buyer', 'seller') NOT NULL,
    stdFaculty ENUM('student', 'faculty') NOT NULL,
    password VARCHAR(255) NOT NULL
);
