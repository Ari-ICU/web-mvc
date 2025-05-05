<?php class TagModel extends Model {
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
}