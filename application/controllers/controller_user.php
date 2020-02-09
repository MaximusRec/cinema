<?php

class Controller_User extends Controller
{
	function __construct()
	{
		$this->model = new Model_User();
		$this->view = new View();
	}
	
	function action_index()
	{	
			if ( isset ($_POST['quit'] ) ) { 
					unset ($_SESSION);
					session_destroy();
			}  
			
			if ( $this->authorization() == FALSE )	
			{   		$this->redirect( 'enter' );
			} else  {
				$str = "Добрый день, <strong>" . $_SESSION['login'] . "</strong>";

				$this->view->generate('user_view.php', 'template_view.php', $str );
			}
	}
	
}
