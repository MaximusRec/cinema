<?php

class Controller_Enter extends Controller
{
	function __construct()
	{
		$this->model = new Model_Enter();
		$this->view = new View();
	}
	
	function action_index()
	{			
			if ( isset ($_POST['enter'] ) ) {   
					$this->redirect ( 'user' );				
			}  					
			
			if ( $this->authorization() != TRUE )	
			{	
				$data = $this->model->get_data();
				$this->view->generate('enter_view.php', 'template_view.php', $data );
			} else {
				$this->redirect ( 'user' );	
			}			
			
	}
}