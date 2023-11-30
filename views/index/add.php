<div class="content">
	<h3 class="page_title">Добавление задачи</h3>	
	<div class="wrap-form">		
		<form class="add_edit_form" action="<?php echo URL; ?>index/add_task">
			<h3 class="form-header">Новая задача</h3>
			<div class="tc" id="status-bar"></div>
			<div class="wrap-fields">
				<div class="wrap-field">
					<label for="name">Имя *</label>
					<input type="text" name="user_name" id="name" required />
				</div>
				<div class="wrap-field">
					<label for="email">Email *</label>
					<input type="text" name="user_email" id="email" required/>
				</div>
				<div class="wrap-field">
					<label for="description">Описание *</label>
					<textarea name="description" id="description" rows="10"></textarea>
				</div>				
				<div class="wrap-field-btn">
					<input type="submit" class="btn btn-dark" name="go_back" value="Назад" data-link="<?php echo URL; ?>" />
					<input type="submit" class="btn btn-dark" name="action_btn" value="Добавить" />
				</div>
				<input type="hidden" name="status" value="0" />
			</div>
		</form>
	</div>
	<div class="wrap-answer">
		<div class="answer-message">Новая задача успешно добавлена!<br/>Можно добавить ещё задачу!</div>
		<div class="answer-buttons">
			<a class="answer-btn btn btn-dark" href="<?php echo URL;?>">Вернуться к списку задач</a>
			<a class="answer-btn adding btn btn-dark" href="">Добавить ещё задачу</a>
		</div>
	</div>
</div>