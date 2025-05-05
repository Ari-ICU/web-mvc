<?php
require_once __DIR__ . '/../vendor/autoload.php'; // adjust path as needed

use Dotenv\Dotenv;

class Model {
    protected $db;

    public function __construct() {
        try {
            // Load .env variables
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // assuming .env is one level above
            $dotenv->load();

            $host = $_ENV['DB_HOST'];
            $dbName = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];
            $charset = $_ENV['DB_CHARSET'];

            $dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
}
?>