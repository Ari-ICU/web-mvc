<?php
try {
    $db = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', 'jfrog123');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it doesn't exist
    $db->exec('CREATE DATABASE IF NOT EXISTS todo_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');

    // Reconnect to the new DB
    $db = new PDO('mysql:host=localhost;dbname=todo_db;charset=utf8mb4', 'root', 'jfrog123');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table with all columns at once
    $db->exec('CREATE TABLE IF NOT EXISTS todos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title TEXT NOT NULL,
        description TEXT,
        completed TINYINT DEFAULT 0,
       
    )');

    $db->exec("ALTER TABLE todos 
        ADD COLUMN post_date DATE NULL,
        ADD COLUMN deadline DATE NULL,
        ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ");


    echo "Database setup complete.";
} catch (PDOException $e) {
    echo "Database setup failed: " . $e->getMessage();
}
?>