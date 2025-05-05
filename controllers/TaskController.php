<?php
class TaskController extends Controller {
    private $taskModel;
    private $tagModel;

    public function __construct() {
        parent::__construct();
        $this->taskModel = new TodoModel(); // TodoModel uses 'tasks' table
        $this->tagModel = new TagModel();
    }

    public function index() {
        $sort = $this->request->input('sort', '');
        $tasks = $this->taskModel->getTasks($sort);
        $this->view('tasks/index', ['tasks' => $tasks, 'activePage' => 'tasks']);
    }

    public function show($id) {
        $task = $this->taskModel->getTask($id);
        if ($task) {
            $tags = $this->taskModel->getTagsByTask($id);
            $this->view('tasks/show', ['task' => $task, 'tags' => $tags]);
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
                $data['user_id'] = $this->request->input('user_id'); // Ensure user_id is passed
                $tagIds = $this->request->input('tags', []);

                $taskId = $this->taskModel->addTask($data);
                foreach ($tagIds as $tagId) {
                    $this->taskModel->assignTag($taskId, $tagId);
                }
                header('Location: /tasks');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }

        $tags = $this->tagModel->getTags();
        $this->view('tasks/create', ['tags' => $tags]);
    }

    public function update($id) {
        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['title']);
                $data['description'] = $this->request->input('description', '');
                $data['due_date'] = $this->request->input('due_date', null);
                $data['priority'] = $this->validatePriority($this->request->input('priority', 'medium'));
                $data['status'] = $this->validateStatus($this->request->input('status', 'pending'));
                $tagIds = $this->request->input('tags', []);

                $this->taskModel->updateTask($id, $data);
                // Clear existing tags and assign new ones
                $this->db->prepare('DELETE FROM task_tag WHERE task_id = :task_id')->execute([':task_id' => $id]);
                foreach ($tagIds as $tagId) {
                    $this->taskModel->assignTag($id, $tagId);
                }
                header('Location: /tasks');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }

        $task = $this->taskModel->getTask($id);
        if ($task) {
            $tags = $this->tagModel->getTags();
            $selectedTags = $this->taskModel->getTagsByTask($id);
            $this->view('tasks/edit', ['task' => $task, 'tags' => $tags, 'selectedTags' => $selectedTags]);
        } else {
            http_response_code(404);
            $this->view('errors/404');
        }
    }

    public function delete($id) {
        try {
            $this->taskModel->deleteTask($id);
            header('Location: /tasks');
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