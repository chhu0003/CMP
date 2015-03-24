<?php

/*
 * Since this class extends the Validator class it requires Validator.php to function.
 * */
require_once "Validator.php";

/*
 * UserValidator inherits the Validator class.
 * No overriding should happen in this class.
 * */
class UserValidator extends Validator
{
    /*
     * $roles is a static variable that must be an array of key => value pairs where the
     * key is an int that represents the user_role as received by $_SESSION['user_role']
     * and the value is an array of strings representing the field names that are
     * accessible to the current user.
     * */
    protected static $roles = array(
    //Role 11 = Superuser
    11 => array("user_login", "user_pass", "user_fname", "user_lname", "user_email", 
        "user_role"),
    //Role 10 = Administrator
	10 => array("user_login", "user_pass", "user_fname", "user_lname", "user_email", 
		"user_role"),
        //Role 9 = Administrator's Assistant
	9 => array(""),
        //Role 8 = Professor
	8 => array("user_fname", "user_lname", "user_email"));

    /*
     * The field in the database is varchar(60) so 60 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateUserLogin($field)
	{
		parent::evaluateStrLen($field, 1, 60);
	}

    /*
     * The field in the database is varchar(100) so 100 is the max.
     * A password must be 8+ characters so 8 is the minimum.
     * Also verify that the password passes regex.
     * */
    protected function validateUserPass($field)
	{
		if (parent::evaluateStrLen($field, 8, 100))
		{
            parent::passwordRegex($field);
		}
	}

    /*
     * The field in the database is varchar(50) so 50 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateUserFname($field)
	{
        parent::evaluateStrLen($field, 1, 50);
	}

    /*
     * The field in the database is varchar(50) so 50 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateUserLname($field)
	{
        parent::evaluateStrLen($field, 1, 50);
	}

    /*
     * The field in the database is varchar(100) so 100 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateUserEmail($field)
	{
        if(parent::evaluateStrLen($field, 1, 100))
        {
            parent::emailRegexUser($field);
        }
	}

    /*
     * Check for valid values.
     * */
	protected function validateUserRole($field)
	{
		if (strtolower(static::$values[$field]) === "10" ||//coordinator
			strtolower(static::$values[$field]) === "9" ||//assistant
			strtolower(static::$values[$field]) === "8" )//professor
		{
			static::$receivedFields[$field] = true;
		}
		else
		{
			static::$errorMessage .= "ERROR: Invalid role. ";
		}
	}
}
?>