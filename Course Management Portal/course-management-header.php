<?php

//course management header for popup window

?>

<html>
<head>

	<title>Currently Managing <?php echo $course->course_name . ' - Level ' . $course->course_level; ?></title>
	<link rel="stylesheet" href="css/style.css"/>
	<script src="js/common.js"></script>

	<link rel="shortcut icon" href="favicon.ico" type="image/png">


</head>
<body>
<div class="PopupPage-MainContainer">
	<div class="PopupPage-HeaderButtonContainer">
		<a class="btndoneediting" href="#" onclick="closeWindowReloadFlowChart(this.window)">Done Editing</a>
	</div>
	<div class="PopupPage-HeaderContainer">
		<div class="HeaderText">
			<h4>Currently Viewing:</h4>
		</div>
		<div class="HeaderInfo">
			<ul class="HeaderInfoList">
				<li><?php echo $course->course_number; ?></li>
				<li><?php echo $course->course_name; ?></li>
				<li><?php echo $course->course_description; ?></li>
			</ul>
		</div>
	</div>
	<div class="PopupPage-NavigationContainer">
		<ul class="nav">
			<li class="navitem"><a class="navlink" href="manage-course.php?course_ID=<?php echo $course->ID; ?>">Manage
					Course Information</a></li>
			<li class="navitem"><a class="navlink" href="manage-students.php?course_ID=<?php echo $course->ID; ?>">Manage
					Registered Students</a></li>
			<li class="navitem"><a class="navlink" href="manage-textbooks.php?course_ID=<?php echo $course->ID; ?>">Manage
					Course Textbooks</a></li>
		</ul>
	</div>
	<div class="PopupPage-BodyContainer">
