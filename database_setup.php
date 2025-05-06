<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get values from .env
$host = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$charset = $_ENV['DB_CHARSET'];

// Now you can use the variables like this:
$dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";
try {
    $db = new PDO("mysql:host=$host;charset=$charset", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET $charset COLLATE utf8mb4_unicode_ci");

    $db = new PDO($dsn, $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec('
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ');

    // Create tags table
    $db->exec('
        CREATE TABLE IF NOT EXISTS tags (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL UNIQUE
        )
    ');
    $db->exec('ALTER TABLE tags ADD description TEXT DEFAULT NULL');

    
    // Create tasks table
    $db->exec('
        CREATE TABLE IF NOT EXISTS tasks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            due_date DATE,
            priority ENUM("low", "medium", "high") DEFAULT "medium",
            status ENUM("pending", "completed", "canceled") DEFAULT "pending",
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        )
    ');

    // Create task_tag table
    $db->exec('
        CREATE TABLE IF NOT EXISTS task_tag (
            id INT AUTO_INCREMENT PRIMARY KEY,
            task_id INT,
            tag_id INT,
            FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
            FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
        )
    ');

    echo "Database setup complete.";
    echo "Database setup complete.";
} catch (PDOException $e) {
    echo "Database setup failed: " . $e->getMessage();
}