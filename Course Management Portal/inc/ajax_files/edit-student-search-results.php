<?php
/**
 * Created by PhpStorm.
 * User: Eric Tubby
 * Date: 4/6/14
 * Time: 1:08 PM
 * Modified by JM(April, 2015)
 */

require_once( dirname( dirname( __FILE__ ) ) . '/includes.php' );

//get the search parameter from URL
$search = $_GET[ "search" ];

//lookup all links from the xml file if length of search>0
if( strlen( $search ) > 0 ) {

	$hint = "";

	//get all of the students
	$allStudents = Student::find_all_by_archive_date($student_ID);

	//loop through each of the students
	foreach( $allStudents as $student  ) {

		//setup the information to search against
		$studentInformationToSearch = $student->student_number . " - " . $student->student_fname . " " . $student->student_lname;

		//if any part of the search matches any part of the current students information
		if( stristr( $studentInformationToSearch, $search ) ) {

			//if the hint is still empty
			if( $hint == "" ) {

				//add the first result
				$hint = '<a href="edit-student.php?student_ID=' . $student->student_number . '" onclick="showSelectedStudent(' . $student->student_number . ')" >' .

					$studentInformationToSearch . "</a>";

			} else {//otherwise, append the next result

				$hint = $hint . '<br /><a href="edit-student.php?student_ID=' . $student->student_number . '" onclick="showSelectedStudent(' . $student->student_number . ')" >' .

					$studentInformationToSearch . '</a>';
			}

		}



	}

}

// Set output to "No student found" if no hints were found and give a link to create a new student
// or to the correct values
if( $hint == "" ) {

	if(!is_numeric($search))//showSelectedStudent() needs a number
		$search = 1;

	$response = "No student found - <a href='#' onclick='showSelectedStudent(". $search .")' >Create a new student</a>";//sending 0 to showSelectedStudent() will return an empty form

} else {

	$response = $hint;

}

//output the response
echo $response;