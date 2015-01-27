<?php

require_once( dirname( dirname( __FILE__ ) ) . '/includes.php' );

//ajax response for manage-courses.php

if( !empty( $_REQUEST[ "course_number" ] ) ) {

	$matchCourse = Course::find_by_ID( $_REQUEST[ "course_number" ] );

	if( $_REQUEST[ "course_number"] == "create-new-course" ){

		echo "<tr>";
		echo "<td>Course Number:</td>";
		echo "<td><input type='text' name='txtCourseNumber' value='' required='required' /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Course Name:</td>";
		echo "<td><input type='text' name='txtCourseName' value='' required='required' /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Level:</td>";
		echo "<td><input class='small-number-field' type='number' name='txtCourseLevel' value='' required='required' /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Lab Hours:</td><td><input class='small-number-field' type='number' name='txtCourseLabHours' value=''/>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Lecture Hours:</td><td><input class='small-number-field' type='number' name='txtCourseLectureHours' value=''/>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Study Hours:</td><td><input class='small-number-field' type='number' name='txtCourseStudyHours' value=''/></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Hybrid:</td>";
		echo "<td><input type='checkbox' name='txtCourseHybrid' />";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Course Description:</td>";
		echo "<td><textarea name='txtCourseDescription'></textarea></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td><input class='btnsubmit' type='submit' name='create-new-course' value='Create Course' /></td>";
		echo "</tr>";

	}elseif( $matchCourse ) {
		//get old values in to oldvalues array
		$oldValuesToValidate = array(
			"course_number" => empty( $matchCourse->course_number ) ? '' : $matchCourse->course_number,
			"course_name" => empty( $matchCourse->course_name ) ? '' : $matchCourse->course_name,
			"course_description" => empty( $matchCourse->course_description ) ? '' : $matchCourse->course_description,
			"course_level" => empty( $matchCourse->course_level ) ? '' : $matchCourse->course_level,
			"course_hours_lab" => empty( $matchCourse->course_hours_lab ) ? '0' : $matchCourse->course_hours_lab,
			"course_hours_lecture" => empty( $matchCourse->course_hours_lecture ) ? '0' : $matchCourse->course_hours_lecture,
			"course_hours_study" => empty( $matchCourse->course_hours_study ) ? '0' : $matchCourse->course_hours_study,
			"course_hybrid" => empty( $matchCourse->course_hybrid ) ? '0' : $matchCourse->course_hybrid
		);

		$_SESSION['courseOldValues'] = $oldValuesToValidate;

		echo "<tr>";
		echo "<td>Course Number:</td>";
		echo "<td><input type='text' name='txtCourseNumber' value='" . $matchCourse->course_number . "' required='required' /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Course Name:</td>";
		echo "<td><input type='text' name='txtCourseName' value='" . $matchCourse->course_name . "' required='required' /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Level:</td>";
		echo "<td><input class='small-number-field' type='number' name='txtCourseLevel' value='" . $matchCourse->course_level . "' required='required' /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Lab Hours:</td><td><input class='small-number-field' type='number' name='txtCourseLabHours' value='" . $matchCourse->course_hours_lab . "'/>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Lecture Hours:</td><td><input class='small-number-field' type='number' name='txtCourseLectureHours' value='" . $matchCourse->course_hours_lecture . "'/>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Study Hours:</td><td><input class='small-number-field' type='number' name='txtCourseStudyHours' value='" . $matchCourse->course_hours_study . "'/></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Hybrid:</td>";
		echo "<td><input type='checkbox' name='txtCourseHybrid' value='1' ";
		( $matchCourse->course_hybrid == 1 ) ? print("checked='checked'") : print('');
		echo " />";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Course Description:</td>";
		echo "<td><textarea name='txtCourseDescription'>" . $matchCourse->course_description. "</textarea></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td><input class='btnsubmit' type='button' name='create-new-course' value='Create New Course' onclick='showSelectedCourse(\"create-new-course\")' /></td>";
		echo "<td><input class='btnsubmit' type='submit' name='btnSaveChanges' value='Save Changes'  /></td>";
		echo "</tr>";
		echo "<tr><td><input style='width: 150px; height: 50px;' type='submit' name='delete-course' value='Delete Course' onclick='return confirm(\"Are you sure you want to delete " . $matchCourse->course_name . " ?\n\nThis cannot be undone!\")'  /></td></tr>";
		

	}


}