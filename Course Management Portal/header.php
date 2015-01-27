<?php

//get all of the includes
require_once( dirname( __FILE__ ) . '/inc/includes.php' );

//if the user isn't logged in, send them back to the login page
if( !$session->is_logged_in() ) {
	header( 'Location: index.php' );
	exit();
}

//check to see if the course_number is set, it should be if the user is coming from the flow chart page
if( isset( $_GET[ 'course_ID' ] ) && $_GET[ 'course_ID' ] != 0 ) {

	//get the current course by course_number
	$course = Course::find_by_ID( $_GET[ 'course_ID' ] );

	$_SESSION[ 'course_ID' ] = $_GET[ 'course_ID' ];

	//get the course management header
	require_once( dirname( __FILE__ ) . '/course-management-header.php' );

} elseif( strpos( $_SERVER[ 'SCRIPT_FILENAME' ], 'manage-users.php' ) || $_GET[ 'course_ID' ] == 0 ) {

	if( isset( $_GET[ 'course_ID' ] ) && $_GET[ 'course_ID' ] == 0 ) {

		$pageTitle = "Add New Course";

	} else {
		$pageTitle = "Manage Users";
	}

	//get the manage-users header
	require_once( dirname( __FILE__ ) . '/add-user-or-course-header.php' );

} else {

	//the user didn't come from the flow chart page, send the user back to the flow-chart page
	//to select a course
	header( 'Location: flow-chart.php' );
	exit();

}



