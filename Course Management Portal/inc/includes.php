<?php

/*
 * holds all of the includes needed
 *
 * this file should probably be included in the header.php using require_once( dirname( __FILE__ ) . 'inc/includes.php'  );
 *
 * any other files that need to be included should be included here
 */

// include the classes
require_once( dirname( __FILE__ ) . '/classes/MySQLDB.php' );
require_once( dirname( __FILE__ ) . '/classes/User.php' );
require_once( dirname( __FILE__ ) . '/classes/Session.php' );
require_once( dirname( __FILE__ ) . '/classes/Course.php' );
require_once( dirname( __FILE__ ) . '/classes/Student.php' );
require_once( dirname( __FILE__ ) . '/classes/Book.php' );
require_once( dirname( __FILE__ ) . '/classes/Program.php' );
require_once( dirname( __FILE__ ) . '/classes/Validator.php' );
require_once( dirname( __FILE__ ) . '/classes/UserValidator.php' );
require_once( dirname( __FILE__ ) . '/classes/TextbookValidator.php' );
require_once( dirname( __FILE__ ) . '/classes/StudentValidator.php' );
require_once( dirname( __FILE__ ) . '/classes/CourseValidator.php' );
require_once( dirname( __FILE__ ) . '/classes/ProgramValidator.php' );


//include functions
require_once( dirname( __FILE__ ) . '/functions.php' );
