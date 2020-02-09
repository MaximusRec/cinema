<?php

class Users 
{

	public function getUsers()
	{	
		$users = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/db/user.json' ); 
		$data = json_decode( $users , true );
		return $data;
		
	}	
	
	
	public function setUsers( $data )
	{	
		$users = file_put_contents( $_SERVER['DOCUMENT_ROOT'] . '/db/user.json', $data );
	}
	
	
	public function findUser( $login, $password )
	{	
		if ( !empty ( $password ) AND !empty ( $login ) ) $password = md5($password); else return NULL;
		
		foreach ( $this->getUsers() as $value) {
					if ( ( $value['login'] == $login) AND ( $value['pass'] == $password ) ) return $value;
			}

		return NULL;
	}	
	
	
	
}



?>
