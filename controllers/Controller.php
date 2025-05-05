<?php
class Controller {
    protected $request;

    public function __construct() {
        $this->request = new \Lib\Request();
    }

    protected function view($view, $data = []) {
        // Check if the view file exists
        $viewPath = BASE_PATH . "/views/$view.php";

        if (file_exists($viewPath)) {
            extract($data);
            require $viewPath;
        } else {

            http_response_code(404); 
            $this->view('errors/404');
        }
    }
}
?>