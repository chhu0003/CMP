<?php

/*
 * Since this class extends the Validator class it requires Validator.php to function.
 * */
require_once "Validator.php";

/*
 * UserValidator inherits the Validator class.
 * No overriding should happen in this class.
 * */
class ProgramValidator extends Validator
{
    /*
     * $roles is a static variable that must be an array of key => value pairs where the
     * key is an int that represents the user_role as received by $_SESSION['user_role']
     * and the value is an array of strings representing the field names that are
     * accessible to the current user.
     * */
    protected static $roles = array(
    //Role 11 = SuperUser
    11 => array("program_code", "program_name", "program_version", "program_flowchart", 
        "program_year"),
        //Role 10 = Administrator
    10 => array("program_code", "program_name", "program_version", "program_flowchart", 
        "program_year"),
        //Role 9 = Administrator's Assistant
    9 => array("program_code", "program_name", "program_version", "program_flowchart", 
        "program_year"),
        //Role 8 = Professor
    8 => array("program_code", "program_name", "program_version", "program_flowchart", 
        "program_year")
    );

    /*
     * The field in the database is varchar(45) so 45 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateProgramCode($field)
    {
        parent::evaluateStrLen($field, 1, 45);
    }

    /*
     * The field in the database is varchar(100) so 100 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateProgramName($field)
    {
        parent::evaluateStrLen($field, 1, 100);
    }

    /*
     * The field in the database is varchar(45) so 45 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateProgramVersion($field)
    {
        parent::evaluateStrLen($field, 1, 45);
    }

    /*
     * The field in the database is varchar(45) so 45 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateProgramFlowchart($field)
    {
        if(parent::evaluateStrLen($field, 1, 45))
        {
            parent::evaluateStrLen($field, 1, 45);
        }
    }

    /*
     * Phone number must be a 4 digit whole number
     * */
    protected function validateProgramYear($field)
    {
        if(!parent::evaluateStrLen($field, 4, 4))
        {
            parent::evaluateWholeNumber($field);
        }
    }
}
?>