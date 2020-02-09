<?php

class Controller {
	
	public $model;
	public $view;
	
	function __construct()
	{
		$this->view = new View();
	}
	// действие (action), вызываемое по умолчанию
	function action_index()
	{
		// todo	
	}

	/**
	*	Проверяет авторизацию пользователя
	*/
	function authorization()
	{  
        if ( isset ($_SESSION ) )	
			if ( isset ($_SESSION['access'] ) )	
			if ( $_SESSION['access'] == 'yes' )		
			{   return TRUE;
			} elseif ( $_SESSION['access'] == 'no' ) {
				return FALSE;
			}
	}


	/**
     * redirect по нужному адресу
     */
	function redirect( $page )
	{  
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/' . $page;
		header( 'Location:'.$host );	
	}
}
