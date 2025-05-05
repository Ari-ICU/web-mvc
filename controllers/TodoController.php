<?php
class TodoController extends Controller {
    private $todoModel;

    public function __construct() {
        parent::__construct();
        $this->todoModel = new TodoModel();
    }

    public function index() {
        $sort = $this->request->input('sort', '');
        $todos = $this->todoModel->getTodos($sort);
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
                $data['due_date'] = $this->request->input('due_date', null);
                $data['priority'] = $this->validatePriority($this->request->input('priority', 'medium'));
                $data['status'] = $this->validateStatus($this->request->input('status', 'pending'));
                $data['user_id'] = $this->request->input('user_id'); // Make sure to pass the user_id

                $this->todoModel->addTodo($data);
                header('Location: /todos');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
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
                $data['due_date'] = $this->request->input('due_date', null);
                $data['priority'] = $this->validatePriority($this->request->input('priority', 'medium'));
                $data['status'] = $this->validateStatus($this->request->input('status', 'pending'));

                $this->todoModel->updateTodo($id, $data);
                header('Location: /todos');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
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
            $this->todoModel->deleteTodo($id);
            header('Location: /todos');
            exit;
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function validatePriority($value) {
        $valid = ['low', 'medium', 'high'];
        if (!in_array($value, $valid)) {
            throw new Exception("Invalid priority value.");
        }
        return $value;
    }

    private function validateStatus($value) {
        $valid = ['pending', 'completed', 'canceled'];
        if (!in_array($value, $valid)) {
            throw new Exception("Invalid status value.");
        }
        return $value;
    }
}