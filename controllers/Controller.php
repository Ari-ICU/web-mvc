<?php
class Controller {
    protected $request;

    public function __construct() {
        $this->request = new \Lib\Request();
    }

    protected function view($view, $data = []) {
        extract($data);
        require BASE_PATH . "/views/$view.php";
    }
}
?>