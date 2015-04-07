<?php


/**
 * Author: Eric Tubby
 * Adapted by: Caroline Gagnon
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
		'program_name',
		'program_code',
		'program_version',
		'program_flowchart',
		'program_year',
    );


	public $ID;
	public $program_name;
	public $program_code;
	public $program_version;
	public $program_flowchart;
	public $program_year;

	public function __construct() { }

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
            $selectPrograms = "SELECT programs.ID, programs.program_name, programs.program_year FROM programs where programs.ID Not in (SELECT programs_ID FROM users_has_programs WHERE users_has_programs.users_ID=$userID) order by programs.program_name, programs.program_year";

        }else{
            $selectPrograms = "SELECT programs.ID, programs.program_name, programs.program_year FROM programs order by programs.program_name, programs.program_year";
        }
        //return the results as a program object
        return self::find_by_sql( $selectPrograms );
    }

    //Used in manage_users
    public static function find_selected_user_program( $userID )
    {
        $selectPrograms = "SELECT programs.ID, programs.program_name, programs.program_year,programs.program_code FROM programs, users_has_programs WHERE users_has_programs.users_ID=$userID and users_has_programs.programs_id = programs.ID";
        //return the results as a program object
        return self::find_by_sql( $selectPrograms );
    }
	/**
	 * @param $program_code
	 * @param $program_name
	 *
	 * @return bool|mixed
	 * @return array
	 */
	public static function find_by_program_code_and_year($code, $year)
	{
		$find_by_program_code_and_year_sql = "select * from ". self::$table_name ." WHERE program_code='$code' and program_year=$year";
		//echo $find_by_program_code_and_year_sql;
		return self::find_by_sql( $find_by_program_code_and_year_sql );
	}
	
	
	/**
	 * @param $program_name
	 *
	 * @return array
	 */
	public static function find_by_program_name( $program_name )
	{

		$find_program_by_program_name_sql = "SELECT * FROM " . self::$table_name . " WHERE program_name='$program_name' ORDER BY 'program_name'";

        return self::find_by_sql( $find_program_by_program_name_sql );


	}

	/**
	 * @param $program_year
	 *
	 * @return array
	 */
	public static function find_by_program_year( $program_year )
	{

		$find_by_program_year_sql = "SELECT * from " . self::$table_name . " WHERE program_year =" . $program_year;

		return self::find_by_sql( $find_by_program_year_sql );

	}

	/**
	 * @param $program_version
	 *
	 * @return array
	 */
	public static function find_by_program_version( $program_version )
	{

        $find_by_program_version_sql = "SELECT * from " . self::$table_name . " WHERE program_version =" . $program_version;

        return self::find_by_sql( $find_by_program_version_sql );

	}

    /**
     * @param $program_code
     *
     * @return array
     */
    public static function find_by_program_code( $program_code )
    {

        $find_by_program_code_sql = "SELECT * from " . self::$table_name . " WHERE program_code =" . $program_code;

        return self::find_by_sql( $find_by_program_code_sql );

    }
    /**
     * @param $program_version
     *
     * @return array
     */
    public static function find_by_program_flowchart( $program_flowchart )
    {

        $find_by_program_flowchart_sql = "SELECT * from " . self::$table_name . " WHERE program_version =" . $program_flowchart;

        return self::find_by_sql( $find_by_program_flowchart_sql );

    }

    /**
     *  @param $program_name
     * @return array
     *
     */

    public static function find_distinct_program()
    {

        $find_distinct_program_sql = "SELECT program_name, program_code, GROUP_CONCAT(DISTINCT program_year ORDER BY program_year DESC) as program_year FROM " . static::$table_name . " group by program_name";

        return self::find_by_sql( $find_distinct_program_sql );

    }
}
/**
 * Class UserPrograms
 *
 * CRUD for user_has_programs -> CRUD is inherited from MySQLDB
 *
 */
class UserProgram extends Program
{
    protected static $table_name = "users_has_programs";

    protected static $database_fields = array(
        'users_id',
        'programs_ID',
    );

    public $users_id;
    public $programs_ID;

    public static function find_by_userPrograms_ID( $ID )
    {

        $find_by_user_ID_sql = "SELECT * FROM " . self::$table_name . " WHERE USERS_ID='$ID'";

        //query the database with the user_login
        $result_array = parent::find_by_sql( $find_by_user_ID_sql );

        //if the $result_array isn't empty use array_shift() so that only the user object inside the array is
        //returned. Otherwise, return false so that we know the user wasn't found
        return !empty( $result_array ) ? array_shift( $result_array ) : false;
    }
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

    public static function find_by_programCourses_ID( $ID )
    {

        $find_by_program_ID_sql = "SELECT * FROM " . self::$table_name . " WHERE PROGRAMS_ID='$ID'";

        //query the database with the user_login
        $result_array = parent::find_by_sql( $find_by_program_ID_sql );

        //if the $result_array isn't empty use array_shift() so that only the user object inside the array is
        //returned. Otherwise, return false so that we know the user wasn't found
        return !empty( $result_array ) ? array_shift( $result_array ) : false;
    }
}