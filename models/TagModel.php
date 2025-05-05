<?php
class TagModel extends Model {
    private $crud;

    public function __construct() {
        parent::__construct();
        $this->crud = new \Lib\CrudOperations($this->db, 'tags');
    }

    public function getTags($sort = '') {
        $options = [];
        if ($sort === 'asc') {
            $options['order_by'] = 'name ASC';
        } elseif ($sort === 'desc') {
            $options['order_by'] = 'name DESC';
        }
        return $this->crud->get(null, $options);
    }

    public function getTag($id) {
        return $this->crud->get($id);
    }

    public function addTag(array $data) {
        return $this->crud->add($data);
    }

    public function updateTag($id, array $data) {
        return $this->crud->update($id, $data);
    }

    public function deleteTag($id) {
        return $this->crud->delete($id);
    }

    // Get tasks associated with a tag
    public function getTasksByTag($tagId) {
        $stmt = $this->db->prepare('
            SELECT t.*
            FROM tasks t
            JOIN task_tag tt ON t.id = tt.task_id
            WHERE tt.tag_id = :tag_id
        ');
        $stmt->execute([':tag_id' => $tagId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Assign a tag to a task
    public function assignTagToTask($tagId, $taskId) {
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
    public function removeTagFromTask($tagId, $taskId) {
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