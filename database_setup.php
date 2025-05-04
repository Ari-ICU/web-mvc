<?php
// database_setup.php - Updated to include todos table
try {
    $db = new PDO('mysql:host=localhost;dbname=todo_db;charset=utf8mb4', 'root', 'jfrog123');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create todos table
    $db->exec('CREATE TABLE IF NOT EXISTS todos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT,
        completed INTEGER DEFAULT 0
    )');
    
    // Seed todos
    $db->exec("INSERT OR IGNORE INTO todos (title, description, completed) VALUES ('Finish Project', 'Complete the PHP MVC app', 0)");
    $db->exec("INSERT OR IGNORE INTO todos (title, description, completed) VALUES ('Buy Groceries', 'Milk, bread, eggs', 1)");
    
    echo "Database setup complete.";
} catch (PDOException $e) {
    die('Setup failed: ' . $e->getMessage());
}
?>