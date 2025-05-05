<?php
class TodoModel extends Model {
    private $crud;

    public function __construct() {
        parent::__construct();
        $this->crud = new \Lib\CrudOperations($this->db, 'tasks');
    }

    public function getTodos($sort = '') {
        $options = [];
        if ($sort === 'asc') {
            $options['order_by'] = 'title ASC';
        } elseif ($sort === 'desc') {
            $options['order_by'] = 'title DESC';
        }
        return $this->crud->get(null, $options);
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