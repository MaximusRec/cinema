<?php
include $_SERVER['DOCUMENT_ROOT'] . "/application/" . "usersClass.php";	

class Model_Enter extends Model
{
	var $errorTime = 5;	//	Время в минутах блокировки после 3 неправильных входов
	var $countErrorEnter = 3;	//	Количество попыток
	
	public function get_data()
	{
	    if ( !empty($_POST['login']) AND !empty( $_POST['password']) )
		{	
				$obj = NEW Users; 
				$data = $obj->findUser( $_POST['login'], $_POST['password'] );
				
				if (isset($data) )
				{	
					$_SESSION['access'] = 'yes';
					$_SESSION['login'] = $data['login'];
					$_SESSION['pass'] = $data['pass'];
					$_SESSION['qnt'] = 1;
					$_SESSION['lasttime'] = time();
					$_SESSION['error'] = 'ok';

					
				} else { 
					$_SESSION['errorCount'] = 2;
					$_SESSION['access'] = 'no';
					$_SESSION['lasttime'] = time() + ( $this->errorTime * 60 );
					$_SESSION['qnt'] = $_SESSION['qnt'] + 1;
					
					if ( $_SESSION['qnt'] > $this->countErrorEnter ) 
					{			
							if ( $_SESSION['lasttime'] > time() )
							{
								$data['error'] = "error"; 
								$data['error_message'] = "Вход заблокирован.<br>Попробуйте еще раз через " . ($_SESSION['lasttime'] - time()) . " секунд.";
							} 							
					} 
				return $data;
				}			
		} else {
				
			if ( isset ($_SESSION['lasttime']) AND isset ( $_SESSION['qnt'] )  ) {	
				if ( $_SESSION['lasttime'] > time() AND ( $_SESSION['qnt'] > $this->countErrorEnter )  )
					{							
						$data['error'] = "error"; 
						$data['error_message'] = "Вход заблокирован.<br>Попробуйте еще раз через " . ($_SESSION['lasttime'] - time()) . " секунд.";
					} else {
						if ( ( $_SESSION['qnt'] > 0 ) )
							{   $data['error'] = 'ok';
								$data['error_message2'] = "<strong>Неверные данные</strong>";   
								if ($_SESSION['errorCount'] > 0) $_SESSION['errorCount']--;
						} else {
								$data['error'] = 'ok';
								unset ($_SESSION['error']);
						}
						
					}
					return $data;
		} else {
				$data['error'] = 'ok'; 
				return $data;}
		}
		
	}

}
