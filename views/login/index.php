<div id="login_content" class="col-md-12 login">
	<div class="panel-heading">
		<h3>ВХОД</h3>
		<span>вход в личный кабинет</span>
	</div>
  	<div class="login_body">
  		<form action="login/run" method="post">
  			<div class="wrap-fields">
  				<div class="wrap-field">
  					<label for="login">Логин* :</label>
  					<input type="text" name="login" id="login" />
  				</div>
  				<div class="wrap-field">
  					<label for="password">Пароль* :</label>
  					<input type="password" name="password" id="password" />
  				</div>
  				<div class="bad_mes tc"><?php echo (Session::get('failed') !== null) ? Session::get('failed') : '';?></div>
  				<div class="wrap-field-btn">
  					<button type="submit" class="btn btn-dark">Войти</button>
  				</div>
  			</div>
  		</form>
	</div>
</div>
