<?php
class Model {
    protected $db;

    public function __construct() {
        try {
            $this->db = new PDO('sqlite:' . BASE_PATH . '/database.db');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
}
?>