<?php
class TodoModel extends Model {
    private $crud;

    public function __construct() {
        parent::__construct();
        $this->crud = new \Lib\CrudOperations($this->db, 'todos');
    }

    public function getTodos() {
        return $this->crud->get();
    }

    public function getTodo($id) {
        return $this->crud->get($id);
    }

    public function addTodo(array $data) {
        return $this->crud->add($data);
    }

    public function updateTodo($id, array $data) {
        return $this->crud->update($id, $data);
    }

    public function deleteTodo($id) {
        return $this->crud->delete($id);
    }
}
?>