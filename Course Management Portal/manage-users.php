<?php

require_once( dirname( __FILE__ ) . '/header.php' );

//check for user role
//if this isn't a coordinator
if( isset( $_SESSION[ 'user_role' ] ) && $_SESSION[ 'user_role' ] < 10 ) {
	header( 'Location: flow-chart.php' ); //send them back to the flow chart
	exit();
}


$errorMessage = "";


if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

	$userID        = isset( $_POST[ 'user-id' ] ) ? $_POST[ 'user-id' ] : false;
	$userLogin     = $_POST[ 'user_name' ];
	$userPass      = ( !empty( $_POST[ 'user_pass' ] ) ) ? $_POST[ 'user_pass' ] : '';
	$userFirstName = $_POST[ 'user_fname' ];
	$userLastName  = $_POST[ 'user_lname' ];
	$userEmail     = $_POST[ 'user_email' ];
	$userRole      = $_POST[ 'user_role' ];

	if( isset( $_POST[ 'create-user' ] ) ) {

		//get the old values, old values should be empty since this is a new user
		$oldValuesToValidate = array(
			"user_login" => '',
			"user_pass"  => '',
			"user_fname" => '',
			"user_lname" => '',
			"user_email" => '',
			"user_role"  => ''
		);

		//get the new values
		$newValuesToValidate = array(
			"user_login" => $userLogin,
			"user_pass"  => $userPass,
			"user_fname" => $userFirstName,
			"user_lname" => $userLastName,
			"user_email" => $userEmail,
			"user_role"  => $userRole
		);

		//send the values to the user validator
		$userValidation = new UserValidator( $oldValuesToValidate, $newValuesToValidate );

		//run the validation
		$userValidated = $userValidation->run();

		//if the $userValidator didn't pass
		if( $userValidated !== true ) //it has an error message in it
			$errorMessage = $userValidated;
		//get it and set it to the $errorMessage

		//if the user validation passed
		if( $userValidated === true ) {

			//check to see if a user already exists with this login
			$user = User::find_by_user_login( $userLogin );

			//if the user login doesn't already exist
			if( !$user && !empty( $userLogin ) ) {

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

			}	//END if( !$user && !empty( $userLogin ) )
			else{

				$errorMessage = "Sorry, that login name has already been taken.";

			}


		}
		//END if( $userValidated )

	} elseif( isset( $_POST[ 'update-user' ] ) ) {

		//get the old values from the session which was set in the ajax respons
		$oldValuesToValidate = $_SESSION[ 'userOldValues' ];

		//get the new values
		$newValuesToValidate = array(
			"user_login" => $userLogin,
			"user_pass"  => $userPass,
			"user_fname" => $userFirstName,
			"user_lname" => $userLastName,
			"user_email" => $userEmail,
			"user_role"  => $userRole
		);

		//send the values to the user validator
		$userValidation = new UserValidator( $oldValuesToValidate, $newValuesToValidate );

		//run the validation
		$userValidated = $userValidation->run();

		//if the $userValidator didn't pass
		if( $userValidated !== true ) //it has an error message in it
			$errorMessage = $userValidated;
		//get it and set it to the $errorMessage

		//if the user validation passed
		if( $userValidated === true ) {


			//check to see if the user exists
			$user = User::find_by_user_ID( $userID );

			//if the user exists
			if( $user ) {

				//assign the values
				$user->user_login = $userLogin;

				//only assign a password if a new password was entered
				if( !empty( $userPass ) )
					$user->user_pass = sha1( $userPass );

				$user->user_fname = $userFirstName;
				$user->user_lname = $userLastName;
				$user->user_email = $userEmail;
				$user->user_role  = $userRole;

				//create the user in the db
				$user->save();


			}
			//END if( $userValidated && !empty($userValidated) )

		}
		//END if( !empty($userValidated) )

	} elseif( isset($_POST[ 'delete-user' ]) ) {
		//get the user
		$user = User::find_by_ID( $userID );

		if( $user ) //if the user was found
			$user->delete();//delete the user

		//unset the post values so that the deleted user doesn't show up in the form
		unset($_POST);

	}

}

?>

<div class="PopupPage-FormHolder manage-users">


	<div class="PopupPage-leftformcontainer">

		<div class="error-message" id="error-message"><?php ( !empty( $errorMessage ) ) ? print( $errorMessage ) : print( '' ); ?></div>

		<h4 class="lstheader">Current Users</h4>

		<select class="lstCurrentUsers" size="10" name="selected-user">
			<?php
			//get all of the users
			$users = User::find_all();

			foreach( $users as $user ) {

				$roleName = User::get_role_name_by_user_role( $user->user_role );

				echo "<option value='" . $user->ID . "'  onclick='showSelectedUser(this.value); clearErrors();' >" . $user->user_fname . " " . $user->user_lname . " - " . $roleName . "</option>";

			}

			?>
		</select>
	</div>
	<div class="PopupPage-rightformcontainer">

		<h4 class="textbookheader">
			View/Manage Current Users
		</h4>

		<form action="#" method="post">
			<table id="current-user-form">
				<tr>
					<td>Username:</td>
					<td><input type="text" name="user_name" required="required" value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : '';  ?>"/></td>
				</tr>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="user_fname" value="<?php echo isset($_POST['user_fname']) ? $_POST['user_fname'] : '';  ?>" required="required"/></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="user_lname" value="<?php echo isset($_POST['user_lname']) ? $_POST['user_lname'] : '';  ?>" required="required" /></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="email" name="user_email" value="<?php echo isset($_POST['user_email']) ? $_POST['user_email'] : '';  ?>" /></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="first_pass" id="first-pass" onblur="passwordRegex(); return false;" required="required" /></td>
				</tr>
				<tr>
					<td>Re-Enter Password:</td>
					<td><input type="password" name="user_pass" id="second-pass" onkeyup="checkPasswordsMatch(); return false;" required="required" /></td>
				</tr>
				<tr>
					<td>Role:</td>
					<td>
						<select name="user_role" required="required" />
						<?php isset($_POST['user_role']) ? $selected ="" : $selected = 'selected="selected"'; ?>

						<option <?php echo $selected; ?> value="">Please select a role</option>
						<?php

						foreach( User::$roleNames as $key => $value ) {

							if( isset($_POST['user_role']) && $_POST['user_role'] == $key ){
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
					<td><input type="submit" name="create-user" value="Create User"/></td>
				</tr>

			</table>
		</form>
	</div>

<?php require_once( dirname( __FILE__ ) . '/footer.php' ); ?>