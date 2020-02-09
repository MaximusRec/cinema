<?php

include $_SERVER['DOCUMENT_ROOT'] . "/application/" . "usersClass.php";	

class Model_User extends Model
{
	var $pdo;
	
	public function __construct()
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/db/" . "pdoconnect.php";	
        $this->pdo = $pdo; //   инициализируем БД
    }
	
	public function get_data()
	{			
		if ( !empty($_POST['login']) AND !empty( $_POST['password']) )
		{
				$obj = NEW Users; 
				$user = $obj->findUser( $_POST['login'], $_POST['password'] );
				
				if (isset ($user) )
				{	
					$_SESSION['access'] = 'yes';
					$_SESSION['login'] = $_POST ['login'];
					$_SESSION['pass'] = $_POST['password'];
					$_SESSION['qnt'] = 1;
					if (!empty($_SESSION['login'])) $_SESSION['lasttime'] = time();
					$_SESSION['error'] = 'ok';
				} else {
					$_SESSION['access'] = 'no';
					$_SESSION['lasttime'] = time() + ( 1 * 60 );
				}			
				return $user;
		} 
		else return NULL;
		
	}


}
