<?php
class TagController extends Controller {
    private $tagModel;

    public function __construct() {
        parent::__construct();
        $this->tagModel = new TagModel();
    }

    public function index() {
        $sort = $this->request->get('sort', 'asc');
        $tags = $this->tagModel->getTags($sort);
        $this->view('tag/index', ['tags' => $tags, 'activePage' => 'tag']);
    }
    public function show($id) {
        $todo = $this->todoModel->getTag($id);
        if ($todo) {
            $this->view('tag/show', ['todo' => $todo]);
        } else {
            http_response_code(404);
            $this->view('errors/404');
        }
    }
    public function create (){
        if ($this->request->isMethod('POST')) {
            try {
                $data= $this->request->validate(['name']);
                $data['description'] = $this->request->input('description', 'NA');
                
                $this->todoModel->addTag($data);
                header('Location: /tag');
                exit;
            }catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
            $this->view('tag/create');
        }
    }
    public function update($id) {
        if ($this->request->isMethod('POST')) {
            try {
                $data = $this->request->validate(['name']);
                $data['description'] = $this->request->input('description', 'NA');
                
                $this->todoModel->updateTag($id, $data);
                header('Location: /tag');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }
        $this->view('tag/update', ['id' => $id]);
    }
    public function delete($id) {
        if ($this->request->isMethod('POST')) {
            try {
                $this->tagModel->deleteTag($id);
                header('Location: /tag');
                exit;
            } catch (\Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }
        $this->view('tag/delete', ['id' => $id]);
    }
}