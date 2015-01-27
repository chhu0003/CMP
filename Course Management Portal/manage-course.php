<?php require_once( dirname( __FILE__ ) . '/header.php' ); ?>


<?php

//if this is a post back
if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {


	$courseID           = isset( $_POST[ 'lstAvailableCourses' ] ) ? $_POST[ 'lstAvailableCourses' ] : '';
	$courseNumber       = $_POST[ 'txtCourseNumber' ];
	$courseName         = $_POST[ 'txtCourseName' ];
	$courseDescription  = $_POST[ 'txtCourseDescription' ];
	$courseLevel        = $_POST[ 'txtCourseLevel' ];
	$courseLabHours     = $_POST[ 'txtCourseLabHours' ];
	$courseLectureHours = $_POST[ 'txtCourseLectureHours' ];
	$courseStudyHours   = $_POST[ 'txtCourseStudyHours' ];
	$courseHybrid       = isset( $_POST[ 'txtCourseHybrid' ] ) ? $_POST[ 'txtCourseHybrid' ] : "0";

	$coursePrerequisiteID = isset( $_POST[ 'lstPre-Requisites' ] ) ? $_POST[ 'lstPre-Requisites' ] : '';


	if( isset( $_POST[ 'btnSaveChanges' ] ) ) {


		//get the old values from the session which was set in the ajax respons
		$oldValuesToValidate = $_SESSION['courseOldValues'];

		// Set new values to validate
		$newValuesToValidate = array(
			"course_number" => $courseNumber,
			"course_name" => $courseName,
			"course_description" => $courseDescription,
			"course_level" => $courseLevel,
			"course_hours_lab" => $courseLabHours,
			"course_hours_lecture" => $courseLectureHours,
			"course_hours_study" => $courseStudyHours,
			"course_hybrid" => $courseHybrid,
		);

		$courseValidation = new CourseValidator($oldValuesToValidate,$newValuesToValidate);
		$courseValidated = $courseValidation->run();

		//if the $CourseValidator didn't pass
		if( $courseValidated !== true )//it has an error message in it
		{
			$errorMessage = $courseValidated;//get it and set it to the $errorMessage
		}

		if( $courseValidated === true ){

			$course = Course::find_by_ID( $courseID );

			//if the course exists
			if( $course ) {

				//update the course

				//set the values for the course
				$course->course_number        = $courseNumber;
				$course->course_name          = $courseName;
				$course->course_description   = $courseDescription;
				$course->course_level         = $courseLevel;
				$course->course_hours_lab     = $courseLabHours;
				$course->course_hours_lecture = $courseLectureHours;
				$course->course_hours_study   = $courseStudyHours;
				$course->course_hybrid        = $courseHybrid;
				$course->save(); //update the course in the db
			}

		}//END if( $courseValidated === true )

	}elseif( isset( $_POST['create-new-course'] ) ) {

			//get the old values, old values should be empty since this is a new course
			$oldValuesToValidate = array(
				"course_number" => '',
				"course_name" => '',
				"course_description" => '',
				"course_level" => '',
				"course_hours_lab" => '',
				"course_hours_lecture" => '',
				"course_hours_study" => '',
				"course_hybrid" => '0'
			);

			// Set new values to validate
			$newValuesToValidate = array(
				"course_number" => $courseNumber,
				"course_name" => $courseName,
				"course_description" => $courseDescription,
				"course_level" => $courseLevel,
				"course_hours_lab" => $courseLabHours,
				"course_hours_lecture" => $courseLectureHours,
				"course_hours_study" => $courseStudyHours,
				"course_hybrid" => $courseHybrid,
			);
		
			$courseValidation = new CourseValidator($oldValuesToValidate,$newValuesToValidate);
			$courseValidated = $courseValidation->run();
		
			//if the $CourseValidator didn't pass
			if( $courseValidated !== true )//it has an error message in it
			{
				$errorMessage = $courseValidated;//get it and set it to the $errorMessage
			}

			if( $courseValidated === true ){

				//create a new Course
				$course = new Course();

				//set the values for the new course
				$course->course_number        = $courseNumber;
				$course->course_name          = $courseName;
				$course->course_description   = $courseDescription;
				$course->course_level         = $courseLevel;
				$course->course_hours_lab     = $courseLabHours;
				$course->course_hours_lecture = $courseLectureHours;
				$course->course_hours_study   = $courseStudyHours;
				$course->course_hybrid        = $courseHybrid;
				$course->save(); //insert the course into the db
			}

		}elseif( isset( $_POST[ 'btnAdd' ] ) ) {
		//add a prerequisite to the current course

		//get the course that we want to add as a prerequisite
		$selectedCourse = Course::find_by_ID( $courseID );

		if($selectedCourse->course_level > $course->course_level){

			$errorMessage = "You cannot add a course that is in a higher level as a prerequisite to this course. ";

		}elseif( $selectedCourse->course_level == $course->course_level ){

			$errorMessage = "You cannot add a course to this course as a prerequisite if it is in the same level. ";

		}else{

			//check to see if the course being added is already a prerequisite of this course
			$coursePrerequisite = CoursePrerequisite::find_by_course_ID_and_course_prerequisite_course_number( $_GET[ 'course_ID' ], $selectedCourse->course_number );

			//if this course isn't already a prerequisite of this course
			if( !$coursePrerequisite ) {

				//create a new  prerequisite
				$coursePrerequisite = new CoursePrerequisite();

				//set the values for the prerequisite to be added
				$coursePrerequisite->course_prerequisites_course_number = $selectedCourse->course_number;
				$coursePrerequisite->courses_ID                         = $_GET[ 'course_ID' ];
				$coursePrerequisite->save(); //add it to the db

			}
		}

	} elseif( isset( $_POST[ 'btnRemove' ] ) ) {
		//check to see if this course is a prerequisite
		$coursePrerequisite = CoursePrerequisite::find_by_ID( $coursePrerequisiteID );

		//if this course is a prerequisite
		if( $coursePrerequisite ) {

			//remove it
			$coursePrerequisite->delete();

		}

	}elseif( isset($_POST['delete-course'])){

		//get the course
		$courseToDelete = Course::find_by_ID( $courseID );

		//check to see if the course has prerequisites
		$courseHasPrerequisites = CoursePrerequisite::find_by_course_ID( $courseID );

		if( $courseHasPrerequisites ){

			$errorMessage = "Please remove all perquisites from this course if you wish to delete this course.";

		}else{

			//if this course exists
			if( $courseToDelete ) {

				//remove it
				$courseToDelete->delete();

				//unset the post values so the form doesn't get filled with the deleted course
				unset($_POST);

			}
		}
	}

}//END of if( $_SERVER['REQUEST_METHOD'] == 'POST' )
		
?>

	<script>
		//run after the page has finished loading
		document.addEventListener('DOMContentLoaded', function () {

			//get the selected course in the list and click it so that it loads the course into the form fields
			document.getElementById('selected-course').click();

		}, false);
	</script>

<div class="PopupPage-FormHolder manage-course">
<div class="error-message"><?php ( !empty( $errorMessage ) ) ? print( $errorMessage ) : print( '' ); ?></div>
	<div class="PopupPage-BodyHeaderdiv">
		<div class="header1">
			Available Courses
		</div>
		<div class="header2">
			Pre-Requisites
		</div>
	</div>

	<form action="#" method="post">
		<table class="firstformtable" id="coursedetailtable">
			<tr>
				<td>Course Number:</td>
				<td><input type="text" name="txtCourseNumber" value="<?php echo isset($_POST[ 'txtCourseNumber' ]) ? $_POST[ 'txtCourseNumber' ] : ''; ?>" required="required"/></td>
			</tr>
			<tr>
				<td>Course Name:</td>
				<td><input type="text" name="txtCourseName" value="<?php echo isset($_POST[ 'txtCourseName' ]) ? $_POST[ 'txtCourseName' ] : ''; ?>" required="required"/></td>
			</tr>
			<tr>
				<td>Level:</td>
				<td><input class='small-number-field' type="number" name="txtCourseLevel" value="<?php echo isset($_POST[ 'txtCourseLevel' ]) ? $_POST[ 'txtCourseLevel' ] : ''; ?>" required="required"/></td>
			</tr>
			<tr>
				<td>Lab Hours:</td><td><input class="small-number-field" type="number" name="txtCourseLabHours" value="<?php echo isset($_POST['txtCourseLabHours']) ? $_POST[ 'txtCourseLabHours' ] : ''; ?>"/></td>
            </tr>
            <tr>    
                <td>Lecture Hours:</td><td><input class="small-number-field" type="number" name="txtCourseLectureHours" value="<?php echo isset($_POST['txtCourseLectureHours']) ? $_POST['txtCourseLectureHours'] : ''; ?>"/></td>
            </tr>
            <tr>    
                <td>Study Hours:</td><td> <input class="small-number-field" type="number" name="txtCourseStudyHours" value="<?php echo isset($_POST['txtCourseStudyHours']) ? $_POST['txtCourseStudyHours'] : ''; ?>"/></td>
			</tr>
			<tr>
				<td>Hybrid:</td>
				<td><input type="checkbox" name="txtCourseHybrid"
				           value="1" <?php ( isset($_POST[ 'txtCourseHybrid' ]) && $_POST[ 'txtCourseHybrid' ] == 1 ) ? print( 'checked' ) : print( '' ); ?> />
				</td>
			</tr>
			<tr>
				<td>Course Description:</td>
				<td><textarea name="txtCourseDescription"><?php echo isset($_POST[ 'txtCourseDescription' ]) ? $_POST[ 'txtCourseDescription' ] : ''; ?></textarea></td>
			</tr>
			<tr>
				<td><input class="btnsubmit" type="submit" name="create-new-course" value="Create New Course" onclick="showSelectedCourse('create-new-course')" /></td>
			</tr>

		</table>
		<select id="available-courses-list" class="lstAvailableCourses" size="10" name="lstAvailableCourses">
			<?php

			$courseAvailable = Course::find_all();

			$editedCourse = isset( $_POST['lstAvailableCourses'] ) ? $_POST['lstAvailableCourses'] : false;

			foreach( $courseAvailable as $availableCourse ) 
			{

				if( $editedCourse == $availableCourse->ID  ){

					$selected= "selected='selected' id='selected-course'";

				}else{

				    $selected = "";
				}

				echo "<option value='".$availableCourse->ID."' onclick='showSelectedCourse(this.value);'" . $selected . " >".$availableCourse->course_number . " - " . $availableCourse->course_name . " </option>";

			}

			?>
		</select>
		<input type="submit" name="btnAdd" value="Add >" class="add"/><br /><br />
		<input type="submit" name="btnRemove" value="< Remove" class="remove" />
		<select class="lstPre-requisites" size="10" name="lstPre-Requisites">
			<?php

			$prerequisites = CoursePrerequisite::find_by_course_ID( $_GET[ 'course_ID' ] );

			foreach( $prerequisites as $prerequisite ) {
				?>
				<option
					value="<?php echo $prerequisite->ID; ?>"><?php echo $prerequisite->course_number . ' - ' . $prerequisite->course_name; ?></option>

			<?php
			}

			?>
		</select>

	</form>

<?php require_once( dirname( __FILE__ ) . '/footer.php' ); ?>