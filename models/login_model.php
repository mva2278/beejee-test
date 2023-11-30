<?php
class Login_Model extends Model {
	public function __construct() {
		parent::__construct();
	}
	public function run() {
		$login = $_POST['login'];
   		$password = $_POST['password'];
   		Session::init();
   		if($login == '' || $password == ''){
   			Session::set('failed','Заполните все поля');
			header('Location: ' . URL . 'login');
			die();
   		}
		$data = $this->db->select('users', 'id, role', ['login'=>$login, 'password'=>hash('sha256',$login.$password)]);
		if(count($data) > 0) {
			Session::set('loggedIn', true);
			Session::set('username', $login);
			Session::set('user_id', $data[0]['id']);
			Session::set('role', $data[0]['role']);
			header('Location: ' . URL);
		} else {
			Session::set('failed','Неверный логин или пароль');
			header('Location: ' . URL . 'login');
		}
	}
}
?>