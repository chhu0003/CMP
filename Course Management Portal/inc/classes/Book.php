<?php

/**
 * Author: Eric Tubby
 *
 * Class Book
 *
 * CRUD for books -> CRUD is inherited from MySQLDB
 *
 * Set all of the fields that you want to get from the table in $database_fields
 * then, create variable's with the exact same names as the fields set in $database_fields.
 *
 * This applies to all children of this class, if any exist.
 *
 */
class Book extends MySQLDB
{

	protected static $table_name = "books";


	protected static $database_fields = array(
		'ID',
		'book_title',
		'book_isbn',
		'book_edition',
		'book_author',
		'book_publisher',
		'book_type',
		'book_quantity',
		'book_required',
		'courses_ID'
	);


	public $ID;
	public $book_title;
	public $book_isbn;
	public $book_edition;
	public $book_author;
	public $book_publisher;
	public $book_type;
	public $book_quantity;
	public $book_required;
	public $courses_ID;

	/**
	 * @param $ID
	 *
	 * @return bool|mixed
	 */
	public static function find_by_course_ID( $ID )
	{

		$find_by_course_ID_sql = "SELECT * FROM " . self::$table_name . " WHERE courses_ID='$ID'";

		//query the database with the user_login
		return self::find_by_sql( $find_by_course_ID_sql );

	}

	public static function find_by_isbn( $book_isbn )
	{

		$find_by_book_isbn_sql = "SELECT * FROM " . self::$table_name . " WHERE book_isbn='$book_isbn'";

		//query the database with the user_login
		$result_array = self::find_by_sql( $find_by_book_isbn_sql );

		//if the $result_array isn't empty use array_shift() so that only the book object inside the array is
		//returned. Otherwise, return false so that we know the book wasn't found
		return !empty( $result_array ) ? array_shift( $result_array ) : false;

	}

} 