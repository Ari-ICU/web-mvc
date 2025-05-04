<?php
class TodoController extends Controller {
    private $todoModel;

    public function __construct() {
        parent::__construct();
        $this->todoModel = new TodoModel();
    }

    public function index() {
        $todos = $this->todoModel->getTodos();
        $this->view('todos/index', ['todos' => $todos]);
    }

    public function show($id) {
        $todo = $this->todoModel->getTodo($id);
        if ($todo) {
            $this->view('todos/show', ['todo' => $todo]);
        } else {
            http_response_code(404);
            $this->view('errors/404');
        }
    }

    public function create() {
        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['title']);
                $data['description'] = $this->request->input('description', '');
                $data['completed'] = $this->request->input('completed', 0);
                $data['post_date'] = $this->request->input('post_date', null);
                $data['deadline'] = $this->request->input('deadline', null);
    
                $success = $this->todoModel->addTodo($data);
                header('Location: /todos');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }
    
        $this->view('todos/create');
    }
    

    public function update($id) {
        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['title']);
                $data['description'] = $this->request->input('description', '');
                $data['completed'] = $this->request->input('completed', 0);
                $data['post_date'] = $this->request->input('post_date', null);
                $data['deadline'] = $this->request->input('deadline', null);
                $success = $this->todoModel->updateTodo($id, $data);
                header('Location: /todos');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                return json_encode(['error' => $e->getMessage()]);
            }
        }
        $todo = $this->todoModel->getTodo($id);
        if ($todo) {
            $this->view('todos/edit', ['todo' => $todo]);
        } else {
            http_response_code(404);
            $this->view('errors/404');
        }
    }

    public function delete($id) {
        try {
            $success = $this->todoModel->deleteTodo($id);
            header('Location: /todos');
            exit;
        } catch (\Exception $e) {
            http_response_code(400);
            return json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>