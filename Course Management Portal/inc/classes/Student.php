<?php

/**
 * Author: Eric Tubby
 *
 * Class Student
 *
 * CRUD for students -> CRUD is inherited from MySQLDB
 *
 * Set all of the fields that you want to get from the table in $database_fields
 * then, create variable's with the exact same names as the fields set in $database_fields.
 *
 * This applies to all children of this class, if any exist.
 */
class Student extends MySQLDB
{

	protected static $table_name = "students";

	protected static $database_fields = array(
		'ID',
		'student_number',
		'student_fname',
		'student_lname',
		'student_email',
		'student_phone',
        'graduated',
	);

	public $ID;
	public $student_number;
	public $student_fname;
	public $student_lname;
	public $student_email;
	public $student_phone;
    public $graduated;

	public function __construct()
	{
	}

	/**
	 * @param $student_number
	 *
	 * @return bool|mixed
	 */
	public static function find_by_student_number( $student_number )
	{

		$find_by_student_number_sql = "SELECT * FROM " . self::$table_name . " WHERE student_number='$student_number'";

		//query the database with the user_login
		$result_array = parent::find_by_sql( $find_by_student_number_sql );

		//if the $result_array isn't empty use array_shift() so that only the user object inside the array is
		//returned. Otherwise, return false so that we know the user wasn't found
		return !empty( $result_array ) ? array_shift( $result_array ) : false;


	}

	/**
	 * @param $ID
	 *
	 * @return array
	 */
	public static function find_by_course_ID( $ID )
	{

		$find_by_course_ID_sql = "SELECT student_number, student_fname, student_lname, student_email, student_phone ";
		$find_by_course_ID_sql .= "FROM students s, student_courses sc ";
		$find_by_course_ID_sql .= "WHERE sc.courses_ID = $ID ";
		$find_by_course_ID_sql .= "AND sc.students_student_number = s.student_number";

		return self::find_by_sql( $find_by_course_ID_sql );

	}

	/**
	 * @return string
	 */
	public function full_name()
	{
		//if the first and last name are set
		if( isset( $this->student_fname ) && isset( $this->student_lname ) ) {

			//return them
			return $this->student_fname . " " . $this->student_lname;

		} else {//return an empty string

			return "";

		}

	}

    /**
     * @param $year
     * @param $programID
     * @return bool|mixed
     */
    public static function find_all_by_graduated($programID, $year)
    {

        //$find_all_by_graduated_year_and_program_sql = "SELECT * FROM " . self::$table_name . " WHERE graduating_year={$year} AND programs_id={$programID}";
        $find_all_by_graduated_year_and_program_sql = "SELECT *, (SELECT ID FROM programs WHERE program_code={$programID} AND program_year={$year}) AS 'programID' FROM " . self::$table_name . " WHERE graduating_year={$year} AND programs_id='programID'";

        //query the database with the user_login
        $result_array = parent::find_by_sql( $find_all_by_graduated_year_and_program_sql );

        //if the $result_array isn't empty use array_shift() so that only the user object inside the array is
        //returned. Otherwise, return false so that we know the user wasn't found
        //return !empty( $result_array ) ? array_shift( $result_array ) : false;
        return !empty( $result_array ) ? $result_array : false;

    }

    public static function find_all_by_missing_course($programID,$year)
    {
     $find_all_by_missing_course_sql = "SELECT * FROM student_grades AND" .self::$table_name .
         "WHERE student_grades.letter_grade = null AND programID{$programID} AND year={$year}";

        //query the database with the user_login
        $result_array = parent::find_by_sql( $find_all_by_missing_course_sql );

       //if the $result_array isn't empty use array_shift() so that only the user object inside the array is
        //returned. Otherwise, return false so that we know the user wasn't found
        //return !empty( $result_array ) ? array_shift( $result_array ) : false;
        return !empty( $result_array ) ? $result_array : false;
    }
    public static function find_all_by_failed_course($programID,$year)
    {
        $find_all_by_missing_course_sql = "SELECT * FROM student_grades AND" .self::$table_name .
            "WHERE student_grades.letter_grade = 'F' AND programID{$programID} AND year={$year}";

        //query the database with the user_login
        $result_array = parent::find_by_sql( $find_all_by_missing_course_sql );

        //if the $result_array isn't empty use array_shift() so that only the user object inside the array is
        //returned. Otherwise, return false so that we know the user wasn't found
        //return !empty( $result_array ) ? array_shift( $result_array ) : false;
        return !empty( $result_array ) ? $result_array : false;
    }
}

/**
 * Class StudentGrade
 *
 * CRUD for students grades -> CRUD is inherited from MySQLDB
 *
 */
class StudentGrade extends Student
{

	protected static $table_name = "student_grades";

	protected static $database_fields = array(
		'ID',
		'letter_grade',
		'numeric_grade',
		'courses_ID',
		'students_ID',
		'students_student_number',

	);

	public $ID;
	public $letter_grade;
	public $numeric_grade;
	public $courses_ID;
	public $students_ID;
	public $students_student_number;

	/**
	 * @param $student_number
	 *
	 * @return bool|mixed
	 */
	public static function find_by_student_number( $student_number )
	{

		$find_by_student_number_sql = "SELECT * FROM " . self::$table_name . " WHERE students_student_number='$student_number'";

		//return the students grades
		return self::find_by_sql( $find_by_student_number_sql );

	}

	/**
	 * @param $student_number
	 * @param $ID
	 *
	 * @return array
	 */
	public static function find_by_student_number_and_course_ID( $student_number, $ID )
	{
		if( !is_numeric( $student_number ) ) {
			$student_number = 0;
		}

		$find_by_student_number_and_course_ID_sql = "SELECT * ";
		$find_by_student_number_and_course_ID_sql .= "FROM " . self::$table_name . " ";
		$find_by_student_number_and_course_ID_sql .= "WHERE courses_ID = $ID ";
		$find_by_student_number_and_course_ID_sql .= "AND students_student_number = $student_number";

		$result_array = self::find_by_sql( $find_by_student_number_and_course_ID_sql );

		//if the $result_array isn't empty use array_shift() so that only the user object inside the array is
		//returned. Otherwise, return false so that we know the students grade wasn't found
		return !empty( $result_array ) ? array_shift( $result_array ) : false;

	}


}


/**
 * Class StudentCourse
 *
 * CRUD for students courses -> CRUD is inherited from MySQLDB
 *
 */
class StudentCourse extends Student
{

	protected static $table_name = "student_courses";

	protected static $database_fields = array(
		'ID',
		'student_courses_semester',
		'courses_ID',
		'students_ID',
		'students_student_number'
	);

	public $ID;
	public $student_courses_semester;
	public $courses_ID;
	public $students_ID;
	public $students_student_number;


	/**
	 * @param $student_number
	 *
	 * @return bool|mixed
	 *
	 * get all of the courses the student is registered to
	 *
	 */
	public static function find_by_student_number( $student_number )
	{

		$find_by_student_number_sql = "SELECT * FROM " . self::$table_name . " WHERE students_student_number='$student_number'";

		//return the students courses
		return self::find_by_sql( $find_by_student_number_sql );

	}

	/**
	 * @param $student_number
	 * @param $ID
	 *
	 * @return array
	 *
	 * get the student for a specific course
	 */
	public static function find_by_student_number_and_course_ID( $student_number, $ID )
	{

		$find_by_student_number_and_course_ID_sql = "SELECT * ";
		$find_by_student_number_and_course_ID_sql .= "FROM " . self::$table_name . " ";
		$find_by_student_number_and_course_ID_sql .= "WHERE courses_ID = $ID ";
		$find_by_student_number_and_course_ID_sql .= "AND students_student_number = $student_number";

		$result_array = self::find_by_sql( $find_by_student_number_and_course_ID_sql );

		//if the $result_array isn't empty use array_shift() so that only the user object inside the array is
		//returned. Otherwise, return false so that we know the user wasn't found
		return !empty( $result_array ) ? array_shift( $result_array ) : false;

	}


}