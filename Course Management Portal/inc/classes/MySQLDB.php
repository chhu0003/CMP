<?php

/**
 * Author: Eric Tubby
 *
 * Class MySQLDB
 *
 * used for all interactions with the database
 *
 */


//include the database configuration file
require_once( dirname( dirname( dirname( __FILE__ ) ) ) . '/conf/config.php' );

class MySQLDB
{

	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;

	public function __construct()
	{
		//open the connection to the database
		$this->open_connection();

		//check to see if magic quotes are active
		$this->magic_quotes_active = get_magic_quotes_gpc();

		//check to see if mysql_real_escape_string() exists
		$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );

	}

	//open a connection to the database
	public function open_connection()
	{

		//make the connection to database
		$this->connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD );

		//if the connection isn't made
		if( !$this->connection ) {

			die( 'Could not connect to the database. ' . mysqli_error( $this->connection ) );

		} else {

			$db_select = mysqli_select_db( $this->connection, DB_NAME );

			//if the database could not be selected
			if( !$db_select ) {

				die( "Database selection failed: " . mysqli_error( $this->connection ) );

			}

		}

	}

	//close the connection to the database
	public function close_connection()
	{
		//if the connection is open
		if( isset( $this->connection ) ) {
			//close it
			mysqli_close( $this->connection );
			unset( $this->connection );
		}
	}

	/**
	 * @param $sql
	 *
	 * @return bool|mysqli_result
	 */
	public function query( $sql )
	{
		//set this query as the last query
		$this->last_query = $sql;

		$result = mysqli_query( $this->connection, $sql );

		//confirm the query worked
		$this->confirm_query( $result );

		return $result;

	}

	/*
	 * Accepts a SQL query, connects to the database and then runs the query.
	 * If there are not any results, it returns null on a SELECT query, false on other queries.
	 * If the query was successful and the query was not a SELECT query, it will return true.
	 * If it was a SELECT, then it converts the results into an array of MySQLDBQueryResult objects.
	 *
	 * @param $sql
	 *
	 * @return array|bool|null
	 */
	public function query_as_object( $sql )
	{

		//query the database with the provided SQL
		$res = mysqli_query( $this->connection, $sql );

		//if there are results from the query
		if( $res ) {

			//if SELECT is not found in the SQL statement
			if( strpos( $sql, 'SELECT' ) === false ) {

				//return true to indicate the query was successful
				return true;

			}

		} else {
			//if there are not any results

			//if SELECT isn't found in the SQL statement
			if( strpos( $sql, 'SELECT' ) === false ) {

				//return false to indicate that the query was not successful
				return false;

			} else {
				//if it was a SELECT query return null to indicate now queries where returned
				return null;

			}

		}

		//if it was a SELECT statement, convert the results into an array of MySQLDBQueryResult objects

		$results = array();

		while( $row = mysqli_fetch_array( $res ) ) {

			//instantiate the MySQLDBQueryResult
			$result = new MySQLDBQueryResult();

			//foreach row returned from the database
			foreach( $row as $k => $v ) {

				//add the key and value to the $result object
				$result->$k = $v;

			}

			//take the object from the MySQLDBQueryResult and add it to the $results array
			$results[ ] = $result;
		}

		//return the results
		return $results;

	}


	/**
	 *
	 * escapes the value based on the current php version and whether or not magic_quotes are active
	 *
	 * @param $value
	 *
	 * @return string
	 */
	public function escape_value( $value )
	{

		$magic_quotes_active = get_magic_quotes_gpc();

		//if true the PHP version is >= v4.3.0
		$new_enough_php = function_exists( "mysql_real_escape_string" );

		//if the PHP version is >= v4.3.0
		if( $new_enough_php ) {

			//undo any magic quote effects so that mysql_real_escape_string can do the work
			if( $magic_quotes_active ) {

				$value = stripslashes( $value );

			}

			$value = mysqli_real_escape_string( $this->connection, $value );

		} else {
			//the PHP version is < v4.3.0
			if( !$magic_quotes_active ) {

				$value = addslashes( $value );
			}

		}

		return $value;
	}

	/**
	 *
	 * confirm the query was successful
	 *
	 * @param $result_set
	 */
	private function confirm_query( $result_set )
	{

		if( !$result_set ) {

			die( "Database query failed: " . mysqli_error( $this->connection ) );

		}

	}

	// general database methods

	/**
	 * @param $result_set
	 *
	 * @return array|null
	 */
	public function fetch_array( $result_set )
	{

		return mysqli_fetch_array( $result_set );

	}

	/**
	 *
	 * returns the number of rows affected by query
	 *
	 * @param $result_set
	 *
	 * @return int
	 */
	public function num_rows( $result_set )
	{

		return mysqli_num_rows( $result_set );

	}


	/**
	 *
	 * returns the auto incremented id from the last query
	 *
	 * @return int|string
	 */
	public function insert_id()
	{

		return mysqli_insert_id( $this->connection );

	}


	/**
	 * returns the amount of rows that were affected on the last query
	 *
	 * @return int
	 */
	public function affected_rows()
	{

		return mysqli_affected_rows( $this->connection );

	}

	/**
	 *
	 * find by id for the current table
	 *
	 * @param $ID
	 *
	 * @return bool|mixed
	 */
	public static function find_by_ID( $ID )
	{

		$find_course_by_course_number_sql = "SELECT * FROM " . static::$table_name . " WHERE ID='$ID'";

		//query the database with the user_login
		$result_array = self::find_by_sql( $find_course_by_course_number_sql );

		//if the $result_array isn't empty use array_shift() so that only the course object inside the array is
		//returned. Otherwise, return false so that we know the user wasn't found
		return !empty( $result_array ) ? array_shift( $result_array ) : false;

	}

	/**
	 * find all for the current table
	 *
	 * @return array
	 *
	 */
	public static function find_all()
	{

		$find_all_sql = "SELECT * FROM " . static::$table_name;

		return self::find_by_sql( $find_all_sql );

	}

	/**
	 *
	 * accepts a sql SELECT statement, returns the results as an array of objects
	 *
	 * @param string $sql
	 *
	 * @return array
	 *
	 */
	public static function find_by_sql( $sql = "" )
	{

		global $database;

		//query the database
		$result_set = $database->query( $sql );

		$object_array = array();

		//go through each of the rows in the results
		while( $row = $database->fetch_array( $result_set ) ) {

			//instantiate the row and add it to the $object_array
			$object_array[ ] = self::instantiate( $row );

		}

		//return the array of objects
		return $object_array;

	}

	/**
	 *
	 * takes the record being passed to it and returns it as an object
	 *
	 * @param $record
	 *
	 * @return User
	 *
	 */
	private static function instantiate( $record )
	{

		//instantiate a new object
		$object = new static;

		//loop through each of the attributes
		foreach( $record as $attribute => $value ) {

			//if $this object has the attribute being passed to it
			if( $object->has_attribute( $attribute ) ) {
				//assign the value of the attribute
				$object->$attribute = $value;
			}

		}

		return $object;
	}

	/**
	 *
	 * takes an attribute and checks to see if it exists in the attributes of the current
	 *
	 * @param $attribute
	 *
	 * @return bool
	 *
	 */
	protected function has_attribute( $attribute )
	{

		//returns an associative array with all attributes
		$object_vars = get_object_vars( $this );

		//will return true or false
		return array_key_exists( $attribute, $object_vars );

	}

	/**
	 *
	 * returns an array of attribute names and their values
	 *
	 * @return array
	 */
	protected function attributes()
	{

		$attributes = array();

		//for each of the field names in the users table
		foreach( static::$database_fields as $field ) {

			if( property_exists( $this, $field ) ) {

				$attributes[ $field ] = $this->$field;

			}
		}

		return $attributes;

	}


	/**
	 * takes an array of attributes, sanitizes them, and then returns them as an array
	 *
	 * @return array
	 */
	protected function sanitized_attributes()
	{

		global $database;

		$sanitized_attributes = array();

		//sanitize each of the attributes
		foreach( $this->attributes() as $key => $value ) {

			$sanitized_attributes[ $key ] = $database->escape_value( $value );

		}

		return $sanitized_attributes;

	}


	/**
	 * runs an UPDATE if the record already exist, OR runs CREATE if the record doesn't already exist.
	 *
	 * @return bool
	 */
	public function save()
	{

		//if the id is already set, run update else run create
		return isset( $this->ID ) ? $this->update() : $this->create();

	}


	/**
	 * CREATE a new record in the database - create() should not be called directly, call save() instead
	 *
	 * @return bool
	 */
	protected function create()
	{

		global $database;

		//get the sanitized attributes
		$attributes = $this->sanitized_attributes();

		$create_sql = "INSERT INTO " . static::$table_name . " (";
		$create_sql .= join( ", ", array_keys( $attributes ) );
		$create_sql .= ") VALUES ('";
		$create_sql .= join( "', '", array_values( $attributes ) );
		$create_sql .= "')";

		if( $database->query( $create_sql ) ) {

			//get the id that was auto incremented
			$this->ID = $database->insert_id();

			return true;

		} else {

			return false;

		}


	}


	/**
	 * UPDATE a record in the database - update() should not be called directly, call save() instead
	 *
	 * @return bool
	 */
	protected function update()
	{

		global $database;

		//get the sanitized attributes
		$attributes = $this->sanitized_attributes();

		$attribute_pairs = array();

		foreach( $attributes as $key => $value ) {
			$attribute_pairs[ ] = "{$key}='{$value}'";
		}

		$update_sql = "UPDATE " . static::$table_name . " SET ";
		$update_sql .= join( ", ", $attribute_pairs );
		$update_sql .= " WHERE ID = " . $database->escape_value( $this->ID );

		//run the query
		$database->query( $update_sql );

		//return true if the update was successful
		return ( $database->affected_rows() == 1 ) ? true : false;
	}


	/**
	 * DELETE a record in the database
	 *
	 * @return bool
	 */
	public function delete()
	{

		global $database;

		$delete_sql = "DELETE FROM " . static::$table_name;
		$delete_sql .= " WHERE ID =" . $database->escape_value( $this->ID );
		$delete_sql .= " LIMIT 1";

		//query the database
		$database->query( $delete_sql );

		//return true if the delete was successful
		return ( $database->affected_rows() == 1 ) ? true : false;

	}

	/**
	 * @return bool|mysqli_result
	 */
	static function disable_foreign_key_checks()
	{
		global $database;

		return $database->query( 'SET foreign_key_checks = 0' );
	}

	/**
	 * @return bool|mysqli_result
	 */
	static function enable_foreign_key_checks()
	{
		global $database;

		return $database->query( 'SET foreign_key_checks = 1' );
	}


}


//create property names on the fly and store data associated with those properties
class MySQLDBQueryResult
{

	/**
	 * @var array
	 */
	private $_results = array();

	/**
	 *
	 */
	public function __construct() { }


	/**
	 * @param $var
	 * @param $val
	 */
	public function __set( $var, $val )
	{
		$this->_results[ $var ] = $val;
	}

	/**
	 * @param $var
	 *
	 * @return null
	 */
	public function __get( $var )
	{

		if( isset( $this->_results[ $var ] ) ) {

			return $this->_results[ $var ];

		} else {

			return null;

		}
	}

}

//instantiate MySQLDB
$database = new MySQLDB();
