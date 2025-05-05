<?php
namespace Lib;

use PDO;
use PDOException;

class CrudOperations {
    private $db;
    private $table;

    /**
     * Constructor initializes database connection and table name
     * @param PDO $db Database connection
     * @param string $table Table name
     */
    public function __construct(PDO $db, string $table) {
        $this->db = $db;
        $this->table = $table;
    }

    /**
     * Get all records or a single record by ID
     * @param int|null $id Optional record ID
     * @param array $options Optional conditions and sorting
     * @return array|null
     */
    public function get(?int $id = null, array $options = []): ?array {
        try {
            $query = "SELECT * FROM {$this->table}";
            $params = [];
            
            if ($id !== null) {
                $query .= " WHERE id = ?";
                $params[] = $id;
            } elseif (!empty($options['conditions'])) {
                $query .= " WHERE " . $this->buildConditions($options['conditions'], $params);
            }

            if (!empty($options['order_by'])) {
                $query .= " ORDER BY " . $options['order_by'];
            }

            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            
            return $id !== null ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Error fetching records: " . $e->getMessage());
        }
    }

    /**
     * Add a new record
     * @param array $data Data to insert
     * @return int Last inserted ID
     */
    public function add(array $data): int {
        try {
            $fields = array_keys($data);
            $placeholders = array_fill(0, count($fields), '?');
            
            $query = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                     VALUES (" . implode(', ', $placeholders) . ")";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute(array_values($data));
            
            return (int) $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new \Exception("Error adding record: " . $e->getMessage());
        }
    }

    /**
     * Update an existing record
     * @param int $id Record ID
     * @param array $data Data to update
     * @return bool Success status
     */
    public function update(int $id, array $data): bool {
        try {
            $fields = array_keys($data);
            $setClause = implode(', ', array_map(fn($field) => "$field = ?", $fields));
            
            $query = "UPDATE {$this->table} SET $setClause WHERE id = ?";
            
            $stmt = $this->db->prepare($query);
            $params = array_values($data);
            $params[] = $id;
            
            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw new \Exception("Error updating record: " . $e->getMessage());
        }
    }

    /**
     * Delete a record
     * @param int $id Record ID
     * @return bool Success status
     */
    public function delete(int $id): bool {
        try {
            $query = "DELETE FROM {$this->table} WHERE id = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new \Exception("Error deleting record: " . $e->getMessage());
        }
    }

    /**
     * Build SQL conditions from array
     * @param array $conditions
     * @param array &$params
     * @return string
     */
    private function buildConditions(array $conditions, array &$params): string {
        $clauses = [];
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $clauses[] = "$field IN (" . implode(',', array_fill(0, count($value), '?')) . ")";
                $params = array_merge($params, $value);
            } else {
                $clauses[] = "$field = ?";
                $params[] = $value;
            }
        }
        return implode(' AND ', $clauses);
    }
}
?>