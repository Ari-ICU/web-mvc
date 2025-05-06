<?php
class UserModel extends Model {
    private $crud;

    public function __construct() {
        parent::__construct();
        $this->crud = new \Lib\CrudOperations($this->db, 'users');
    }

    public function getUsers($sort = '') {
        $options = [];
        if ($sort === 'asc') {
            $options['order_by'] = 'title ASC';
        } elseif ($sort === 'desc') {
            $options['order_by'] = 'title DESC';
        }
        return $this->crud->get(null, $options);
    }

    public function getUser($id) {
        return $this->crud->get($id);
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function addUser(array $data) {
        return $this->crud->add($data);
    }

    public function updateUser($id, array $data) {
        return $this->crud->update($id, $data);
    }

    public function deleteUser($id) {
        return $this->crud->delete($id);
    }
    
}