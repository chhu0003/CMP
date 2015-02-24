<?php

require_once( dirname( __FILE__ ) . '/inc/includes.php' );

$session = new Session();

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="shortcut icon" href="favicon.ico" type="image/png">
	<title>Manage Superusers</title>

	<link href="css/style.css" rel="stylesheet"/>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js'></script>
	<script src="js/common.js"></script>

</head>
	<body>
		<form class="LoginPage-Form" action="#" method="post">
			<a href="#" class="superuser-btn" onclick="openWindow('manage-users.php')">Manage Users</a>
			<a href="#" class="superuser-btn" onclick="openWindow('manage-programs.php')">Manage Programs</a>
			<a href="#" class="superuser-btn" onclick="openWindow('manage-user-program.php')">Assign Programs to User</a>
			<a href="#" class="superuser-btn" onclick="openWindow('manage-user-program2.php')">Assign Programs to User - Working</a>
			<a href="#" class="superuser-btn" onclick="openWindow('manage-program-courses.php')">Assign Courses to Program</a>
		</form>
	</body>
</html>