<?php

require_once( dirname( dirname( __FILE__ ) ) . '/includes.php' );

//ajax response for manage-users.php

if( !empty( $_REQUEST["userID"] ) ) {

	$user = User::find_by_ID( $_REQUEST["userID"] );

	if( $_REQUEST[ "userID" ] == "create-new-user" ) { //send fields with empty values
		?>

		<tr>
			<td>Username:</td><td><input type="text" name="user_name" required="required" /></td>
		</tr>
		<tr>
			<td>First Name:</td><td><input type="text" name="user_fname" required="required" /></td>
		</tr>
		<tr>
			<td>Last Name:</td><td><input type="text" name="user_lname" required="required" /></td>
		</tr>
		<tr>
			<td>Email:</td><td><input type="email" name="user_email" /></td>
		</tr>
		<tr>
			<td>Password:</td><td><input type="password" name="first_pass" required="required" /></td>
		</tr>
		<tr>
			<td>Re-Enter Password:</td><td><input type="password" name="user_pass" required="required" /></td>
		</tr>
		<tr>
			<td>Role:</td>
			<td>
				<select name="user_role" required="required"/>
				<option selected="selected">Please select a role</option>
				<?php

				foreach(User::$roleNames as $key => $value){
					echo "<option value='$key'>$value</option>";
				}

				?>
				</select>

			</td>
		</tr>

		<tr>
			<td><input type="submit" name="create-new-user" value="Create User"/></td>
		</tr>

	<?php

	}elseif($user){//if the user was found

		//get the old values, old values should be empty since this is a new user
		$oldValuesToValidate = array(
			"user_login" => $user->user_login,
			"user_pass" => '',
			"user_fname" => $user->user_fname,
			"user_lname" => $user->user_lname,
			"user_email" => $user->user_email,
			"user_role" => $user->user_role
		);

		$_SESSION['userOldValues'] = $oldValuesToValidate;

		?>
		<input type="hidden" name="user-id" value="<?php echo $user->ID; ?>" />
		<tr>
			<td>Username:</td><td><input type="text" name="user_name" value="<?php echo $user->user_login; ?>" /></td>
		</tr>
		<tr>
			<td>First Name:</td><td><input type="text" name="user_fname" id="user_fname" value="<?php echo $user->user_fname; ?>" /></td>
		</tr>
		<tr>
			<td>Last Name:</td><td><input type="text" name="user_lname" id="user_lname" value="<?php echo $user->user_lname; ?>" /></td>
		</tr>
		<tr>
			<td>Email:</td><td><input type="text" name="user_email" value="<?php echo $user->user_email; ?>" /></td>
		</tr>
		<tr>
			<td>Password:</td><td><input type="password" name="first_pass" placeholder="Leave blank for no change"/></td>
		</tr>
		<tr>
			<td>Re-Enter Password:</td><td><input type="password" name="user_pass"  placeholder="Leave blank for no change" /></td>
		</tr>
		<tr>
			<td>Role:</td>
			<td>
				<select name="user_role" >
					<option selected="selected">Please select a role</option>
					<?php


					foreach(User::$roleNames as $key => $value){

						$selected = "";

						if($user->user_role == $key)
							$selected = "selected='selected'";

						echo "<option value='$key' $selected >$value</option>";
					}

					?>
				</select>
			</td>
		</tr>

		<tr>
			<td><input type="submit" name="update-user" value="Update User" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="delete-user" value="Remove User" onclick='return confirm("Are you sure you want to remove " + document.getElementById("user_fname").value + " " + document.getElementById("user_lname").value + "?"  )' /></td>
		</tr>
		<tr>
			<td><input type="button" name="create-new-user" value="Create A New User" onclick="showSelectedUser('create-new-user'); clearErrors();"/></td>
		</tr>


	<?php

	}

}//END if( !empty( $_REQUEST["userID"] ) )