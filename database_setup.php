<?php
try {
    // Connect to MySQL without specifying a database
    $db = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', 'jfrog123');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the database exists, and create it if it doesn't
    $db->exec('CREATE DATABASE IF NOT EXISTS todo_db');
    
    // Switch to the todo_db database
    $db->exec('USE todo_db');

    // Create todos table
    $db->exec('CREATE TABLE IF NOT EXISTS todos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title TEXT NOT NULL,
        description TEXT,
        completed TINYINT DEFAULT 0
    )');

    // Seed todos
    $db->exec("INSERT IGNORE INTO todos (id, title, description, completed) VALUES 
        (1, 'Finish Project', 'Complete the PHP MVC app', 0),
        (2, 'Buy Groceries', 'Milk, bread, eggs', 1)");

    echo "Database setup complete.";
} catch (PDOException $e) {
    die('Setup failed: ' . $e->getMessage());
}
?>