<?php

require_once( dirname( __FILE__ ) . '/header.php' );


if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

	//enable the fields in the form
	$disabled = "";

	$txtStudentNumber   = $_POST[ 'txtStudentNumber' ];
	$txtFirstName       = $_POST[ 'txtFirstName' ];
	$txtLastName        = $_POST[ 'txtLastName' ];
	$txtStudentEmail    = $_POST[ 'txtStudentEmail' ];
	$txtStudentPhone    = $_POST[ 'txtStudentPhone' ];
	$txtLetterGrade     = strtoupper( $_POST[ 'txtLetterGrade' ] );

	$errors = false; //used for stopping the transaction if any errors are found along the way

	if( isset( $_POST[ 'txtRegisterStudent' ] ) ) //add a student and register them to the course
	{
		//for validation, It should be empty before creating a new student
		$oldValues = array(
			"student_number" => '',
			"student_fname"  => '',
			"student_lname"  => '',
			"student_email"  => '',
			"student_phone"  => '',
			"letter_grade"   => '',
		);

		//for validation,get new values
		$newValues = array(
			"student_number" => $txtStudentNumber,
			"student_fname"  => $txtFirstName,
			"student_lname"  => $txtLastName,
			"student_email"  => $txtStudentEmail,
			"student_phone"  => $txtStudentPhone,
			"letter_grade"   => $txtLetterGrade,
		);

		//send the values to the student validator
		$studentValidation = new StudentValidator( $oldValues, $newValues );

		//run the validation
		$studentValidated = $studentValidation->run();

		//if $studentValidated didn't pass
		if( $studentValidated !== true ) //it has an error message in it
			$errorMessage = $studentValidated; //get it and set it to the $errorMessage

		//if the user validation passed
		if( $studentValidated === true ) {

			//check to see if the student already exists
			$student = Student::find_by_student_number( $txtStudentNumber );

			//if the student doesn't exist
			if( !$student ) {

				//create a new Student object
				$student = new Student();

				//then assign the values
				$student->student_number = $txtStudentNumber;
				$student->student_fname  = $txtFirstName;
				$student->student_lname  = $txtLastName;
				$student->student_email  = $txtStudentEmail;
				$student->student_phone  = $txtStudentPhone;

				//create the student in the database
				$student->save();

			} else {

				$errorMessage = "Student number " . $txtStudentNumber . " is already in use by " . $student->full_name() . ".<br />";
				$errorMessage .= "Please choose a different student number.";

				$errors = true;

			}

			if( !$errors ) {
				//check to see if the student is already registered to this course
				$registeredStudent = StudentCourse::find_by_student_number_and_course_ID( $txtStudentNumber, $_GET[ 'course_ID' ] );

				//if the student isn't already registered to this course, create a new StudentCourse object
				if( !$registeredStudent ) {

					$registerStudent = new StudentCourse();

					//get the student from the students table so that we have access to the ID
					$student = Student::find_by_student_number( $txtStudentNumber );

					//then assign the values
					$registerStudent->students_ID              = $student->ID;
					$registerStudent->student_courses_semester = ''; //can be null
					$registerStudent->courses_ID               = $_GET[ 'course_ID' ];
					$registerStudent->students_student_number  = $txtStudentNumber;

					//register the student for this course
					$registerStudent->save();


					//check to see if the student already has a grade in the course
					$studentHasGrade = StudentGrade::find_by_student_number_and_course_ID( $txtStudentNumber, $_GET[ 'course_ID' ] );

					//if the student doesn't have a grade
					if( !$studentHasGrade ) {

						//create a new StudentGrade
						$studentGrade = new StudentGrade();

						//then assign the values
						$studentGrade->letter_grade            = $txtLetterGrade;
						$studentGrade->courses_ID              = $_GET[ 'course_ID' ];
						$studentGrade->students_ID             = $student->ID;
						$studentGrade->students_student_number = $student->student_number;

						//add the grade for this student in this course
						$studentGrade->save();

					}

				}

			}
			//END if(!$errors)

		}
		//End if( $studentValidated && !empty($studentValidated)

	} elseif( isset( $_POST[ 'txtRegisterExistingStudent' ] ) ) { //register an existing student to the course

		//get the old values from the session which was set in the ajax response
		$oldValues = $_SESSION[ 'studentOldValues' ];

		//Get the new values
		$newValues = array(
			"student_number" => $txtStudentNumber,
			"student_fname"  => $txtFirstName,
			"student_lname"  => $txtLastName,
			"student_email"  => $txtStudentEmail,
			"student_phone"  => $txtStudentPhone,
			"letter_grade"   => $txtLetterGrade,
		);


		$studentValidation = new StudentValidator( $oldValues, $newValues );

		//run the validation
		$studentValidated = $studentValidation->run();

		//if the $userValidator didn't pass
		if( $studentValidated !== true ) //it has an error message in it
			$errorMessage = $studentValidated;
		//get it and set it to the $errorMessage

		//if the user validation passed
		if( $studentValidated === true || $studentValidated == "No changes were made." ) {

			$errorMessage ='';//no need to show that no changes were made to the student while adding them to the course

			//check to see if the student already exists with this student number
			$student = Student::find_by_student_number( $txtStudentNumber );

			//if a student exists with this student number and it is the same as the old value
			if( $student ) {

				//then assign the values to update
				$student->student_fname = $txtFirstName;
				$student->student_lname = $txtLastName;
				$student->student_email = $txtStudentEmail;
				$student->student_phone = $txtStudentPhone;

				//update the student in the database
				$student->save();

			}

			//check to see if the student is already registered to this course
			$registeredStudent = StudentCourse::find_by_student_number_and_course_ID( $txtStudentNumber, $_GET[ 'course_ID' ] );

			//if the student isn't already registered to this course, create a new StudentCourse object
			if( !$registeredStudent ) {

				$registerStudent = new StudentCourse();

				//get the student from the students table so that we have access to the ID
				$student = Student::find_by_student_number( $txtStudentNumber );

				//then assign the values
				$registerStudent->students_ID              = $student->ID;
				$registerStudent->student_courses_semester = ''; //can be null
				$registerStudent->courses_ID               = $_GET[ 'course_ID' ];
				$registerStudent->students_student_number  = $txtStudentNumber;

				//register the student for this course
				$registerStudent->save();

			}

			//check to see if the student already has a grade in the course
			$studentGrade = StudentGrade::find_by_student_number_and_course_ID( $txtStudentNumber, $_GET[ 'course_ID' ] );

			//if the student has a grade
			if( $studentGrade ) {

				//then assign the values
				$studentGrade->letter_grade            = $txtLetterGrade;
				$studentGrade->courses_ID              = $_GET[ 'course_ID' ];
				$studentGrade->students_ID             = $student->ID;
				$studentGrade->students_student_number = $student->student_number;

				//update the students grade for this course
				$studentGrade->save();

			} else{

				//create a new StudentGrade
				$studentGrade = new StudentGrade();

				//then assign the values
				$studentGrade->letter_grade            = $txtLetterGrade;
				$studentGrade->courses_ID              = $_GET[ 'course_ID' ];
				$studentGrade->students_ID             = $student->ID;
				$studentGrade->students_student_number = $student->student_number;

				//add the students grade for this course
				$studentGrade->save();

			}
		}
		//End if( $studentValidated == true || $studentValidated == "No changes were made." )

	}elseif( isset( $_POST[ 'txtSaveStudent' ] ) ) { //update the student

		//get the old values from the session which was set in the ajax response
		$oldValues = $_SESSION[ 'studentOldValues' ];

		//Get the new values
		$newValues = array(
			"student_number" => $txtStudentNumber,
			"student_fname"  => $txtFirstName,
			"student_lname"  => $txtLastName,
			"student_email"  => $txtStudentEmail,
			"student_phone"  => $txtStudentPhone,
			"letter_grade"   => $txtLetterGrade,
		);


		$studentValidation = new StudentValidator( $oldValues, $newValues );

		//run the validation
		$studentValidated = $studentValidation->run();

		//if the $userValidator didn't pass
		if( $studentValidated !== true ) //it has an error message in it
			$errorMessage = $studentValidated;
		//get it and set it to the $errorMessage

		//if the user validation passed
		if( $studentValidated === true ) {

			//check to see if the student already exists with this student number
			$student = Student::find_by_student_number( $txtStudentNumber );

			//if a student exists with this student number and it is the same as the old value
			if( $student && $txtStudentNumber == $oldValues[ 'student_number' ] ) {

				//then assign the values to update
				$student->student_fname = $txtFirstName;
				$student->student_lname = $txtLastName;
				$student->student_email = $txtStudentEmail;
				$student->student_phone = $txtStudentPhone;

				//update the student in the database
				$student->save();

			} elseif( !$student ) { //if a student doesn't exist with this student number

				//disable the foreign key checks so that we can update the student number in all tables used
				$foreignKeyChecksDisabled = MySQLDB::disable_foreign_key_checks();

				if( $foreignKeyChecksDisabled ) {
					//get the student by their old student number
					$student = Student::find_by_student_number( $oldValues[ 'student_number' ] );

					//then assign the values to update
					$student->student_number = $txtStudentNumber;
					$student->student_fname  = $txtFirstName;
					$student->student_lname  = $txtLastName;
					$student->student_email  = $txtStudentEmail;
					$student->student_phone  = $txtStudentPhone;

					//update the student in the database
					$student->save();

					//get all of the courses the student is registered to
					$studentsCourses = StudentCourse::find_by_student_number( $oldValues[ 'student_number' ] );

					//change their student number for each course they are registered in
					foreach( $studentsCourses as $studentCourse ) {

						$studentCourse->students_student_number = $txtStudentNumber;

						$studentCourse->save();

					}

					//get all of the grades that this student has
					$studentGrades = StudentGrade::find_by_student_number( $oldValues[ 'student_number' ] );

					//change their student number for each grade they have been given
					foreach( $studentGrades as $studentGrade ) {

						$studentGrade->students_student_number = $txtStudentNumber;

						$studentGrade->save();

					}

					//enable foreign key checks again
					$foreignKeyChecksEnabled = MySQLDB::enable_foreign_key_checks();

				}
				//END if($foreignKeyChecksDisabled)

			} else { //this student number is already being used by another student and is not available

				$errorMessage = "Student number " . $txtStudentNumber . " is already in use by " . $student->full_name() . ".<br />";
				$errorMessage .= "Please choose a different student number.";

				$errors = true;
			}


			//check to see if the student already has a grade in the course
			$studentGrade = StudentGrade::find_by_student_number_and_course_ID( $txtStudentNumber, $_GET[ 'course_ID' ] );

			//if the student has a grade
			if( $studentGrade && !$errors ) {

				//then assign the values
				$studentGrade->letter_grade            = $txtLetterGrade;
				$studentGrade->courses_ID              = $_GET[ 'course_ID' ];
				$studentGrade->students_ID             = $student->ID;
				$studentGrade->students_student_number = $student->student_number;

				//update the students grade for this course
				$studentGrade->save();

			} elseif( !$errors ) {

				//create a new StudentGrade
				$studentGrade = new StudentGrade();

				//then assign the values
				$studentGrade->letter_grade            = $txtLetterGrade;
				$studentGrade->courses_ID              = $_GET[ 'course_ID' ];
				$studentGrade->students_ID             = $student->ID;
				$studentGrade->students_student_number = $student->student_number;

				//add the students grade for this course
				$studentGrade->save();

			}
		}
		//End if( $studentValidated && !empty($studentValidated)

	} elseif( isset( $_POST[ 'txtRemoveStudent' ] ) ) { //delete the student

		//get the students course that you want to remove them from
		$studentsCourse = StudentCourse::find_by_student_number_and_course_ID( $txtStudentNumber, $_GET[ 'course_ID' ] );

		//remove them from the course
		if( $studentsCourse )
			$studentsCourse->delete();

		//get their grade for this course
		$studentGrade = StudentGrade::find_by_student_number_and_course_ID( $txtStudentNumber, $_GET[ 'course_ID' ] );

		//delete their grade
		if( $studentGrade )
			$studentGrade->delete();

		//unset the POST values so that the form doesn't get filled with the values of the deleted user
		unset( $_POST );


	} elseif( isset( $_POST[ 'txtDeleteStudent' ] ) ) {

		//get all of the courses the student is registered to
		$studentsCourses = StudentCourse::find_by_student_number( $txtStudentNumber );

		//delete the student from all of them
		foreach( $studentsCourses as $studentCourse ) {

			$studentCourse->delete();

		}

		//get all of the grades that this student has
		$studentGrades = StudentGrade::find_by_student_number( $txtStudentNumber );

		//delete all of them
		foreach( $studentGrades as $studentGrade ) {

			$studentGrade->delete();

		}

		$student = Student::find_by_student_number( $txtStudentNumber );

		//delete the student
		if( $student )
			$student->delete();

		//unset the POST values so that the form doesn't get filled with the values of the deleted user
		unset( $_POST );

	}

} //END if($_REQUEST[''] == 'POST')
else {

	//disable the form fields so that the user starts with the student number
	//enable the fields in the form
	$disabled = "disabled";

}

//get the students already registered to this course
$students = Student::find_by_course_ID( $_GET[ 'course_ID' ] );

?>

	<script>
		//run after the page has finished loading
		document.addEventListener('DOMContentLoaded', function () {

			//get the selected student in the list and click it so that it loads the course into the form fields
			document.getElementById('selected-student').click();

		}, false);
	</script>

<div class="PopupPage-FormHolder manage-students">
	<div class="PopupPage-leftformcontainer">

		<div class="error-message"> <?php ( !empty( $errorMessage ) ) ? print( $errorMessage ) : print( '' ); ?> </div>

		<h5 class="lstheader">Current Students Registered In Course</h5>
		<select class="lstCurrentStudentsRegisteredInCourse" size="10" name="lstCurrentStudentsRegisteredInCourse">
			<?php
			$var = "showSelectedStudent('add_student')";
			echo '<option name="add_student" onclick="' . $var . '" >Add New Student</option>';


			foreach( $students as $student ) {

				if( ( isset( $_POST[ 'txtStudentNumber' ] ) && $_POST[ 'txtStudentNumber' ] == $student->student_number ) ) {

					$selected = "selected='selected' id='selected-student'";

				} else {

					$selected = "";
				}

				$var = "showSelectedStudent('" . $student->student_number . "')";

				echo '<option value="' . $student->student_number . '"  onclick="' . $var . '" ' . $selected . ' >' . $student->student_number . ' - ' . $student->full_name() . '</option>';

			}


			?>
		</select>
	</div>
	<div class="PopupPage-rightformcontainer">

		<form action="#" method="post">
			<!-- add more details in form for students-->
			<table class="registeredstudentsform" id="studentdetailtable">
				<tr>
					<td>Student Number:</td>
					<td>
						<div id="ajaxsymbol" style="display: none;"><img src="images/ajax-loader.gif" width="16"
						                                                 height="16" alt="ajax-loading-symbol"/></div>
						<input type="text" name="txtStudentNumber" id="txtStudentNumber"
						       value="<?php echo isset( $_POST[ 'txtStudentNumber' ] ) ? $_POST[ 'txtStudentNumber' ] : ''; ?>"
						       onkeyup='getResultsFromManageStudentsSearch(this.value); showAJAXLoadingIndicator();'
						       placeholder='Student Lookup' required="required"/>

						<div id="manage-student-search-results"></div>
					</td>
				</tr>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="txtFirstName"
					           value="<?php echo isset( $_POST[ 'txtFirstName' ] ) ? $_POST[ 'txtFirstName' ] : ''; ?>" <?php echo $disabled; ?> />
					</td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="txtLastName"
					           value="<?php echo isset( $_POST[ 'txtLastName' ] ) ? $_POST[ 'txtLastName' ] : ''; ?>" <?php echo $disabled; ?> />
					</td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="email" name="txtStudentEmail"
					           value="<?php echo isset( $_POST[ 'txtStudentEmail' ] ) ? $_POST[ 'txtStudentEmail' ] : '' ?>"  <?php echo $disabled; ?> />
					</td>
				</tr>
				<tr>
					<td>Phone Number:</td>
					<td><input type="text" name="txtStudentPhone"
					           value="<?php echo isset( $_POST[ 'txtStudentPhone' ] ) ? $_POST[ 'txtStudentPhone' ] : ''; ?>"  <?php echo $disabled; ?>  />
					</td>
				</tr>
				<tr>
					<td>Letter Grade:</td>
					<td><input type='text' id="txtLetterGrade" name="txtLetterGrade"
					           value="<?php echo isset( $_POST[ 'txtLetterGrade' ] ) ? $_POST[ 'txtLetterGrade' ] : ''; ?>" <?php echo $disabled; ?>  />
					</td>
				</tr>

				<tr>
					<td><input type="submit" value="Register Student" name="txtRegisterStudent"/>
					</td>
				</tr>

			</table>
		</form>
	</div>

<?php require_once( dirname( __FILE__ ) . '/footer.php' ); ?>