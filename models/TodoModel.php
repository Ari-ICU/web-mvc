<?php
class TodoModel extends Model {
    private $crud;

    public function __construct() {
        parent::__construct();
        $this->crud = new \Lib\CrudOperations($this->db, 'tasks');
    }

    public function getTasks($sort = '') {
        $options = [];
        if ($sort === 'asc') {
            $options['order_by'] = 'title ASC';
        } elseif ($sort === 'desc') {
            $options['order_by'] = 'title DESC';
        }
        return $this->crud->get(null, $options);
    }

    public function getTask($id) {
        return $this->crud->get($id);
    }

    public function addTask(array $data) {
        return $this->crud->add($data);
    }

    public function updateTask($id, array $data) {
        return $this->crud->update($id, $data);
    }

    public function deleteTask($id) {
        return $this->crud->delete($id);
    }

    // Get tags associated with a task
    public function getTagsByTask($taskId) {
        $stmt = $this->db->prepare('
            SELECT t.*
            FROM tags t
            JOIN task_tag tt ON t.id = tt.tag_id
            WHERE tt.task_id = :task_id
        ');
        $stmt->execute([':task_id' => $taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Assign a tag to a task
    public function assignTag($taskId, $tagId) {
        $stmt = $this->db->prepare('
            INSERT IGNORE INTO task_tag (task_id, tag_id)
            VALUES (:task_id, :tag_id)
        ');
        $stmt->execute([
            ':task_id' => $taskId,
            ':tag_id' => $tagId
        ]);
        return $stmt->rowCount();
    }

    // Remove a tag from a task
    public function removeTag($taskId, $tagId) {
        $stmt = $this->db->prepare('
            DELETE FROM task_tag
            WHERE task_id = :task_id AND tag_id = :tag_id
        ');
        $stmt->execute([
            ':task_id' => $taskId,
            ':tag_id' => $tagId
        ]);
        return $stmt->rowCount();
    }


    
}