<?php

require_once( dirname( dirname( __FILE__ ) ) . '/includes.php' );

//ajax response for manage-students.php

if( !empty( $_REQUEST[ "student_number" ] ) ) {

	$matchStudent      = Student::find_by_student_number( $_REQUEST[ "student_number" ] );
	$matchStudentGrade = StudentGrade::find_by_student_number_and_course_ID( $_REQUEST[ "student_number" ], $_SESSION['course_ID'] );

	if( $_REQUEST[ "student_number" ] == "add_student" ) { //send fields with empty values

		echo "<tr>";
		echo "<td>Student Number:</td><td>";
		echo "<div id='ajaxsymbol' style='display: none;'><img src='images/ajax-loader.gif' width='16' height='16' alt='ajax-loading-symbol' /></div>";
		echo "<input type='text' name='txtStudentNumber' id='txtStudentNumber' value='' onkeyup='getResultsFromManageStudentsSearch(this.value); showAJAXLoadingIndicator();' placeholder='Student Lookup' />";
		echo "<div id='manage-student-search-results'></div>";
		echo "</td>";
		echo "</tr><tr>";
		echo "<td>First Name:</td><td><input type='text' name='txtFirstName' value='' disabled /></td>";
		echo "</tr><tr>";
		echo "<td>Last Name:</td><td><input type='text' name='txtLastName' value='' disabled /></td>";
		echo "</tr><tr>";
		echo "<td>Email:</td><td><input type='email' name='txtStudentEmail' value='' disabled /></td>";
		echo "</tr><tr>";
		echo "<td>Phone Number:</td><td><input type='text' name='txtStudentPhone' value='' disabled /></td>";
		echo "<tr>";
		echo "<tr>";
		echo "<td>Letter Grade: </td><td><input type='text' id='txtLetterGrade' name='txtLetterGrade' disabled /></td>";
		echo "</tr>";

		echo "<td><input type='submit' value='Register Student' name='txtRegisterStudent'>";

	} elseif( $matchStudent ) { //send fields with the values of the selected student

		//check to see if the student is already in this course
		$studentAlreadyRegistered = StudentCourse::find_by_student_number_and_course_ID( $_REQUEST[ "student_number" ], $_SESSION['course_ID'] );
		$oldValues=array(
							"student_number"=>$matchStudent->student_number,
							"student_fname"=> $matchStudent->student_fname,
							"student_lname"=>$matchStudent->student_lname,
							"student_email"=>$matchStudent->student_email,
							"student_phone"=>$matchStudent->student_phone,
							"letter_grade"=>(isset($matchStudentGrade->letter_grade)) ? $matchStudentGrade->letter_grade : '',
						);

		$_SESSION['studentOldValues'] = $oldValues;

							
		echo "<tr>";
		echo "<td>Student Number:</td><td><input type='number' name='txtStudentNumber' value='" . $matchStudent->student_number . "' required='required'></td>";
		echo "</tr><tr>";
		echo "<td>First Name:</td><td><input type='text' id='txtFirstName' name='txtFirstName' value='" . $matchStudent->student_fname . "' required='required' ></td>";
		echo "</tr><tr>";
		echo "<td>Last Name:</td><td><input type='text' id='txtLastName' name='txtLastName' value='" . $matchStudent->student_lname . "' required='required' ></td>";
		echo "</tr><tr>";
		echo "<td>Email:</td><td><input type='email' name='txtStudentEmail' value='" . $matchStudent->student_email . "'></td>";
		echo "</tr><tr>";
		echo "<td>Phone Number:</td><td><input type='text' name='txtStudentPhone' value='" . $matchStudent->student_phone . "' ></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Letter Grade: </td><td><input type='text' id='txtLetterGrade' name='txtLetterGrade' value='";
		(isset($matchStudentGrade->letter_grade)) ? print($matchStudentGrade->letter_grade) : print('');
		echo "' ></td>";
		echo "</tr>";


		//if the student is already registered in this course
		if( $studentAlreadyRegistered ){

			//give the option to update the student
			echo "<td><input type='submit' value='Update Student' name='txtSaveStudent'>";

			//give the option to remove the student from the course
			echo "</td></tr>";
			echo "<tr><td><input type='submit' value='Remove Student From Course' name='txtRemoveStudent' onclick='return confirm(\"Are you sure you want to remove " . $matchStudent->full_name() . " from this course?\\n\\nThis will remove the students grade from this course as well.\\n\\nThis cannot be undone!\"  )' /></td>";
			echo "</tr>";
			echo "<tr><td><input type='submit' value='Delete Student' name='txtDeleteStudent' onclick='return confirm(\"Are you sure you want to delete " . $matchStudent->full_name() . "? \\nThis will delete the student and the students grades from all courses\\n\\n This cannot be undone!\"  )' /></td>";
			echo "</tr>";

		}else{
			//give the option to register the student to the course or delete the student
			echo "<td><input type='submit' value='Register Student' name='txtRegisterExistingStudent'>";
			echo "<tr><td><input type='submit' value='Delete Student' name='txtDeleteStudent' onclick='return confirm(\"Are you sure you want to delete " . $matchStudent->full_name() . "? \\nThis will delete the student and the students grades from all courses\\n\\n This cannot be undone!\"  )' /></td>";
			echo "</tr>";
		}


	} elseif( !$matchStudent ) {

		echo "<tr>";
		echo "<td>Student Number:</td><td>";
		echo "<div id='ajaxsymbol' style='display: none;'><img src='../../images/ajax-loader.gif' width='16' height='16' alt='ajax-loading-symbol' /></div>";
		echo "<input type='number' id='txtStudentNumber' name='txtStudentNumber'  value='". $_REQUEST[ "student_number" ] ."' required='required' />";
		echo "</td>";
		echo "</tr><tr>";
		echo "<td>First Name:</td><td><input type='text' name='txtFirstName' value='' required='required' /></td>";
		echo "</tr><tr>";
		echo "<td>Last Name:</td><td><input type='text' name='txtLastName' value='' required='required' /></td>";
		echo "</tr><tr>";
		echo "<td>Email:</td><td><input type='email' name='txtStudentEmail' value=''  /></td>";
		echo "</tr><tr>";
		echo "<td>Phone Number:</td><td><input type='text' name='txtStudentPhone' value=''  /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Letter Grade: </td><td><input type='text' id='txtLetterGrade' name='txtLetterGrade' /></td>";
		echo "</tr>";

		echo "<td><input type='submit' value='Register Student' name='txtRegisterStudent'>";

	}

}

function calculateGPA( $grade )
{
	$grade = (float)$grade;

	if( $grade >= 90 )
		return "A+";
	else if( $grade >= 85 )
		return "A";
	else if( $grade >= 80 )
		return "A-";
	else if( $grade >= 77 )
		return "B+";
	else if( $grade >= 73 )
		return "B";
	else if( $grade >= 70 )
		return "B-";
	else if( $grade >= 67 )
		return "C+";
	else if( $grade >= 63 )
		return "C";
	else if( $grade >= 60 )
		return "C-";
	else if( $grade >= 57 )
		return "D+";
	else if( $grade >= 53 )
		return "D";
	else if( $grade >= 50 )
		return "D-";
	else if( $grade < 50 ) // && $grade >=0)
		return "F";
	else
		return "FSP";

}