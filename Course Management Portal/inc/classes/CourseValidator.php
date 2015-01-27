<?php
/*
 * Since this class extends the Validator class it requires Validator.php to function.
 * */
require_once "Validator.php";

/*
 * UserValidator inherits the Validator class.
 * No overriding should happen in this class.
 * */
class CourseValidator extends Validator
{
    /*
     * $roles is a static variable that must be an array of key => value pairs where the
     * key is an int that represents the user_role as received by $_SESSION['user_role']
     * and the value is an array of strings representing the field names that are
     * accessible to the current user.
     * */
protected static $roles = array(
    //Role 10 = Administrator
	10 => array("course_number", "course_name", "course_description", "course_level",
	"course_hours_lab", "course_hours_lecture", "course_hours_study", "course_hybrid", 
	),
    //Role 9 = Administrator's Assistant
	9 => array("course_number", "course_name", "course_description", "course_level",
		"course_hours_lab", "course_hours_lecture", "course_hours_study", "course_hybrid"
	),
    //Role 8 = Professor
	8 => array("course_number", "course_name", "course_description", "course_level",
	"course_hours_lab", "course_hours_lecture", "course_hours_study", "course_hybrid"
	));

    /*
     * The field in the database is varchar(50) so 50 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
	protected function validateCourseNumber($field)
	{
        parent::evaluateStrLen($field, 1, 50);
	}

    /*
     * The field in the database is varchar(100) so 100 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateCourseName($field)
	{
        parent::evaluateStrLen($field, 1, 100);
	}

    /*
     * The field in the database is varchar(1500) so 1500 is the max.
     * The field can be empty.
     * */
    protected function validateCourseDescription($field)
	{
        parent::evaluateStrLen($field, 0, 1500);
	}

    /*
     * Field must be a whole number.
     * */
    protected function validateCourseLevel($field)
	{
        parent::evaluateWholeNumber($field);
	}

    /*
     * Field must be a whole number.
     * */
	protected function validateCourseHoursLab($field)
	{
		parent::evaluateWholeNumber($field);
	}

    /*
     * Field must be a whole number.
     * */
	protected function validateCourseHoursLecture($field)
	{
		parent::evaluateWholeNumber($field);
	}

    /*
     * Field must be a whole number.
     * */
	protected function validateCourseHoursStudy($field)
	{
		parent::evaluateWholeNumber($field);
	}

    /*
     * Check for valid values.
     * */
    protected function validateCourseHybrid($field)
	{
		if (static::$values[$field] === "1" || static::$values[$field] === "0") {
			static::$receivedFields[$field] = true;
		}
		else
		{
			static::$errorMessage .= "ERROR: Hybrid - Invalid selection. ";
		}
	}
}
?>