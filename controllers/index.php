<?php
    class Index extends Controller {
        public function __construct() {
            parent::__construct();
            
        }
        public function index(){
            $this->view->title = 'Список задач';
            $this->view->tasks = $this->model->getTasks();
            $this->view->sort_links = $this->model->getCurrentSortLink();
            $this->view->render('index/index');
        }
        public function add(){
            $this->view->title = 'Добавление задачи';
            $this->view->render('index/add');
        }
        public function add_task(){
            $this->model->addTask();
        }
        public function save($id){            
            $this->model->editTask($id);
        }
        public function close($id){
            $this->model->closeTask($id);
        }
        public function logout() {
            Session::destroy();
            header('Location: '.URL);
            exit();
        }
    }
?>