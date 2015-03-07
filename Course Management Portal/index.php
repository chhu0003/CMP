<?php

require_once( dirname( __FILE__ ) . '/inc/includes.php' );

$session = new Session();

if( $session->is_logged_in() ) {
	header( 'Location: flow-chart.php' );
	exit();
}

if( $_SERVER[ 'REQUEST_METHOD' ] == "POST" ) {

	$userIsAuthenticated = User::authenticate( $_POST[ 'username' ], $_POST[ 'password' ] );

	//if the user was found
	if( $userIsAuthenticated ) {

		//log them in
		$session = new Session();
		$session->login( $userIsAuthenticated );

		//send the user to the flow-chart
		header( 'Location: flow-chart.php' );
		exit();


	} else { //display errors
		$loginError = "Invalid username or password!";
	}
}
?>

<html>
<head>
	<link rel="stylesheet" href="css/style.css"/>
	<link rel="shortcut icon" href="favicon.ico" type="image/png">
    <script src="dropzone.min.js"></script>>
</head>
<body>
<div class="LoginPage-MainContainer">
	<div class="LoginPage-LogoHeader"></div>
	<div class="LoginPage-LoginFormContainer">
		<div class="loginPage-LoginForm">
			<?php if( isset( $loginError ) ) { ?>
				<div class="error-message"><?php echo $loginError; ?></div>
			<?php } ?>
			<form class="LoginPage-Form" action="#" method="post">
				<label for="username">Username:</label> <input type="text" name="username"/><br/>
				<label for="password">Password:</label><input type="password" name="password"/><br/><br/>
				<input class="Round-Button" type="submit" name="btnlogin" value="Login"/>&nbsp;&nbsp;&nbsp;
				<input class="Round-Button" type="reset" name="btnclear" value="Clear"/>
			</form>
		</div>
	</div>
	<div class="LoginPage-FooterContainer">

	</div>
</div>
</body>
</html>