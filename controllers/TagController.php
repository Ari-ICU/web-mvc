<?php
class TagController extends Controller {
    private $tagModel;

    public function __construct() {
        parent::__construct();
        $this->tagModel = new TagModel();
    }

    public function index() {
        $sort = $this->request->input('sort', 'asc');
        $tags = $this->tagModel->getTags($sort);
        $this->view('tags/index', ['tags' => $tags, 'activePage' => 'tags']);
    }

    public function show($id) {
        $tag = $this->tagModel->getTag($id);
        if ($tag) {
            $tasks = $this->tagModel->getTasksByTag($id);
            $this->view('tags/show', ['tag' => $tag, 'tasks' => $tasks, 'activePage' => 'tags']);
        } else {
            http_response_code(404);
            $this->view('errors/404');
        }
    }

    public function create() {
        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['name']);
                $data['description'] = $this->request->input('description', 'NA');
                $this->tagModel->addTag($data);
                header('Location: /tags');
                exit;
            } catch (\Exception $e) {
                $errors = [$e->getMessage()];
                $data = [
                    'name' => $this->request->input('name', ''),
                    'description' => $this->request->input('description', '')
                ];
                $this->view('tags/create', ['errors' => $errors, 'data' => $data, 'activePage' => 'tags']);
                return;
            }
        }
        $this->view('tags/create', ['activePage' => 'tags']);
    }

    public function update($id) {
        $tag = $this->tagModel->getTag($id);
        if (!$tag) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['name']);
                $data['description'] = $this->request->input('description', 'NA');
                $this->tagModel->updateTag($id, $data);
                header('Location: /tags');
                exit;
            } catch (\Exception $e) {
                $errors = [$e->getMessage()];
                $inputData = [
                    'name' => $this->request->input('name', $tag['name']),
                    'description' => $this->request->input('description', $tag['description'] ?? '')
                ];
                $this->view('tags/edit', ['id' => $id, 'tag' => $tag, 'errors' => $errors, 'data' => $inputData, 'activePage' => 'tags']);
                return;
            }
        }

        $this->view('tags/edit', ['id' => $id, 'tag' => $tag, 'activePage' => 'tags']);
    }

    public function delete($id) {
        if ($this->request->isMethod('POST')) {
            try {
                $this->tagModel->deleteTag($id);
                header('Location: /tags');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }
        $this->view('tags/delete', ['id' => $id, 'activePage' => 'tags']);
    }
}