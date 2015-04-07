<?php require_once( dirname( __FILE__ ) . '/header.php' ); 

//check for user role
//if this isn't a superviser or a coordinator 
if( isset( $_SESSION[ 'user_role' ] ) && $_SESSION[ 'user_role' ] < 10 ) {
	header( 'Location: flow-chart.php' ); //send them back to the flow chart
	exit();
}

$errorMessage = "";

extract($_POST);
if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

	$txtStudentNumber  = isset( $_POST[ 'txtStudentNumber' ] ) ? $_POST[ 'txtStudentNumber' ] : false;
	$txtFirstName = $_POST[ 'txtFirstName' ];
	$txtLastName  = $_POST[ 'txtLastName' ];
	$txtStudentEmail = $_POST[ 'txtStudentEmail' ];
	$txtStudentPhone = $_POST[ 'txtStudentPhone' ];
	$txtLetterGrade = $_POST[ 'txtLetterGrade' ];
	$txtGraduateYear = $_POST[ 'txtGraduateYear' ];
		
	$courseId = $_POST['txtCourseId'];			

	
	if( isset( $_POST[ 'editStudent' ] ) ) {
			$error = 0;
			//check to see if the user exists
			$student = Student::find_by_student_number( $txtStudentNumber );
			//if the user exists
			if( $student ) {
				//assign the values
				$student->txtStudentNumber = $txtStudentNumber;

				if ($error == 0){
					$student->student_fname = $txtFirstName;
					$student->student_lname = $txtLastName;
					$student->student_email = $txtStudentEmail;
					$student->student_phone  = $txtStudentPhone;
					//$student->graduating_year  = $txtGraduateYear;

					//update the user in the db
					$successfulUpdate = $student->editStudent_courseGrade($txtStudentNumber, $txtFirstName, $txtLastName, $txtStudentPhone, $txtStudentEmail, $txtLetterGrade, $txtGraduateYear, $courseId);


//					if ($successfulUpdate)
//					{
//						echo "User successfully updated.";
//					}
//					else
//					{
//						echo "User NOT successfully updated.";
//					}
					
				}
			}

}elseif( isset( $_POST[ 'deleteStudent' ] ) ) {
	$student = Student::find_by_student_number( $txtStudentNumber );
	
	if( $student )
	{
		$student->deleteStudent($txtStudentNumber);
		$student->archive_date($txtStudentNumber);

		//unset the POST values so that the form doesn't get filled with the values of the deleted user
		unset( $Globals['student'] );

		
				$txtStudentNumber = '';
				$txtFirstName = '';
				$txtLastName = '';
				$txtStudentEmail = '';
				$txtStudentPhone = '';
				$txtLetterGrade = '';
				$txtGraduateYear = '';

				echo "Student successfully deleted.";
		
	}
/*	
		else {		
			//disable the form fields so that the user starts with the student number
			//enable the fields in the form
			$disabled = "disabled";
			}*/
}
}
$students = Student::find_by_course_ID( 0 );
$students1 = Student::find_by_student_number($_GET[ 'student_ID' ]);
//$studentGL = Student::get_student_courses_and_grades($_GET[ 'student_ID' ]);
//var_dump($studentGL);
?>


<style type="text/css">
/*	select {
		width: 400px;
		float: left;
		margin: 20px;
	}*/
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="../../Course Management Portal/js/common.js"></script>

<!--<body onresize="window.location.reload(false);">-->


<!----><div class="PopupPage-FormHolder manage-students">

<!--    <form id="student-lookup"> 
    <input type="text" size="30" onkeyup="getResultsFromFlowChartSearch(this.value)" placeholder="Student Lookup">
    <div id="flowchart-search-results"></div>
     </form>-->
    
<table>
    <tr>
    <td width="20">&nbsp;</td>
    <td>
    <form id="student-lookup"> 
    <input type="text" size="30" onkeyup="getResultsFromEditStudentSearch(this.value)" placeholder="Student Lookup">
    <div id="flowchart-search-results"></div>
     </form>
     </td>
    </tr>
    </table>    
   
<form action="#" method="post">
	<br/>
  <table id="current-student-form" width="857" border="0">
		<tr>
		  <td width="27">&nbsp;</td>
		    <td width="400"><strong>Course Lists and Grades</strong></td>
		    <td width="47">&nbsp;</td>
		    <td colspan="2"><strong>Student Details</strong></td>
	  	</tr>

	  	<tr>
	  	  <td rowspan="11">&nbsp;</td>
		    <td rowspan="11">
                        
<script type="text/javascript">
	function showCourseGrade() {
		var selectList = document.getElementById("txtCourseListGrade");
		var selectedValue = selectList.options[selectList.selectedIndex];
		document.getElementById("txtLetterGrade").text = selectedValue.value.toUpperCase();
		document.getElementById("txtLetterGrade").value = selectedValue.value.toUpperCase();
		document.getElementById("txtCourseId").value = selectedValue.label;
		document.getElementById("txtCourseId").text = selectedValue.label;	
	}
</script> 
          		
	<select size="15" name="txtCourseListGrade" id="txtCourseListGrade" style="width:400px;" onchange="showCourseGrade('<?php echo $studentGrad->letter_grade ?>');" >
		  <?php // $studentGrad->letter_grade, $courseListGrade->courses_ID ;
  
  $studentCoursesGrades = StudentCourse::find_by_student_number($_GET['student_ID']);
		//var_dump($studentCoursesGrades);
		foreach( $studentCoursesGrades as $courseListGrade ) {
  // echo $courseListGrade->courses_ID;
  $courseList=Course::find_by_course_list($courseListGrade->courses_ID);
  $studentGrad= StudentGrade::find_by_student_number_and_course_ID($_GET['student_ID'],$courseListGrade->courses_ID);
		echo "<option label='$courseListGrade->courses_ID' value='$studentGrad->letter_grade' >". $courseList->course_name ." : ".strtoupper($studentGrad->letter_grade)."</option>";  
		}
  ?>  
  </select>
                
			</td>

		    <td rowspan="11">&nbsp;</td>
		    <td colspan = "2">&nbsp;</td>
	  	</tr>

	  	<tr>
		     <td width="202">Student Number:</td>
					<td width="230">
						<div id="ajaxsymbol" style="display: none;"></div>
						<input type="text" name="txtStudentNumber" id="txtStudentNumber"
						       value="<?php echo isset( $_GET[ 'student_ID' ] ) ? $_GET[ 'student_ID' ] : ''; ?>"  />
					</td>
	</tr>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="txtFirstName"
					           value="<?php 							   
							   echo $students1->student_fname; ?>"/>
					</td>
				</tr>            
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="txtLastName"
					           value="<?php echo $students1->student_lname ; ?>" />
					</td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="email" name="txtStudentEmail"
					           value="<?php echo $students1->student_email ; ?>" />
					</td>
				</tr>
				<tr>
					<td>Phone Number:</td>
					<td><input type="text" name="txtStudentPhone"
					           value="<?php echo $students1->student_phone ; ?>" />
					</td>
				</tr>
				<tr>
					<td>Letter Grade:</td>
					<td><input type='text' id="txtLetterGrade" name="txtLetterGrade"
					           value="<?php //echo $studentGrad->letter_grade ; ?>"/>
                      <input name="txtCourseId" id="txtCourseId" type="hidden" />
					</td>
				</tr>
                <tr>
					<td>Graduating Year:</td>
					<td><input type='text' id="txtGraduateYear" name="txtGraduateYear"
					           value="<?php echo $students1->graduating_year ; ?>" />
					</td>
			</tr>
             <tr>
					<td colspan="2">&nbsp;</td>
    </tr>
                    
	  	<tr>
		    <td height="40" colspan="2">
            		<input type="submit" id="editStudent" name="editStudent" value="Edit Student" />
                    <input type="submit" id="deleteStudent" name="deleteStudent" value="Delete Student" />
<!--                    <input type="submit" id="sendEmail" name="sendEmail" value="Send Email" >
-->                   <a href="mailto:<?php echo $students1->student_email ?>?Subject=Your%20Enrolment"><button type="button">Send <?php echo $student_fname ?> Email</button></a>			
		    </td>
	  	</tr>
	  	<tr>
		    <td height="21">&nbsp;</td>
		    <td>&nbsp;</td>
	  	</tr>
  </table>
    
</form>


   <?php require_once( dirname( __FILE__ ) . '/footer.php' ); ?>

