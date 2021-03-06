<?php

require_once( dirname( __FILE__ ) . '/inc/includes.php' );

if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) { //if this is a post back
	if( isset( $_POST[ 'logout' ] ) ) //and logout is set
		$session->logout();
	//log the user out
}

//if the user isn't logged in
if( !$session->is_logged_in() ) {
	//send them back to the login page
	header( 'Location: index.php' );
	exit();

}
//unset($_SESSION['progCode']);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="shortcut icon" href="favicon.ico" type="image/png">
<title>Course Management Portal</title>
<link href="css/style.css" rel="stylesheet"/>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js'></script>
<script src="js/common.js"></script>
</head>

<body onresize="window.location.reload(false);">
<div class="wrapper">
  <ul id="flowchart-nav">
    <li>
      <form id="student-lookup">
        <input type="text" size="30" onkeyup="getResultsFromFlowChartSearch(this.value)" placeholder="Student Lookup">
        <div id="flowchart-search-results"></div>
      </form>
    </li>
    <?php  	 
		if( isset( $_SESSION[ 'user_role' ] ) && $_SESSION[ 'user_role' ] > 8 ) {//coordinator or assistant ?>
    <li><a href="#" class="flow-chart-btn" onclick="openWindow('manage-course.php?course_ID=0')">Manage
      Courses</a></li>
    <li><a href="#" class="flow-chart-btn" onClick="openWindow('edit-student.php?student_ID=<?php echo $_GET[ 'student_number' ]   ?>')">Manage Students</a></li>
    <?php if( isset( $_SESSION[ 'user_role' ] ) && $_SESSION[ 'user_role' ] > 9 ) {//coordinator?>
    <li><a href="#" class="flow-chart-btn" onclick="openWindow('manage-users.php')">Manage Users</a></li>
    <li><a href="#" class="flow-chart-btn" onclick="openWindow('reports.php')">Reports</a></li>
    <li><a href="#" class="flow-chart-btn" onclick="openWindow('uploadCSV.php')">Upload CSV</a></li>
    <?php }//END coordinator ?>
    <?php }//END coordinator or assistant ?>
    <?php if( isset( $_SESSION[ 'user_role' ] ) && $_SESSION[ 'user_role' ] > 10 ) {//superuser?>
    <li><a href="#" class="flow-chart-btn" onclick="openWindow('manage-programs.php')">Manage Programs</a></li>
    <?php }//END superuser ?>
    <li>
      <form action="#" method="post">
        <input type="submit" class="flow-chart-btn" name="logout" value="Logout">
      </form>
    </li>
  </ul>
  <?php
    $prog= Program::find_by_program_ID($_SESSION[ 'user_id' ]);
	$programName =$prog->program_name;
	$program_code=$prog->program_code;
	$program_id = $prog->ID;
	$program_year=$prog->program_year;
	
	echo "<h1 id='programName'>".$programName ."-". $program_year. "</h1>";
	?>
<<<<<<< HEAD
  
  <!--<h1>Internet Applications and Web Development - 3002X 2014-2015</h1>-->
  
  <?php
  
	$drpYearValue =isset($_POST['drpYear']) ? $_POST['drpYear']:$program_year;
	$drpProgValue=isset($_POST['drpProg']) ? $_POST['drpProg']: $program_code ;
	// $program_id=1;
	 
	if(isset($_POST['btnSelect']))
	{		 
=======
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
    <select name="drpProg" id="drpProg" onChange="drpProgChange">
      <option value="Select">Select a program </option>
	
	<?php
	   $progName= Program::find_distinct_name($_SESSION[ 'user_id' ]);
	   $progYear= Program::find_distinct_year($_SESSION[ 'user_id' ]);
           	 
		
	foreach($progName as $program)
	{
		echo "<option value=".$program->program_code.">".$program->program_name."</option>";
	}
	
     ?></select>
     
     
     <select name="drpYear">
      <option value="Select">Select a year </option>
	<?php
    
	foreach($progYear as $program)
	{
		echo "<option value=".$program->program_year.">".$program->program_year."</option>";
	}
	
     ?></select>
     <input type="submit" name="btnSelect" value="Submit" />
     </form>
        	 
	<?php if(isset($_GET[ 'student_number' ]))
		 {
			$students=Student::find_by_student_number($_GET['student_number']);
			?>
			<a href="#" class="" onclick="openWindow('edit-student.php?student_ID=<?php echo $_GET[ 'student_number' ] ?>')"><h3>    <?php echo $students->student_fname." ".$students->student_lname ?></h3></a>
	
	<?php
		} 
	$drpYearValue ='';
	 $drpProgValue='';
	// $program_id=1;
	 
	if(isset($_POST['btnSelect']))
	{
     if(isset($_POST['drpYear']) && isset($_POST['drpProg']))
	 {
		 	 
		 $drpYearValue = $_POST['drpYear'];
		 $drpProgValue = $_POST['drpProg'];
>>>>>>> origin/master
		$program_New = Program::find_by_program_code_and_year($drpProgValue, $drpYearValue);
		
	foreach($program_New as $program_New1)
	{
	 $program_id=$program_New1->ID;
	 $programName=$program_New1->program_name;
	 $programYear=$program_New1->program_year;
	 $programCode=$program_New1->program_code;
	}
	}
	?>
  <script>
							//run after the page has finished loading
						document.addEventListener('DOMContentLoaded', function () {
                           
								//display the selected program name
				displayProgramName('<?php echo $programName ?>','<?php echo $programYear ?>');
		}, false);
 </script>
  <div class="drpAlign">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
      <select name="drpProg" id="drpProg">
        <?php
	   $progName= Program::find_distinct_name($_SESSION[ 'user_id' ]);
	   $progYear= Program::find_distinct_year($_SESSION[ 'user_id' ]);
 	foreach($progName as $program)
	{
		?>
        <option value="<?php echo $program->program_code;?>"  <?php if($program->program_code==$drpProgValue) echo "selected='selected'";?>>
		<?php echo $program->program_name; ?></option>
        <?php
	}
	
     ?>
      </select>
      <select name="drpYear" id="drpYear">
        
        <?php
    
	foreach($progYear as $program)
	{
		?>
        <option value="<?php echo $program->program_year;?>"  <?php if( $program->program_year==$drpYearValue) echo "selected='selected'";?>>
		<?php echo $program->program_year; ?></option>
		<?php } ?>
      </select>
      <input type="submit" name="btnSelect" value="Submit" onClick="btnDrpClick" />
    </form>
  </div>
  <?php if(isset($_GET[ 'student_number' ]))
		 {
			$students=Student::find_by_student_number($_GET['student_number']);
			?>
			  <a href="#" class="" onclick="openWindow('edit-student.php?student_ID=<?php echo $_GET[ 'student_number' ] ?>')">
  			<h3> <?php echo $students->student_fname." ".$students->student_lname ?></h3></a>
  		<?php }  ?>
  <?php
	$numberOfLevels = Course::get_number_of_levels($program_id);

	//start with 0 courses displayed
	$coursesForCurrentLevelDisplayed = 0;

	//start with level 1
	$courseLevel = 1;

	for( $i = 0; $numberOfLevels > $i; $i++ ) {
 	 $courseLevel = $i + 1;
		//start with a new level
		$newLevel = true;

		//get all of the courses for the current level
		$courses = Course::find_by_course_level( $courseLevel, $program_id );

		foreach( $courses as $course ) {

			$studentHasGrade = false;
			$studentsGrade   = "";

			//if the student number is set
			if( isset( $_GET[ 'student_number' ] ) ) {

				//get the student and the students grade for this course
				$studentHasGrade = StudentGrade::find_by_student_number_and_course_ID( $_GET[ 'student_number' ], $course->ID );

				//if the student has a grade for this course
				if( $studentHasGrade )
					$studentsGrade = $studentHasGrade->letter_grade;
				//get the letter grade

			}

			//get a count of how many courses are in this level
			$coursesInThisLevel = Course::count_by_course_level( $course->course_level, $program_id );

			//get the current courses prerequisites
			$prerequisites = CoursePrerequisite::find_by_course_ID( $course->ID, $program_id );

			//if this is a new level
			if( $newLevel ) { //start a new level-container
				$position = 0;
				?>
  <div class="level-container <?php echo 'course-level-' . $courseLevel; ?>">
    <div class="course-level">Level <?php echo $courseLevel; ?> </div>
    <?php

			}
			//END if( $newLevel )

			//$newLevel is false until we get past the number of courses in the level
			$newLevel = false;


			?>
    <a href="#" id="<?php echo $course->course_number . '-' . ++$position; ?>"
                 onclick="openWindow('manage-course.php?course_ID=<?php echo $course->ID;?>&program_ID=<?php echo $program_id; ?>')">
    <div class="box <?php isset( $_GET[ 'student_number' ] ) ? print( 'extended-box' ) : print( '' ); ?>"
				     id="<?php echo $course->course_number; ?>">
      <?php
	  
					foreach( $prerequisites as $prerequisite ) {

						//if the course level is an even number
						if( $courseLevel % 2 ) {
							$lineColor         = '#000';
							$courseLevelOffset = 75;
							$lineSize          = 2;
						} else { //if the course level is an odd number, give the line a different shade and offset for better visibility
							$courseLevelOffset = 65;
							$lineColor         = '#8A8A8A';
							$lineSize          = 2;
						}
						?>
        <script>
	  		//run after the page has finished loading
			document.addEventListener('DOMContentLoaded', function () {

			//find the prerequisites
			findPrerequisites('<?php echo $prerequisite->course_number; ?>', '<?php echo $course->course_number; ?>', '<?php echo $lineColor; ?>', '                               <?php echo $lineSize; ?>', '<?php echo $courseLevelOffset; ?>');

							}, false);
		</script>
      <?php   }//END foreach( $prerequisites as $prerequisite )
					?>
      <p class="course-number"><?php echo $course->course_number; ?></p>
      <p class="course-name"><?php echo $course->course_name; ?></p>
      <p class="course-hours"><?php echo $course->course_hours_lab . '/' . $course->course_hours_lecture . '/' . $course->course_hours_study; ?></p>
      <p class="course-hybrid">
        <?php ( $course->course_hybrid == 1 ) ? print( "H" ) : ''; ?>
      </p>
      <?php if( isset( $_GET[ 'student_number' ] ) ) : ?>
      <p class="course-student-grade"> Grade: <?php echo $studentHasGrade ? $studentsGrade : 'No Grade'; ?></p>
      <script>
							//run after the page has finished loading
							document.addEventListener('DOMContentLoaded', function () {
                           
								//find the prerequisites
								addColor('<?php echo $course->course_number; ?>','<?php echo $studentsGrade ?>');

							}, false);
       </script>
      <?php endif; ?>
    </div>
    <!-- END .box #<?php echo $course->course_number; ?> --> 
    </a>
    <?php

			//increment the amount of courses displayed
			$coursesForCurrentLevelDisplayed++;

			//if we have displayed all of the courses in this level
			if( $coursesForCurrentLevelDisplayed == $coursesInThisLevel ) {

				$coursesForCurrentLevelDisplayed = 0; //set our courses displayed back to 0
				$newLevel                        = true; //start a new level

			}

			//if we are ready to start a new level
			if( $newLevel ) {
				//close the level-container before starting a new one above
				?>
  </div>
  <!-- END .level-container <?php echo $courseLevel++; ?>-->
  
  <?php
			}  //END if( $newLevel )

		}    //END foreach( $courses as $course )

	}       //END for($i; $numberOfLevels < $i; $i++)
	
	?>
</div>
<!-- END .wrapper -->

<footer>Currently logged on as: <?php echo isset( $_SESSION[ 'user_full_name' ] ) ? $_SESSION[ 'user_full_name' ] : ''; ?></footer>
</body>
</html>