<?php

use Lib\Request;
class Controller {
    public function loadModel($model) {
        require_once "../app/models/$model.php";
        return new $model();
    }
    protected $request;

    public function __construct() {
        $this->request = new Request(); // assuming you have a Request class
    }
    public function view($view, $data = []) {
        extract($data);
        $file = __DIR__ . '/../views/' . $view . '.php'; // Go up one directory to mvc/views/
    
        if (file_exists($file)) {
            require_once $file;
        } else {
            http_response_code(500);
            echo "View file not found: $file";
            exit;
        }
    }
    
}
?>