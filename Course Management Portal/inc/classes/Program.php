<?php

/**
 * Author: Jaymanee
 *
 * Class Program
 *
 * CRUD for programs -> CRUD is inherited from MySQLDB
 *
 * Set all of the fields that you want to get from the table in $database_fields
 * then, create variable's with the exact same names as the fields set in $database_fields.
 *
 * This applies to all children of this class, if any exist.
 *
 */
class Program extends MySQLDB
{

	protected static $table_name = "programs";

	protected static $database_fields = array(
		'ID',
		'program_code',
		'program_name',
		'program_version',
		'program_flowchart',
		'program_year',
	);

	public $ID;
	public $program_code;
	public $program_name;
	public $program_version;
	public $program_flowchart;
	public $program_year;

	public function __construct()
	{
	}

	/**
	 * @param $program_code
	 *
	 * @return bool|mixed
	 */
	public static function find_by_program_code_and_year($code, $year)
	{
		$find_by_program_code_and_year_sql = "select * from ". self::$table_name ." WHERE program_code='$code' and program_year=$year";
		//echo $find_by_program_code_and_year_sql;
		return self::find_by_sql( $find_by_program_code_and_year_sql );
	}
	
	public static function find_by_program_ID( $ID )
	{

		$find_by_program_ID_sql = "SELECT * FROM " . self::$table_name . " WHERE ID='$ID'";

		//query the database with the user_login
		$result_array = parent::find_by_sql( $find_by_program_ID_sql );

		//if the $result_array isn't empty use array_shift() so that only the user object inside the array is
		//returned. Otherwise, return false so that we know the user wasn't found
		return !empty( $result_array ) ? array_shift( $result_array ) : false;
	}

    //used in manage_users
	public static function find_user_program( $userID )
	{
		$selectPrograms = "";
		if ($userID > 0)
		{
			$selectPrograms = "SELECT programs.ID, programs.program_name, programs.program_year FROM programs";
			$selectPtograms .= " where programs.ID Not in (SELECT programs_ID FROM users_has_programs WHERE users_has_programs.users_ID=$userID) order by programs.program_name, programs.program_year"; 
		}else{
			$selectPrograms = "SELECT programs.ID, programs.program_name, programs.program_year FROM programs order by programs.program_name, programs.program_year"; 
		}

		//return the results as a program object
		return self::find_by_sql( $selectPrograms );
	}

    //User in manage_users
	public static function find_selected_user_program( $userID )
	{
		$selectPrograms = "SELECT  programs.ID, programs.program_name, programs.program_code, programs.program_year";
		$selectPrograms .= " FROM programs, users_has_programs WHERE users_has_programs.users_ID=$userID and users_has_programs.programs_id = programs.ID"; 

		//return the results as a program object
		return self::find_by_sql( $selectPrograms );
	}
}

/**
 * Class UserPrograms
 *
 * CRUD for user_has_programs -> CRUD is inherited from MySQLDB
 *
 */
class UserPrograms extends Program
{
	protected static $table_name = "users_has_programs";

	protected static $database_fields = array(
		'users_id',
		'programs_ID',
	);

	public $users_id;
	public $programs_ID;
}

class ProgramCourses extends Program
{
	protected static $table_name = "programs_has_courses";

	protected static $database_fields = array(
		'courses_id',
		'programs_id',
	);

	public $courses_id;
	public $programs_id;
}