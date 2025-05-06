<?php
class UserController extends Controller {
    private $userModel;
    private $taskModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->taskModel = new TodoModel();
    }

    public function index() {
        $sort = $this->request->input('sort', '');
        $options = [];
        if ($sort === 'asc') {
            $options['order_by'] = 'name ASC';
        } elseif ($sort === 'desc') {
            $options['order_by'] = 'name DESC';
        }
        $users = $this->userModel->getUsers($options);
        $this->view('users/index', ['users' => $users, 'activePage' => 'users']);
    }

    public function show($id) {
        $user = $this->userModel->getUser($id);
        if ($user) {
            $tasks = $this->taskModel->getTasksByUser($id);
            $this->view('users/show', ['user' => $user, 'tasks' => $tasks]);
        } else {
            http_response_code(404);
            $this->view('errors/404');
        }
    }

    public function create() {
        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['name', 'email', 'password']);
                $data['email'] = $this->validateEmail($data['email']);
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->userModel->addUser($data);
                header('Location: /users');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }

        $this->view('users/create');
    }

    public function update($id) {
        $user = $this->userModel->getUser($id);
        if (!$user) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['name', 'email']);
                $data['email'] = $this->validateEmail($data['email']);
                if ($password = $this->request->input('password')) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }
                $this->userModel->updateUser($id, $data);
                header('Location: /users');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }

        $this->view('users/edit', ['user' => $user]);
    }

    public function delete($id) {
        try {
            $this->userModel->deleteUser($id);
            header('Location: /users');
            exit;
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function validateEmail($value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }
        $existing = $this->userModel->getUserByEmail($value);
        if ($existing && $existing['id'] != $this->request->input('id')) {
            throw new Exception("Email address already in use.");
        }
        return $value;
    }
}