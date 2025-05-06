<?php
class TaskController extends Controller
{
    private $taskModel;
    private $tagModel;
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->taskModel = new TodoModel();
        $this->tagModel = new TagModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $sort = $this->request->input('sort', '');
        $tasks = $this->taskModel->getTasks($sort);

        // Enrich tasks with tags and user data
        foreach ($tasks as &$task) {
            $task['tags'] = $this->taskModel->getTagsByTask($task['id']);
            $task['user'] = $task['user_id'] ? $this->userModel->getUser($task['user_id']) : null;
            // Log task data for debugging
            error_log("Task {$task['id']}: " . print_r($task, true));
        }
        unset($task); // Unset reference to avoid issues

        $this->view('tasks/index', [
            'tasks' => $tasks,
            'activePage' => 'tasks',
            'errors' => $_SESSION['flash'] ?? [],
            'csrf_token' => $_SESSION['csrf_token'] ?? 'YOUR_CSRF_TOKEN'
        ]);
        unset($_SESSION['flash']);
    }

    public function show($id)
    {
        $task = $this->taskModel->getTask($id);
        if (!$task) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }
        $tags = $this->taskModel->getTagsByTask($id);
        $user = $task['user_id'] ? $this->userModel->getUser($task['user_id']) : null;
        $this->view('tasks/show', [
            'task' => $task,
            'tags' => $tags,
            'user' => $user,
            'activePage' => 'tasks'
        ]);
    }

    public function create()
    {
        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['title']);
                $data['description'] = $this->request->input('description', '');
                $data['due_date'] = $this->request->input('due_date', null);
                $data['priority'] = $this->validatePriority($this->request->input('priority', 'medium'));
                $data['status'] = $this->validateStatus($this->request->input('status', 'pending'));
                $userId = $this->request->input('user_id');
                if ($userId && !$this->userModel->getUser($userId)) {
                    throw new Exception("Invalid user ID.");
                }
                $data['user_id'] = $userId ?: null;
                $tagIds = $this->request->input('tags', []);

                // Validate tag IDs
                foreach ($tagIds as $tagId) {
                    if (!$this->tagModel->getTag($tagId)) {
                        throw new Exception("Invalid tag ID: $tagId");
                    }
                }

                $taskId = $this->taskModel->addTask($data);
                foreach ($tagIds as $tagId) {
                    $this->taskModel->assignTag($taskId, $tagId);
                }

                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Task created successfully'];
                header('Location: /tasks');
                exit;
            } catch (\Exception $e) {
                error_log("Create task error: " . $e->getMessage());
                $_SESSION['flash'] = ['type' => 'error', 'message' => $e->getMessage()];
                $_SESSION['form_data'] = $this->request->all();
                header('Location: /tasks/create');
                exit;
            }
        }

        $tags = $this->tagModel->getTags();
        $users = $this->userModel->getUsers();
        $errors = $_SESSION['flash'] ?? [];
        $formData = $_SESSION['form_data'] ?? [];
        unset($_SESSION['flash'], $_SESSION['form_data']);
        $this->view('tasks/create', [
            'tags' => $tags,
            'users' => $users,
            'errors' => $errors,
            'formData' => $formData,
            'activePage' => 'tasks'
        ]);
    }

    public function update($id)
    {
        $task = $this->taskModel->getTask($id);
        if (!$task) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['title']);
                $data['description'] = $this->request->input('description', '');
                $data['due_date'] = $this->request->input('due_date', null);
                $data['priority'] = $this->validatePriority($this->request->input('priority', 'medium'));
                $data['status'] = $this->validateStatus($this->request->input('status', 'pending'));
                $userId = $this->request->input('user_id');
                if ($userId && !$this->userModel->getUser($userId)) {
                    throw new Exception("Invalid user ID.");
                }
                // Handle user_id
                $userId = $this->request->input('user_id');
                if (!empty($userId) && !$this->userModel->getUser($userId)) {
                    throw new Exception("Invalid user ID.");
                }
                $data['user_id'] = !empty($userId) ? $userId : null;

                // Handle tags
                $tagIds = $this->request->input('tags', []);
                if (!is_array($tagIds)) {
                    throw new Exception("Tags must be an array.");
                }

                foreach ($tagIds as $tagId) {
                    if (!$this->tagModel->getTag($tagId)) {
                        throw new Exception("Invalid tag ID: $tagId");
                    }
                }


                // Update task
                $this->taskModel->updateTask($id, $data);

                // Update tags
                $currentTags = $this->taskModel->getTagsByTask($id);
                foreach ($currentTags as $tag) {
                    $this->taskModel->removeTag($id, $tag['id']);
                }
                foreach ($tagIds as $tagId) {
                    $this->taskModel->assignTag($id, $tagId);
                }

                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Task updated successfully'];
                header('Location: /tasks');
                exit;
            } catch (\Exception $e) {
                error_log("Update task error: " . $e->getMessage());
                $_SESSION['flash'] = ['type' => 'error', 'message' => $e->getMessage()];
                $_SESSION['form_data'] = $this->request->all();
                header("Location: /tasks/$id/edit");
                exit;
            }
        }

        $tags = $this->tagModel->getTags();
        $selectedTags = $this->taskModel->getTagsByTask($id);
        $users = $this->userModel->getUsers();
        $errors = $_SESSION['flash'] ?? [];
        $formData = $_SESSION['form_data'] ?? [];
        unset($_SESSION['flash'], $_SESSION['form_data']);
        $this->view('tasks/edit', [
            'task' => $task,
            'tags' => $tags,
            'selectedTags' => $selectedTags,
            'users' => $users,
            'errors' => $errors,
            'formData' => $formData,
            'activePage' => 'tasks'
        ]);
    }

    public function delete($id)
    {
        try {
            $task = $this->taskModel->getTask($id);
            if (!$task) {
                throw new Exception("Task not found.");
            }
            $this->taskModel->deleteTask($id);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Task deleted successfully'];
            header('Location: /tasks');
            exit;
        } catch (\Exception $e) {
            error_log("Delete task error: " . $e->getMessage());
            $_SESSION['flash'] = ['type' => 'error', 'message' => $e->getMessage()];
            header('Location: /tasks');
            exit;
        }
    }

    private function validatePriority($value)
    {
        $valid = ['low', 'medium', 'high'];
        if (!in_array($value, $valid)) {
            throw new Exception("Invalid priority value.");
        }
        return $value;
    }

    private function validateStatus($value)
    {
        $valid = ['pending', 'completed', 'canceled'];
        if (!in_array($value, $valid)) {
            throw new Exception("Invalid status value.");
        }
        return $value;
    }
}