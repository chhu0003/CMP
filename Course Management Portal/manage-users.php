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
		$userID        = $_POST[ 'user_ID' ];
		$userLogin     = $_POST[ 'user_login' ];
		$firstPass     = $_POST[ 'first_pass' ];
		$userPass      = ( !empty( $_POST[ 'user_pass' ] ) ) ? $_POST[ 'user_pass' ] : '';
		$userFirstName = $_POST[ 'user_fname' ];
		$userLastName  = $_POST[ 'user_lname' ];
		$userEmail     = $_POST[ 'user_email' ];
		$userRole      = $_POST[ 'user_role' ];

		$id = $_POST['selected-user']; 
		if ($id > 0)
		{
			$user = User::find_by_ID($id);
			$userID        = $user->ID; 
			$userLogin     = $user->user_login;
			$userPass      = $user->user_pass;
			$userFirstName = $user->user_fname;
			$userLastName  = $user->user_lname;
			$userEmail     = $user->user_email;
			$userRole      = $user->user_role;
			$selectUser    = "True";
		}

		if( isset( $_POST[ 'create-user' ] ) ) {
			//check to see if a user already exists with this login
			$user = User::find_by_user_login( $userLogin );
			//if the user login doesn't already exist
			if( !$user && !empty( $userLogin ) ) {
				if ($firstPass == $userPass ){
					//create the user				
					$user = new User();

					//assign the values
					$user->user_login = $userLogin;
					$user->user_pass  = sha1( $userPass );
					$user->user_fname = $userFirstName;
					$user->user_lname = $userLastName;
					$user->user_email = $userEmail;
					$user->user_role  = $userRole;				

					//create the user in the db
					$user->save();

					//unset the post values so that the new user doesn't show up in the form
					unset($_POST);

					$userID        = ''; 
					$userLogin     = '';
					$userPass      = '';
					$userFirstName = '';
					$userLastName  = '';
					$userEmail     = '';
					$userRole      = '';
					echo "User successfully created.";
				}else{
					echo "Sorry, password mismatch. Please re-enter.";
				}

			}else{
				echo "Sorry, that login name has already been taken.";
			}
		} elseif( isset( $_POST[ 'update-user' ] ) ) {
			$error = 0;
			//check to see if the user exists
			$user = User::find_by_user_ID( $userID );

			//if the user exists
			if( $user ) {
				//assign the values
				$user->user_login = $userLogin;

				//only assign a password if a new password was entered
				if( !empty( $userPass ) )
				{
					if ($userPass != $firstPass){
						echo "Sorry, password mismatch. Please re-enter.";
						$error = 1;						
					}else{
						$user->user_pass = sha1( $userPass );
						
					}
				}
				
				if ($error == 0){
					$user->user_fname = $userFirstName;
					$user->user_lname = $userLastName;
					$user->user_email = $userEmail;
					$user->user_role  = $userRole;

					//update the user in the db
					$user->save();

					//unset the post values so that the new user doesn't show up in the form
					unset($_POST);

					$userID        = ''; 
					$userLogin     = '';
					$userPass      = '';
					$userFirstName = '';
					$userLastName  = '';
					$userEmail     = '';
					$userRole      = '';
					echo "User successfully updated.";
				}
			}
		} elseif( isset($_POST[ 'delete-user' ]) ) {
			//get the user
			$user = User::find_by_ID( $userID );

			if( $user ) //if the user was found
				$user->delete();//delete the user

				//unset the post values so that the new user doesn't show up in the form
				unset($_POST);

				$userID        = ''; 
				$userLogin     = '';
				$userPass      = '';
				$userFirstName = '';
				$userLastName  = '';
				$userEmail     = '';
				$userRole      = '';
				echo "User successfully deleted.";
		}elseif( isset( $_POST['save_userPrograms' ] ) ) {
			//get the user programs
			$userPrg = UserProgram::find_by_userPrograms_ID( $userID );
			if( $userPrg ) //if the user programs were found
			$userPrg->deleteAll("USERS", $userID );//delete the user programs

			if(is_array($userPrograms)){
				while (list ($key, $val) = each ($userPrograms)) {
					if ($val > 0)
					{
						$userProgram = new UserProgram();

						//set the values for the users_has_programs to be added
						$userProgram->programs_ID = $val;
						$userProgram->users_id = $userID;
						$userProgram->save(); //add it to the db*/
						$userProgram = "";
					}
				}

				//unset the post values so that the new user doesn't show up in the form
				unset($_POST);

				$userID        = ''; 
				$userLogin     = '';
				$userPass      = '';
				$userFirstName = '';
				$userLastName  = '';
				$userEmail     = '';
				$userRole      = '';
				echo "User programs successfully updated.";
			}
		}
	}
?>

<style type="text/css">
/*	select {
		width: 400px;
		float: left;
		margin: 20px;
	}*/
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<div class="PopupPage-FormHolder manage-users">
<form action="#" method="post">
	<br/>
  <table id="current-user-form" width="857" border="0">
		<tr>
		  <td width="41">&nbsp;</td>
		    <td width="287"><strong>List of Current Users</strong></td>
		    <td width="32">&nbsp;</td>
		    <td colspan="2"><strong>Manage/ View Current User</strong></td>
	  	</tr>

	  	<tr>
	  	  <td rowspan="11">&nbsp;</td>
		    <td rowspan="11">		
				<select  size="15" name="selected-user" id="selected-user" style="width:400px;" onchange="this.form.submit()";>
					<?php
						//get all of the users
						$users = User::find_all();

						foreach( $users as $user ) {

							$roleName = User::get_role_name_by_user_role( $user->user_role );
							echo "<option value='" . $user->ID . "'clearErrors();' >" . $user->user_fname . " " . $user->user_lname . " - " . $roleName . "</option>";				
						}
					?>
				</select>
			</td>

		    <td rowspan="11">&nbsp;</td>
		    <td width="202">Username:</td>
		    <td width="273">
		    	<input type="text" name="user_login" id="user_login" value="<?php echo $userLogin; ?>"  required="required"/>
		    	<input type="hidden" name="user_ID" id="user_ID" value="<?php echo $userID; ?>"/>
		    </td>
	  	</tr>

	  	<tr>
		    <td>First Name:</td>
			<td><input type="text" name="user_fname" id="user_fname" value="<?php echo $userFirstName; ?>"  required="required"/></td>
	  	</tr>

	  	<tr>
		    <td>Last Name:</td>
		    <td><input type="text" name="user_lname" id="user_lname" value="<?php echo $userLastName; ?>"  required="required"/></td>
	  	</tr>

	  	<tr>
		    <td>Email:</td>
		    <td><input type="text" name="user_email" id="user_email" value="<?php echo $userEmail; ?>"  required="required"/></td>
	  	</tr>

	  	<?php if ($selectUser == "True"){ ?>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="first_pass" id="first_pass" placeholder="Leave blank for no change"/></td>
			</tr>
			<tr>
				<td>Re-Enter Password:</td>
				<td><input type="password" name="user_pass" id="user_pass" placeholder="Leave blank for no change" /></td>
			</tr>
		<?php }else{ ?>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="first_pass" id="first_pass" onblur="passwordRegex(); return false;" required="required" /></td>
			</tr>
			
			<tr>
				<td>Re-Enter Password:</td>
				<td><input type="password" name="user_pass" id="user_pass" onkeyup="checkPasswordsMatch(); return false;" required="required" /></td>
			</tr>
		<?} ?>


				<tr>
					<td>Role:</td>
					<td>
						<select name="user_role" required="required" />
						<?php isset($_POST['user_role']) ? $selected ="" : $selected = 'selected="selected"'; ?>

						<option <?php echo $selected; ?> value="">Please select a role</option>
						<?php

						foreach( User::$roleNames as $key => $value ) {

							if( $userRole == $key ){
								$selected = 'selected="selected"';
							}else{
								$selected ='';
							}

							echo "<option value='$key' $selected >$value</option>";
						}

						?>
						</select>

					</td>
				</tr>

	  	<tr>
		    <td height="53" colspan="2">
				<input type="submit" id="create-user" name="create-user" value="Create User" />
				<?php
					if ($userID > 0){
				?>
				<input type="submit" id="update-user" name="update-user" value="Update User" /> 
				<input type="submit" id="delete-user" name="delete-user" value="Delete User" />	
				<?php } ?>
		    </td>
	  	</tr>
	  	<tr>
		    <td height="49">&nbsp;</td>
		    <td>&nbsp;</td>
	  	</tr>
	</table>
  <table width="930" height="360" border="0">
	  		<tr>
	  		  <td align="center">&nbsp;</td>
			  <td height="27" align="center"><strong>List of available programs</strong></td>
			  <td>&nbsp;</td>
			  <td height="27">&nbsp;</td>
			  <td align="center">&nbsp;</td>
			  <td height="27" align="center"><strong>List of programs for selected user</strong></td>
	      </tr>
			<tr>
			  <td width="43">&nbsp;</td>
				<td width="400" height="288">
					<select multiple size="15" id="programs" name="programs" style="width:400px;">
						<?php
							//Get none selected programs for a specific user
							$programs = Program::find_user_program($userID);
							foreach( $programs as $program ) {							
								echo "<option value='".$program->ID."'>".$program->program_name . " - " . $program->program_year . " </option>";
							}
						?>				
					</select>
				</td>
				<td width="15">&nbsp;</td>
		    	<td width="70">
					<div class="controls"> 
						<a href="javascript:moveSelectedPrograms('programs', 'userPrograms','userPrograms')">&gt;</a> 
						<a href="javascript:moveSelectedPrograms('userPrograms', 'programs', 'userPrograms')">&lt;</a> 
					</div>
		    	</td>
		    	<td width="16">&nbsp;</td>

		    	<td width="455">
					<select multiple size="15" id="userPrograms" name="userPrograms[]" style="width:370px;">
						<?php
							if ($userID > 0){
								//Get selected programs for a specific user
								$programs = Program::find_selected_user_program($userID);
								foreach( $programs as $program ) {							
									echo "<option value='".$program->ID."'>".$program->program_name . " - " . $program->program_year . " </option>";
								}
							}
						?> 
					</select>
		    	</td>
			</tr>

			<tr>
			  <td >&nbsp;</td>	
				<?php if ($userID > 0){?>
				<td ><input type="submit" name="save_userPrograms" value="Save"/></td>
				<?php } ?>		
				
				<td></td>
	
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
</form>

<?php require_once( dirname( __FILE__ ) . '/footer.php' ); ?>