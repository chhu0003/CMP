<?php

/*
 * Since this class extends the Validator class it requires Validator.php to function.
 * */
require_once "Validator.php";

/*
 * UserValidator inherits the Validator class.
 * No overriding should happen in this class.
 * */
class StudentValidator extends Validator
{
    /*
     * $roles is a static variable that must be an array of key => value pairs where the
     * key is an int that represents the user_role as received by $_SESSION['user_role']
     * and the value is an array of strings representing the field names that are
     * accessible to the current user.
     * */
    protected static $roles = array(
        //Role 10 = Administrator
	10 => array("student_number", "student_fname", "student_lname", "student_email", 
		"student_phone", "letter_grade", "numeric_grade"),
        //Role 9 = Administrator's Assistant
	9 => array("student_number", "student_fname", "student_lname", "student_email",
		"student_phone", "letter_grade", "numeric_grade"),
        //Role 8 = Professor
	8 => array("student_number", "student_fname", "student_lname", "student_email", 
		"student_phone", "letter_grade", "numeric_grade")
    );

    /*
     * Student number must be a 9 digit whole number
     * */
    protected function validateStudentNumber($field)
	{
		if(parent::evaluateStrLen($field, 9, 9))
		{
            parent::evaluateWholeNumber($field);
		}
	}

    /*
     * The field in the database is varchar(50) so 50 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateStudentFname($field)
	{
        parent::evaluateStrLen($field, 1, 50);
	}

    /*
     * The field in the database is varchar(50) so 50 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateStudentLname($field)
	{
        parent::evaluateStrLen($field, 1, 50);
	}

    /*
     * The field in the database is varchar(100) so 100 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateStudentEmail($field)
	{
        if(parent::evaluateStrLen($field, 1, 100))
        {
            parent::emailRegexStudent($field);
        }
	}

    /*
     * Phone number must be a 9 digit whole number
     * */
    protected function validateStudentPhone($field)
	{
		if(!parent::evaluateStrLen($field, 9, 9))
		{
            parent::evaluateWholeNumber($field);
		}
	}

    /*
     * Check for valid values.
     * */
    protected function validateLetterGrade($field)
	{
		$validLetterGrades = array(	'A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F', 'NCR', 'PLAR' );

		if ( in_array( strtoupper(static::$values[$field]), $validLetterGrades) )
		{
			static::$receivedFields[$field] = true;
		}
		else
		{
			static::$errorMessage .= "ERROR: Letter Grade - Invalid letter grade. ";
		}
	}

    //At this time, this field is not editable.
    protected function validateNumericGrade($field)
	{
		if (parent::evaluateStrLen($field, 0, 3))
		{
			//will allow for values over 100
			parent::evaluateWholeNumber($field);
		}
	}
}
?>