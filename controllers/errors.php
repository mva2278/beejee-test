<?php
    class Errors extends Controller {
        public function __construct() {
            parent::__construct();
        }
        public function index(){
            $result = array();
            $result['code'] = '404';
            $result['message'] = 'Страницы не существует';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }
?>