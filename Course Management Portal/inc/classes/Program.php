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