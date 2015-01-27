<?php


/**
 * Author: Eric Tubby
 *
 * Class Session
 *
 * Manage logging users in and out
 */
class Session
{

	private $logged_in = false;
	public $user_id;
	public $user_role;
	public $user_full_name;

	function __construct()
	{

		//session_status() for PHP >= 5.4.0, session_id() for PHP < 5.4.0 session_status() == PHP_SESSION_NONE

		//if the session hasn't been started yet
		if( session_id() == '' ) {

			session_start();
		}

		$this->check_login();

	}

	//checks to see if the user is logged in
	public function is_logged_in()
	{

		return $this->logged_in;

	}

	//accepts a user object and logs them in
	public function login( $user )
	{

		if( $user ) {

			//add the id from the user that was received to the session as well as $this->user_id
			$this->user_id = $_SESSION[ 'user_id' ] = $user->ID;

			//add the user_role from the user that was received to the session as well as $this->user_role
			$this->user_role = $_SESSION[ 'user_role' ] = $user->user_role;

			//add the user_full_name from the user that was received to the session as well as $this->user_full_name
			$this->user_full_name = $_SESSION[ 'user_full_name' ] = $user->user_fname . " " . $user->user_lname;

			//set the user as logged in
			$this->logged_in = true;
		}

	}

	//log the user out
	public function logout()
	{

		unset( $_SESSION[ 'user_id' ] );
		unset( $_SESSION[ 'user_role' ] );
		unset( $_SESSION[ 'user_full_name' ] );
		unset( $this->user_id );

		$this->logged_in = false;

	}

	//used for checking to see if the user is logged in
	private function check_login()
	{

		//if the session is set
		if( isset( $_SESSION[ 'user_id' ] ) ) {

			//add the session to $this->user_id
			$this->user_id = $_SESSION[ 'user_id' ];

			//set the user as being logged in
			$this->logged_in = true;

		} else {

			unset( $this->user_id );
			$this->logged_in = false;
		}
	}
}

//instantiate the session
$session = new Session();