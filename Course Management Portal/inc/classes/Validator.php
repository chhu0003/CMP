<?php

/*
This class is an abstract class because it is not complete.
It needs a child class to implement specific field validators.
*/
abstract class Validator
{
	/*
	$oldValues needs to be an array of key => value pairs where
	each key is a string found in the database as field names and
	each value is a string taken from the database at the time when input fields
	are being populated, or empty strings when there is no data populated
	*/
	protected $oldValues;
	/*
	$values needs to be an array of key => value pairs where
	each key is a string found in the database as field names and
	each value is a string taken from the input fields being submitted
	*/
	protected static $values;
	/*
	$errorMessage needs to be a string that is being displayed on the
	page where an error block should be seen by the user.
	NOTE: All errors will be displayed together.
	*/
	protected static $errorMessage = "";
	/*
	$receivedFields is an array of key => value pairs where
	each key is a string found in the database as field names and
	each value is a boolean or null that identifies a status.
	TRUE = The field has been validated successfully
	FALSE = The field has not passed validation
	NULL = The field is identical to the $oldValue parallel
	and so it does not need validation.
	*/
	protected static $receivedFields;
	/*
	$exceptionMessage is a string message that will be thrown as an
	exception if any are found.
	*/
	protected $exceptionMessage;

	/*
	As described above, params $oldValues and $values
	will be needed to build a functional and valid Validator object.
	
	__constructor will throw an exception if it does not receive matching
	fields in $oldValues and $values.
	This exception is intended to inform the developer of any mistakes
	and reduce debugging.

	static::$roles is used here and must be defined in the child as
	protected static $roles and uses the $_SESSION['user_role'] to
	identify what fields can be modified by the current user.
	*/
	public function __construct(array $oldValues, array $values)
	{		
		foreach ($values as $field => $value) 
		{
			//Look for $field anywhere in the array of acceptable fields
			if (in_array($field, static::$roles[$_SESSION["user_role"]])) 
			{
				//Create key => value pair with value of false
				static::$receivedFields[$field] = false;

				//Looks for $field matching key from $values to $oldValues
				if( !array_key_exists($field, $oldValues))
					$this->exceptionMessage .= "<div>DEV ERROR: Validator argument \"".$field."\" not passed properly.</div>";
			}

		}

		$this->isValidObject($oldValues, $values);
	}

	/*
	run needs to be called to actually perform the validation.
	The return value will indicate a status.
	TRUE = The Validator did not find any errors in values.
	String Value = The Validator found errors in values.
	*/
	public function run()
	{
		foreach (static::$receivedFields as $field => $val)
		{
			//If no values are identical, do not waste time validating.
			if ($this->oldValues[$field] === static::$values[$field])
			{
				static::$receivedFields[$field] = null;
			}
			//Else validate the value.
			else
			{
				//Call child function validateFieldName($field)
				call_user_func(array($this,"validate".str_replace('_', '', $field)), $field);
			}
		}

        //Count number of values that are null
        $counter = 0;
		foreach (static::$receivedFields as $isSuccess)
		{
			if ($isSuccess === null)
			{
				$counter++;
			}
		}

        //If all old and new values are identical return null
        if ($counter == sizeof(static::$receivedFields))
        {
            return "No changes were made.";
        }

		//If any validation did not pass, return false.
		foreach (static::$receivedFields as $isSuccess)
		{ 
			if ($isSuccess === false)
			{
				return static::$errorMessage;
			}
		}

		//All validation passed, return true
		return true;
	}

	/*
	isValidObject simply sets the class level variables if no exception
	message has been added or it throws an exception.
	*/
	protected function isValidObject($oldValues, $values)
	{
		//If no exception message was added set values.
		if(!$this->exceptionMessage)
		{
            static::$values = $values;
			$this->oldValues = $oldValues;
		}
		//Else throw exception to warn the developper of the errors.
		else
		{
			throw new Exception($this->exceptionMessage);
		}
	}

    /*
     * evaluateStrLen evaluates the string length to ensure it is within the range of
     * desired characters.
     * Param $field is a string value taken from a database field name.
     * Param $min is an int that is equal to the minimum length of the valid $values value.
     * Param $max is an int that is equal to the maximum length of the valid $values value.
     * It returns a boolean to indicate if validation passed.
     * TRUE = Validation passed.
     * FALSE = Validation did not pass.
     * */
	protected function evaluateStrLen($field, $min, $max)
	{
		$length = strlen(static::$values[$field]);
		if ($length < $min || $length > $max)
		{
            static::$errorMessage .= "<div>".ucwords(str_replace('_', ' ', $field))." minimum ".$min." and maximum ".$max." characters, ".$length." characters provided. </div>";
			static::$receivedFields[$field] = false;
			return false;
		}
		else
		{
			static::$receivedFields[$field] = true;
			return true;
		}
	}

    /*
     * evaluateWholeNumber evaluates the $values value to ensure it is a whole number.
     * Param $field is a int value taken from a database field name.
     * It returns a boolean to indicate if validation passed.
     * TRUE = Validation passed.
     * FALSE = Validation did not pass.
     * */
	protected function evaluateWholeNumber($field)
	{
		if(is_numeric(static::$values[$field]) && intval(static::$values[$field]) >= 0)
		{
            static::$values[$field] = intval(static::$values[$field]);
			static::$receivedFields[$field] = true;
			return true;
		}
		else
		{
            static::$$errorMessage .= "Value must be a positive whole number. ";
            static::$receivedFields[$field] = false;
			return false;
		}
	}

    /*
     * emailRegexUser evaluates the string email for a User to ensure it is a
     * @algonquincollege.com email address.
     * Param $field is a string value taken from a database field name.
     * It returns a boolean to indicate if validation passed.
     * TRUE = Validation passed.
     * FALSE = Validation did not pass.
     * */
	protected function emailRegexUser($field)
	{
		$emailRegex = '#.*@algonquincollege.com$#i';
		if(preg_match($emailRegex, static::$values[$field]))
		{
			static::$receivedFields[$field] = true;
			return true;
		}
		else
			{
				static::$errorMessage .= "<div>".ucwords(str_replace('_', ' ', $field)). " must be @algonquincollege.com. </div>";
				static::$receivedFields[$field] = false;
				return false;
			}
	}

    /*
     * emailRegexStudent evaluates the string email for a Student to ensure it is a
     * @algonquinlive.com email address.
     * Param $field is a string value taken from a database field name.
     * It returns a boolean to indicate if validation passed.
     * TRUE = Validation passed.
     * FALSE = Validation did not pass.
     * */
	protected function emailRegexStudent($field)
	{
		$emailRegex = '#.*@algonquinlive.com$#i';
		if(preg_match($emailRegex, static::$values[$field]))
		{
			$receivedFields[$field] = true;
			return true;
		}
		else
			{
				static::$$errorMessage .= "<div>".ucwords(str_replace('_', ' ', $field)). " must be @algonquinlive.com. </div>";
				static::$receivedFields[$field] = false;
				return false;
			}
	}

    /*
     * passwordRegex evaluates the string not-hashed password to ensure that it has
     * the required complexity.
     * Param $field is a string value taken from a database field name.
     * It returns a boolean to indicate if validation passed.
     * TRUE = Validation passed.
     * FALSE = Validation did not pass.
     * */
	protected function passwordRegex($field)
	{
        //characters at least 1 uppercase , 1 lowercase and 1 number
		$uppercase = preg_match('@[A-Z]@', static::$values[$field]);
		$lowercase = preg_match('@[a-z]@', static::$values[$field]);
		$number    = preg_match('@[0-9]@', static::$values[$field]);

		if($uppercase && $lowercase && $number && strlen(static::$values[$field]) >= 8)//Minimum 8
		{
			static::$receivedFields[$field] = true;
			return true;
		}
		else
		{
			static::$$errorMessage .= "<div>".ucwords(str_replace('_', ' ', $field)). " must be 8 characters long, have one uppercase, one lowercase and one number. </div>";
			static::$receivedFields[$field] = false;
			return false;
		}
	}
}
?>