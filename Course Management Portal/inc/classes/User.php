<?php

/**
 * Author: Eric Tubby
 *
 * Class User
 *
 * CRUD for users -> CRUD is inherited from MySQLDB
 *
 * Set all of the fields that you want to get from the table in $database_fields
 * then, create variable's with the exact same names as the fields set in $database_fields.
 *
 * This applies to all children of this class, if any exist.
 *
 */
class User extends MySQLDB
{

	protected static $table_name = "users";

	protected static $database_fields = array(
		'ID',
		'user_login',
		'user_pass',
		'user_fname',
		'user_lname',
		'user_email',
		'user_role'
	);

	///role names for user roles
	public static $roleNames = array(
		10 => 'Coordinator',
		9  => 'Assistant',
		8  => 'Professor'
	);

	public $ID;
	public $user_login;
	public $user_pass;
	public $user_fname;
	public $user_lname;
	public $user_email;
	public $user_role;

	/**
	 *
	 */
	public function __construct() { }


	/**
	 * @param $user_login
	 *
	 * @return bool|mixed
	 *
	 * find a user by their ID
	 */
	public static function find_by_user_login( $user_login )
	{

		$get_user_by_login_sql = "SELECT * FROM " . self::$table_name . " WHERE user_login='$user_login'";

		//query the database with the user_login
		$result_array = parent::find_by_sql( $get_user_by_login_sql );

		//if the $result_array isn't empty use array_shift() so that only the user object inside the array is
		//returned. Otherwise, return false so that we know the user wasn't found
		return !empty( $result_array ) ? array_shift( $result_array ) : false;

	}

	/**
	 * @param $user_ID
	 *
	 * @return bool|mixed
	 *
	 * find a user by their ID
	 */
	public static function find_by_user_ID( $user_ID )
	{

		$get_user_by_id_sql = "SELECT * FROM " . self::$table_name . " WHERE ID='$user_ID'";

		//query the database with the ID
		$result_array = parent::find_by_sql( $get_user_by_id_sql );

		//if the $result_array isn't empty use array_shift() so that only the user object inside the array is
		//returned. Otherwise, return false so that we know the user wasn't found
		return !empty( $result_array ) ? array_shift( $result_array ) : false;

	}


	/**
	 * @param string $username
	 * @param string $password
	 *
	 * @return bool|mixed
	 */
	public static function authenticate( $username = "", $password = "" )
	{

		global $database;

		//escape the values
		$username = $database->escape_value( $username );
		$password = $database->escape_value( $password );

		//encrypt the password
		$password = sha1( $password );

		$authenticate_user_sql = "SELECT * FROM users ";
		$authenticate_user_sql .= "WHERE user_login = '{$username}' ";
		$authenticate_user_sql .= "AND user_pass = '{$password}' ";
		$authenticate_user_sql .= "LIMIT 1";

		//query the database with the users login information
		$result_array = parent::find_by_sql( $authenticate_user_sql );

		//if the $result_array isn't empty use array_shift() so that only the user object inside the array is
		//returned. Otherwise, return false so that we know the user didn't pass authentication
		return !empty( $result_array ) ? array_shift( $result_array ) : false;

	}

	/**
	 * @return string
	 *
	 * simply returns the users full name using user_fname and user_lname
	 */
	public function full_name()
	{

		if( isset( $this->user_fname ) && isset( $this->user_lname ) ) {

			return $this->user_fname . " " . $this->user_lname;

		} else {

			return "";

		}

	}

	public static function get_role_name_by_user_role( $user_role = 0 )
	{

		$role = "";

		//loop through the role names
		foreach( self::$roleNames as $key => $value ) {

			//check to see if the current $key matches the given role
			if( $user_role == $key ) {

				//set the value of the role to the current $value
				$role = $value;

				break; //no need to keep looking

			}

		}

		//return the role that was found
		return $role;
	}


}

/**
 * Class UsersPrograms
 *
 * CRUD for users programs -> CRUD is inherited from MySQLDB
 *
 */
class UsersPrograms extends User
{

	protected static $table_name = "programs";

	protected static $database_fields = array(
		'ID',
		'program_name',
		'program_code',
		'program_version',
		'program_flowchart'
	);

	public $ID;
	public $program_name;
	public $program_code;
	public $program_version;
	public $program_flowchart;

	//TODO: make some methods to get the users programs and add the user to programs


}

