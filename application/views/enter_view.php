 <form name="input" action="enter" method="post">
<h1>Пожалуйста, авторизируйтесь!</h1><hr>
  <?php if ( isset($data['error_message2']) AND ($_SESSION['errorCount'] > 0 ) ): ?>
		<br><p><?= $data['error_message2']; ?></p><br>		
	<?php endif; ?>	
	
<?php if ( $data['error'] ==  'ok' ): ?>
<p>
  <p><b>Ваше имя:</b><br>
   <input type="text" name="login" size="40">
 </p> 
 
 <p><b>Ваш пароль:</b><br>
   <input type="password" name="password" size="40">
 </p>
<p></p>
	<p>
		<input type="submit" name="enter" value="Войти">
	</p>

<?php else: ?>
	<?= $data['error_message']; ?>		
<?php endif; ?>	
	
</form>

