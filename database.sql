CREATE DATABASE IF NOT EXISTS todolist;
USE todolist;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    due_date DATE NULL,
    priority ENUM('Faible', 'Moyen', 'Urgent') DEFAULT 'Moyen',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);