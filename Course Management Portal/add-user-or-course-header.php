<?php

//manage users header for manage users pop up window

?>


<html>
<head>

	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="css/style.css"/>
	<script src="js/common.js"></script>


</head>
<body>
<div class="PopupPage-MainContainer">
	<div class="PopupPage-HeaderButtonContainer">
		<a class="btndoneediting" href="#" onclick="closeWindowReloadFlowChart(this.window)">Done Editing</a>
	</div>
	<div class="PopupPage-HeaderContainer">
		<div class="HeaderText">
			<h4><?php echo $pageTitle; ?></h4>
		</div>
	</div>
	<div class="PopupPage-NavigationContainer">
		<ul class="nav">
		</ul>
	</div>
	<div class="PopupPage-BodyContainer">
