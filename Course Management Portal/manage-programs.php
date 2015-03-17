<?php

	require_once( dirname( __FILE__ ) . '/header.php' );
	//check for user role
	//if this isn't a coordinator
	if( isset( $_SESSION[ 'user_role' ] ) && $_SESSION[ 'user_role' ] < 10 ) {
		header( 'Location: flow-chart.php' ); //send them back to the flow chart
		exit();
	}

	$errorMessage = "";

	extract($_POST);
	if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
		$programID        	= $_POST[ 'program_ID' ];
		$programCode     	= $_POST[ 'program_code' ];
		$programName 		= $_POST[ 'program_name' ];
		$programVersion 	= $_POST[ 'program_version' ];
		$programFlowchart	= $_POST[ 'program_flowchart' ];
		$programYear      	= $_POST[ 'program_year' ];

		$id = $_POST['selected-program']; 

		if ($id > 0)
		{
			$program = Program::find_by_ID($id);
			$programID        	= $program->ID; 
			$programCode     	= $program->program_code;
			$programName      	= $program->program_name;
			$programVersion 	= $program->program_version;
			$programFlowchart  = $program->program_flowchart;
			$programYear     	= $program->program_year;
		}

		if( isset( $_POST[ 'create-program' ] ) ) {
			//create the program
			$program = new Program();

			//assign the values
			$program->program_code = $programCode;
			$program->program_name = $programName;
			$program->program_version = $programVersion;
			$program->program_flowchart = $programFlowchart;
			$program->program_year  = $programYear;

			//create the program in the db
			$program->save();

			//unset the post values so that the new program doesn't show up in the form
			unset($_POST);

			$programID        	= '';
			$programCode     	= '';
			$programName 		= '';
			$programVersion 	= '';
			$programFlowchart	= '';
			$programYear      	= '';
			echo "Program successfully created.";

		} elseif( isset( $_POST[ 'update-program' ] ) ) {
			//check to see if the program exists
			$program = Program::find_by_program_ID( $programID );

			//if the program exists
			if( $program ) {

				//assign the values
				$program->program_id = $programID;

				$program->program_code = $programCode;
				$program->program_name = $programName;
				$program->program_version = $programVersion;
				$program->program_flowchart = $programFlowchart;
				$program->program_year  = $programYear;

				//save the program in the db
				$program->save();

				//unset the post values so that the new program doesn't show up in the form
				unset($_POST);

				$programID        	= '';
				$programCode     	= '';
				$programName 		= '';
				$programVersion 	= '';
				$programFlowchart	= '';
				$programYear      	= '';
				echo "Program successfully updated.";
			}
		} elseif( isset($_POST[ 'delete-program' ]) ) {
			//get the program courses
			$programCrs = ProgramCourses::find_by_programCourses_ID( $programID );
			//if the program courses was found
			if( $programCrs ) 
			{
				echo "Cannot Proceed! Please delete the list of courses for selected program first.";
			}else
			{
				//get the program
				$program = Program::find_by_program_ID( $programID );
				if( $program ) //if the program was found
				$program->delete();//delete the program

				//unset the post values so that the new program doesn't show up in the form
				unset($_POST);

				$programID        	= '';
				$programCode     	= '';
				$programName 		= '';
				$programVersion 	= '';
				$programFlowchart	= '';
				$programYear      	= '';
				echo "Program successfully deleted.";
			}


		}elseif( isset( $_POST['save_programCourses' ] ) ) {		
			//get the program courses
			$programCrs = ProgramCourses::find_by_programCourses_ID( $programID );
			if( $programCrs ) //if the program courses was found
			$programCrs->deleteAll("PROGRAMS", $programID );//delete the program courses

			if(is_array($programCourses)){
				while (list ($key, $val) = each ($programCourses)) {
					if ($val > 0)
					{
						$prgCourses = new ProgramCourses();

						//set the values for the programs_has_courses to be added
						$prgCourses->courses_id = $val;
						$prgCourses->programs_id = $programID;
						$prgCourses->save(); //add it to the db*/
						$prgCourses = "";
					}
				}
				echo "Courses successfully assigned to program.";
			}
		}
	}
?>

<style type="text/css">
	select {
		width: 400px;
		float: left;
		margin: 20px;
	}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<div class="PopupPage-FormHolder manage-programs">
<form action="#" method="post">
	<br/>
	<table id="current-program-form" width="926" border="0">
		<tr>
		    <td width="322" align="center"><strong>List of Current Programs</strong></td>
		    <td width="32">&nbsp;</td>
		    <td colspan="2"><strong>Manage/ View Current Program</strong></td>
	  	</tr>

	  	<tr>
		    <td rowspan="10">		
				<select class="lstCurrentPrograms" size="15" name="selected-program" id="selected-program" onchange="this.form.submit()";>
					<?php
						//get all of the users
						$programs = Program::find_all();

						foreach( $programs as $program ) {
							echo "<option value='" . $program->ID . "'  clearErrors();' >" . $program->program_name . " " . $program->program_year . "</option>";
						}
					?>
				</select>
			</td>

		    <td rowspan="10">&nbsp;</td>
		    <td width="202">&nbsp;</td>
		    <td width="273">&nbsp;</td>
	  	</tr>

	  	<tr>
		    <td>Code:</td>
			<td><input type="text" name="program_code" id="program_code" value="<?php echo $programCode; ?>"  required="required"/>
		    <input type="hidden" name="program_ID" id="program_ID" value="<?php echo $programID; ?>"/></td>
	  	</tr>

	  	<tr>
		    <td>Name:</td>
		    <td><input type="text" name="program_name" id="program_name" value="<?php echo $programName; ?>"  required="required"/></td>
	  	</tr>

	  	<tr>
		    <td>Version:</td>
		    <td><input type="text" name="program_version" id="program_version" value="<?php echo $programVersion; ?>"  required="required"/></td>
	  	</tr>

	  	<tr>
		    <td>Flowchart:</td>
		    <td><input type="text" name="program_flowchart" id="program_flowchart" value="<?php echo $programFlowchart; ?>"  required="required"/></td>
	  	</tr>

	  	<tr>
		    <td>Year:</td>
		    <td><input type="text" name="program_year" id="program_year" value="<?php echo $programYear; ?>"  required="required"/></td>
	  	</tr>
	  	<tr>
	  	  <td height="21" colspan="2"><input type="submit" id="create-program" name="create-program" value="Create Program" />
  	      <?php
					if ($programID > 0){
				?>
  	      <input type="submit" id="update-program" name="update-program" value="Update Program" />
  	      <input type="submit" id="delete-program" name="delete-program" value="Delete Program" />
  	      <?php } ?></td>
  	  </tr>
	  	<tr>
		    <td height="71">&nbsp;</td>
		    <td>&nbsp;</td>
	  	</tr>
	</table>	

  <table width="991" height="439" border="0">
	  	<tr>
			  <td height="27" align="center"><strong>List of available courses </strong></td>
			  <td height="27">&nbsp;</td>
			  <td height="27" align="center"><strong>List of courses for selected program</strong></td>
    </tr>
		
		<tr>
				<td width="440" height="233">
					<select multiple size="20" id="courses" name="courses ">
						<?php
							//Get none selected courses for a specific program
							$courses = Course::find_course_program($programID);
							foreach( $courses as $course ) {							
								echo "<option value='".$course->ID."'>".$course->course_number . " - " . $course->course_name . " </option>";
							}
						?>
					</select>
				</td>
		    	<td width="100">
					<div class="controls"> 
						<a href="javascript:moveSelectedPrograms('courses', 'programCourses','programCourses')">&gt;</a> 
						<a href="javascript:moveSelectedPrograms('programCourses', 'courses','programCourses')">&lt;</a> 
					</div>
		    	</td>

		    	<td width="440">
					<select multiple size="20" id="programCourses" name="programCourses[]">
						<?php
							if ($programID > 0){
								//Get selected courses for a specific program
								$courses = Course::find_selected_course_program($programID);
								foreach( $courses as $course ) {							
									echo "<option value='".$course->ID."'>".$course->course_number . " - " . $course->course_name . " </option>";
								}
							}
						?>
					</select>
		    	</td>
		</tr>

		<tr>
				<?php if ($programID > 0){?>
				<td height="36"><input type="submit" name="save_programCourses" value="Save"/></td>
				<?php } ?>
				<td></td>
				<td></td>
		</tr>
  </table>
	
</form>

<?php require_once( dirname( __FILE__ ) . '/footer.php' ); ?>