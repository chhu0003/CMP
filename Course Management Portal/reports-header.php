<?php

//reports header for popup window
?>

<html>
<head>

    <title>Reports</title>
    <link rel="stylesheet" href="css/style.css"/>
    <script src="js/common.js"></script>

    <link rel="shortcut icon" href="favicon.ico" type="image/png">


</head>
<body>
<div class="PopupPage-MainContainer">
    <div class="PopupPage-HeaderButtonContainer">
        <a class="btndonereports"  href="#" onclick="closeWindowReloadFlowChart(this.window)">Done Reports</a>
    </div>
    <div class="PopupPage-HeaderContainer">
        <div class="HeaderText">
            <h4>Select a report</h4>
        </div>
    </div>
    <div class="PopupPage-NavigationContainer">
        <ul class="nav">
            <li class="navitem"><a class="navlink" href="reports.php?reportName=GraduatedStudentReport">Graduated Students</a></li>
            <li class="navitem"><a class="navlink" href="reports.php?reportName=StudentMissingCoursesReport">Students with Missing Course(s)</a></li>
            <li class="navitem"><a class="navlink" href="reports.php?reportName=FailReport">Students with Failed Course(s)</a></li>
        </ul>
    </div>
    <div class="PopupPage-BodyContainer">
