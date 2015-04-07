<?php


/**
 * Author: Eric Tubby
 *
 * Class Course
 *
 * CRUD for courses -> CRUD is inherited from MySQLDB
 *
 * Set all of the fields that you want to get from the table in $database_fields
 * then, create variable's with the exact same names as the fields set in $database_fields.
 *
 * This applies to all children of this class, if any exist.
 *
 */
class Course extends MySQLDB
{

	protected static $table_name = "courses";

	protected static $database_fields = array(
		'ID',
		'course_number',
		'course_name',
		'course_description',
		'course_level',
		'course_hours_lab',
		'course_hours_lecture',
		'course_hours_study',
		'course_hybrid'
	);


	public $ID;
	public $course_number;
	public $course_name;
	public $course_description;
	public $course_level;
	public $course_hours_lab;
	public $course_hours_lecture;
	public $course_hours_study;
	public $course_hybrid;


	public function __construct() { }

	/**
	 * @param $course_number
	 *
	 * @return bool|mixed
	 */
	public static function find_by_course_number( $course_number )
	{

		$find_course_by_course_number_sql = "SELECT * FROM " . self::$table_name . " WHERE course_number='$course_number'";

		//query the database with the user_login
		$result_array = parent::find_by_sql( $find_course_by_course_number_sql );

		//if the $result_array isn't empty use array_shift() so that only the course object inside the array is
		//returned. Otherwise, return false so that we know the user wasn't found
		return !empty( $result_array ) ? array_shift( $result_array ) : false;


	}

	/**
	 * @param $courseLevel
	 *
	 * @return array
	 */
	public static function find_by_course_level( $courseLevel, $program_id )
	{

		$find_by_course_level_sql = "SELECT * from " . self::$table_name . ", programs_has_courses WHERE id=courses_id and course_level =" . $courseLevel ." and programs_id=".$program_id;

		return self::find_by_sql( $find_by_course_level_sql );

	}

	/**
	 * @param $course_level
	 *
	 * @return int
	 */
	public static function count_by_course_level( $course_level, $program_id )
	{

		$count_by_course_level_sql = "SELECT * FROM courses, programs_has_courses WHERE id=courses_id AND course_level =" . $course_level ." and programs_id=".$program_id;

		$coursesInThisLevel = parent::find_by_sql( $count_by_course_level_sql );

		return count( $coursesInThisLevel );

	}
	
	

	/**
	 * @return int
	 *
	 * TODO: get this to get the number of levels in a program instead of all of the courses in the courses table.
	 * This currently works because all courses belong to IAWD - the SQL statement will need to be updated and the method
	 * will need something like the program ID passed to it.
	 *
	 */
	public static function get_number_of_levels()
	{

		$courseLevel = 1;

		do {

			$courseLevel++;

			$get_number_of_levels_sql = "SELECT course_level from " . self::$table_name . " WHERE course_level =" . $courseLevel;

			$levelExists = self::find_by_sql( $get_number_of_levels_sql );


		} while( $levelExists );

		return $courseLevel - 1;

	}

	
	public static function find_course_program( $programID )
	{
		$selectCourses = "";
		if ($programID > 0)
		{
			$selectCourses = "SELECT courses.ID, courses.course_number, courses.course_name FROM courses where courses.ID Not in (SELECT programs_has_courses.courses_id FROM programs_has_courses WHERE programs_has_courses.programs_id=$programID) order by courses.course_number"; 
		}else{
			$selectCourses = "SELECT courses.ID, courses.course_number, courses.course_name FROM courses order by courses.course_number"; 
		}

		//return the results as a course object
		return self::find_by_sql( $selectCourses );
	}

	public static function find_selected_course_program( $programID )
	{
		$selectCourses = "SELECT courses.ID, courses.course_number, courses.course_name FROM courses, programs_has_courses WHERE courses.ID = programs_has_courses.courses_id and programs_has_courses.programs_id = $programID"; 

		//return the results as a course object
		return self::find_by_sql( $selectCourses );
	}
}


/**
 * Class CoursePrerequisite
 *
 * CRUD for course prerequisites -> CRUD is inherited from MySQLDB
 *
 */
class CoursePrerequisite extends Course
{

	protected static $table_name = "course_prerequisites";

	protected static $database_fields = array(
		'ID',
		'course_prerequisites_course_number',
		'programs_ID',
		'courses_ID',
	);

	public $ID;
	public $course_prerequisites_course_number;
	public $programs_ID;
	public $courses_ID;

	/**
	 * @param $ID
	 *
	 * @return array of all prerequisites
	 */
	public static function find_by_course_ID(  $ID, $program_ID )
	{

		$find_by_course_ID_sql = "SELECT course_prerequisites.ID, course_prerequisites.courses_ID, courses.course_number, courses.course_name, courses.course_description, courses.course_level, courses.course_hours_lab, courses.course_hours_lecture, courses.course_hours_study, courses.course_hybrid ";
		$find_by_course_ID_sql .= " FROM courses, course_prerequisites WHERE course_prerequisites.courses_ID = ";
		$find_by_course_ID_sql .= $ID . " AND course_prerequisites.course_prerequisites_course_number = courses.course_number AND course_prerequisites.programs_id=".$program_ID;
   

		//return the results as a course object
		return self::find_by_sql( $find_by_course_ID_sql );

	}


	/**
	 * @param $courses_ID
	 * @param $course_prerequisites_course_number
	 *
	 * @return array
	 */
	public static function find_by_course_ID_and_course_prerequisite_course_number( $programs_ID, $courses_ID, $course_prerequisites_course_number )
{
		$find_by_course_ID_sql = "SELECT course_prerequisites.ID, course_prerequisites.courses_ID, courses.course_number, courses.course_name, courses.course_description, courses.course_level, courses.course_hours_lab, courses.course_hours_lecture, courses.course_hours_study, courses.course_hybrid ";
		$find_by_course_ID_sql .= " FROM courses, course_prerequisites WHERE course_prerequisites.programs_ID = " . $programs_ID . " AND course_prerequisites.courses_ID = ";
		$find_by_course_ID_sql .= $courses_ID . " AND course_prerequisites.course_prerequisites_course_number = '" . $course_prerequisites_course_number . "'";

		//return the results as a course object
		return self::find_by_sql( $find_by_course_ID_sql );

	}


}


/**
 * Class CourseEquivalence
 *
 * CRUD for course equivalence -> CRUD is inherited from MySQLDB
 *
 */
class CourseEquivalence extends Course
{

	protected static $table_name = "course_equivalence";

	protected static $database_fields = array(
		'ID',
		'course_equivalence_course_number',
		'course_equivalence_name',
		'course_equivalence_description'
	);

	public $ID;
	public $course_equivalence_course_number;
	public $course_equivalence_name;
	public $course_equivalence_description;

	/**
	 * @param $ID
	 *
	 * @return array
	 */
	public static function find_by_course_ID( $ID )
	{

		//TODO: create sql statement to find the course equivalence

		$find_by_course_ID_sql = "";


		//return the results as a course object
		return parent::find_by_sql( $find_by_course_ID_sql );

	}


}

/**
 * Class CourseProfessor
 *
 * CRUD for course professors -> CRUD is inherited from MySQLDB
 *
 */
class CourseProfessor extends Course
{

	protected static $table_name = "professor";

	protected static $database_fields = array(
		'ID',
		'professor_fname',
		'professor_lname',
		'professor_email',
		'professor_phone',
	);

	public $ID;
	public $professor_fname;
	public $professor_lname;
	public $professor_email;
	public $professor_phone;

	/**
	 * @param $ID
	 *
	 * @return array
	 */
	public static function find_by_course_ID( $ID )
	{

		//TODO: create sql statement to find the professors for the course

		$find_by_course_ID_sql = "";


		//return the results
		return self::find_by_sql( $find_by_course_ID_sql );

	}

	/**
	 * @param $ID
	 *
	 * @return array
	 */
	public static function add_to_course_by_course_ID( $ID )
	{

		//TODO: create sql statement to add the professors to a course

		$add_to_course_by_course_ID_sql = "";


		//return the results
		return self::find_by_sql( $add_to_course_by_course_ID_sql );

	}

}