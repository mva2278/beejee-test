<?php
class Index_Model extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function getTasks(){
		$res = array();
		$res['total_pages'] = ceil(count($this->db->select('tasks', '*'))/COUNT_PAGES);
		$sql = "SELECT * FROM tasks";
		$where = '';
		$sort = '';
		Session::set('s', null);
		if(isset($_GET['s'])){
			$sort = ' ORDER BY';
			switch ($_GET['s']) {
				case 'name':
					$sort .= ' user_name';
					Session::set('s', 'name');
					break;
				case 'email':
					$sort .= ' user_email';
					Session::set('s', 'email');
					break;
				case 'status':
					$sort .= ' status';
					Session::set('s', 'status');
					break;
				default:
					$sort = '';
					break;
			}
		}
		Session::set('d', null);
		if(isset($_GET['d'])){
			$sort .= ' DESC';
			Session::set('d', 'desc');
		}
		$limit = ' LIMIT ' . COUNT_PAGES;
		Session::set('p', 1);
		if(isset($_GET['p'])){
			$p = (int) $_GET['p'];
			$limit .= ' OFFSET ' . ($p-1) * COUNT_PAGES;
			Session::set('p', $p);
		}
		
		$res['tasks_list'] = $this->db->sql($sql, $where, $sort, $limit);

		return $res;
	}

	public function getCurrentSortLink(){
		$sort_links = array();
		if(Session::get('d') == null){
			$current_direction = '';
			$direction = '&d=desc';
		}else{
			$current_direction = '&d=desc';
			$direction = '';
		}
		$page = ((Session::get('p') == null) || (Session::get('p') == 1)) ? '' : '&p='.Session::get('p');
		$sort_links['name_link'] = '?s=name' . $page;
		$sort_links['email_link'] = '?s=email' . $page;
		$sort_links['status_link'] = '?s=status' . $page;
		$sort_links['current_link'] = (Session::get('s') == null) ? '' : '?s=' . Session::get('s') . $current_direction;
		switch (Session::get('s')) {
			case 'name':
				$sort_links['name_link'] .= $direction;
				break;
			case 'email':
				$sort_links['email_link'] .= $direction;
				break;
			case 'status':
				$sort_links['status_link'] .= $direction;
				break;
			default:
				break;
		}
		return $sort_links;
	}

	public function addTask(){
		$post = $_POST;
		if($post['user_name']==''){
			echo json_encode(['fail'=>true, 'tag'=>'#name', 'mes'=>'<span class="bad_mes">Заполните имя</span>'], JSON_UNESCAPED_UNICODE); return;
		}
		if($post['user_email']==''){
			echo json_encode(['fail'=>true, 'tag'=>'#email', 'mes'=>'<span class="bad_mes">Заполните email</span>'], JSON_UNESCAPED_UNICODE); return;
		}
		if(!filter_var($post['user_email'], FILTER_VALIDATE_EMAIL)){
			echo json_encode(['fail'=>true, 'tag'=>'#email', 'mes'=>'<span class="bad_mes">Еmail должен быть валидным</span>'], JSON_UNESCAPED_UNICODE); return;
		}
		if($post['description']==''){
			echo json_encode(['fail'=>true, 'tag'=>'#description', 'mes'=>'<span class="bad_mes">Заполните описание</span>'], JSON_UNESCAPED_UNICODE); return;
		}		
		$res = $this->db->insert('tasks', $post);
		echo json_encode(['ok'=>$res, 'add'=>true], JSON_UNESCAPED_UNICODE);
	}

	public function closeTask($id){
		$status = $this->db->select('tasks', 'status', ['id'=>$id])[0]['status'];
		$new_status = $status == 0 ? 1 : 3;
		$res = $this->db->update('tasks', ['status'=>$new_status], ['id'=>$id]);
		echo json_encode(['ok'=>$res], JSON_UNESCAPED_UNICODE);
	}

	public function editTask($id){
		if(Session::get('loggedIn')== null){
			echo json_encode(['access'=>false, 'url'=>URL.'login'], JSON_UNESCAPED_UNICODE);
			return;
		}
		$post = $_POST;
		$desc = $this->db->select('tasks', 'description', ['id'=>$id])[0]['description'];
		$res = true;
		if($desc != $post['description']){
			$res = $this->db->update('tasks', ['description'=>$post['description'], 'status'=>2], ['id'=>$id]);
		}		
		echo json_encode(['access'=>false, 'ok'=>$res], JSON_UNESCAPED_UNICODE);
	}
}
?>