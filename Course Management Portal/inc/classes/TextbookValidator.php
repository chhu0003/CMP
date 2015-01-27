<?php

/*
 * Since this class extends the Validator class it requires Validator.php to function.
 * */
require_once "Validator.php";

/*
 * UserValidator inherits the Validator class.
 * No overriding should happen in this class.
 * */
class TextbookValidator extends Validator
{

    /*
     * $roles is a static variable that must be an array of key => value pairs where the
     * key is an int that represents the user_role as received by $_SESSION['user_role']
     * and the value is an array of strings representing the field names that are
     * accessible to the current user.
     * */
    protected static $roles = array(
        //Role 10 = Administrator
	10 => array("book_title", "book_isbn", "book_edition", "book_author", "book_publisher", 
		"book_type", "book_required", "book_quantity"),
        //Role 9 = Administrator's Assistant
	9 => array("book_title", "book_isbn", "book_edition", "book_author", "book_publisher", 
		"book_type", "book_required", "book_quantity"),
        //Role 8 = Professor
	8 => array("book_title", "book_isbn", "book_edition", "book_author", "book_publisher", 
		"book_type", "book_required", "book_quantity"));

    /*
     * The field in the database is varchar(100) so 100 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateBookTitle($field)
	{
        parent::evaluateStrLen($field, 1, 100);
	}

    /*
     * The field in the database is varchar(100) so 100 is the max.
     * The field cannot be empty so 1 is the minimum.
     * */
    protected function validateBookISBN($field)
	{
        parent::evaluateStrLen($field, 0, 150);
	}

    /*
     * The field in the database is varchar(45) so 45 is the max.
     * The field can be blank.
     * */
    protected function validateBookEdition($field)
	{
        parent::evaluateStrLen($field, 0, 45);
	}

    /*
     * The field in the database is varchar(45) so 45 is the max.
     * The field can be blank.
     * */
    protected function validateBookAuthor($field)
	{
        parent::evaluateStrLen($field, 0, 45);
	}

    /*
     * The field in the database is varchar(45) so 45 is the max.
     * The field can be blank.
     * */
    protected function validateBookPublisher($field)
	{
        parent::evaluateStrLen($field, 0, 45);
	}

    /*
     * Check for valid values.
     * */
    protected function validateBookType($field)
	{
		if (static::$values[$field] === "1" || static::$values[$field] === "2" || static::$values[$field] === "3")
        {
			static::$receivedFields[$field] = true;
		}
		else
		{
			static::$errorMessage .= "ERROR: Book Type - Invalid selection. ";
		}
	}

    /*
     * Check for valid values.
     * */
    protected function validateBookRequired($field)
	{
		if (static::$values[$field] === "0" || static::$values[$field] === "1")
        {
			static::$receivedFields[$field] = true;
		}
		else
		{
			static::$errorMessage .= "ERROR: Book Required - Invalid selection. ";
		}
	}

    /*
     * Quantity must be a whole number
     * */
    protected function validateBookQuantity($field)
	{
		parent::evaluateWholeNumber($field);
	}
}
?>