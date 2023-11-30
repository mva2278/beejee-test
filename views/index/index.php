<?
	$role = Session::get('role');
	$tasks = $this->tasks['tasks_list'];
	$total_pages = $this->tasks['total_pages'];
	$sort_links = $this->sort_links;
	$cur_link = $sort_links['current_link'];
	$symb = ($cur_link == '') ? '?' : '&';
?>
<div class="content">
	<div class="wrap-login">
		<? 
			if($role !== null){
				$log_txt = 'Выйти';
				$log_link = URL . 'index/logout';
			}else{
				$log_txt = 'Войти';
				$log_link = URL . 'login';
			}
		?>
		<a class="btn btn-light" href="<? echo $log_link; ?>"><? echo $log_txt; ?></a>
	</div>
	<h3 class="page_title">Задачи</h3>
	<div>
		<div class="add_btn"><a href="<? echo URL?>index/add">Добавить задачу</a></div>
		<? if(gettype($tasks) !== null): ?>
		<table class="table table-striped align-middle">
			<thead class="table-dark tc">
				<tr>
					<th>Описание</th>
					<th><a class="sort-link" href="<? echo URL.$sort_links['name_link']; ?>">Пользователь</a></th>
					<th><a class="sort-link" href="<? echo URL.$sort_links['email_link']; ?>">E-mail</a></th>
					<th><a class="sort-link" href="<? echo URL.$sort_links['status_link']; ?>">Статус</a></th>
					<? if($role == 'admin') :?>
						<th>Действия</th>
					<? endif; ?>
				</tr>
			</thead>
			<?
				foreach ($tasks as $task) {	
					$desc = $task['description'];				
					$name = $task['user_name'];					
					$email = $task['user_email'];
					$status = ($task['status'] == 0 || $task['status'] == 2) ? '<i title="Невыполнено" class="fa-solid fa-xmark"></i>' : '<i title="Выполнено" class="fa-solid fa-check"></i>';
					$dop_status = ($task['status'] == 2 || $task['status'] == 3) ? '<i title="Изменено администратором" class="fa-solid fa-marker"></i>' : '';						
					echo '<tr>';
					$edit_field = '';
					if($role == 'admin'){
						$edit_field = '<div class="edit-area wrap-actions">';
						$edit_field .= '<textarea name="description" rows="5">' . $desc . '</textarea>';
						$edit_field .= '</div>';
					}
					echo '<td><div class="wrap-desc">' .$desc.'</div>' .$edit_field. '</td>';
			   		echo '<td class="tc">'.$name.'</td>';
			   		echo '<td class="tc">'.$email.'</td>';
			   		echo '<td class="tc fs-4">'.$status.$dop_status.'</td>';
			   		if($role == 'admin'){
			   			echo '<td>';
			   			if($task['status'] == 0 || $task['status'] == 2){
				   			$actions = '<a class="edit" title="Редактировать" href="#"><i class="fa-solid fa-pen-to-square"></i></a>';
				   			$actions .= '<a class="task greens save" title="Завершить" href="index/save/'.$task['id'].'"><i class="fa-solid fa-floppy-disk"></i></a>';
	                    	$actions .= '<a class="task greens" title="Завершить" href="index/close/'.$task['id'].'"><i class="fa-solid fa-circle-check"></i></a>';					
							echo '<div class="wrap-actions">' . $actions . '</div>';
				   		} 
				   		echo '</td>';
			   		}			   		
					echo '</tr>';
				}
			?>
		</table>
		<? else: ?>
			<div class="message">Задачи отсутствуют.</div>
		<? endif;?>
	</div>
	<? if($total_pages > 1): ?>
		<div class="wrap-pagination">
			<ul class="pagination">
				<li>
					<a class="btn btn-light" href="<? echo URL.$cur_link; ?>">
						<i class="fa fa-fast-backward"></i>
					</a>
				</li>
				<?
					for ($i=1; $i<=$total_pages; $i++) {
						$get_param = '';
						$class = ' btn-light';
						if($i>1){
							$get_param = $symb.'p=' . $i;
						}
						if($i == Session::get('p')){
							$class = ' btn-dark';
						}
						echo '<li><a class="btn'.$class.'" href="' . URL.$cur_link .$get_param.'">'.$i.'</a></li>';
					}
				?>
				<li>
					<a class="btn btn-light" href="<? echo URL.$cur_link.$symb ?>p=<? echo $total_pages; ?>">
						<i class="fa fa-fast-forward"></i>
					</a>
				</li>
			</ul>
		</div>
	<? endif; ?>
</div>