//popup window
function openWindow(pageToOpen) {

    window.open(pageToOpen, 'Manage Course',
        'width=' + screen.availWidth + ',height=' + (screen.availHeight - 70));

    return false;
}

//close window
function closeWindowReloadFlowChart(pageToClose) {
    opener.location = pageToClose;
    close();
    window.opener.location.reload(true);//reload from the server
}


/* Flow Chart Page */

//connect two div's together
function connect(div1, div2, color, thickness, courseLevelOffset) {

    var off1 = getOffset(div1);
    var off2 = getOffset(div2);
    // bottom right
    var x1 = (off1.left - courseLevelOffset) + off1.width;
    var y1 = off1.top + off1.height;
    // top right
    var x2 = (off2.left - courseLevelOffset) + off2.width;
    var y2 = off2.top;
    // distance
    var length = Math.sqrt(((x2 - x1) * (x2 - x1)) + ((y2 - y1) * (y2 - y1)));
    // center
    var cx = ((x1 + x2) / 2) - (length / 2);
    var cy = ((y1 + y2) / 2) - (thickness / 2);
    // angle
    var angle = Math.atan2((y1 - y2), (x1 - x2)) * (180 / Math.PI);
    // make hr
    var htmlLine = "<div style='" +
        "padding:0px; " +
        "margin:0px; " +
        "height:" + thickness + "px; " +
        "background-color:" + color + "; " +
        "line-height:1px; " +
        "position:absolute; " +
        "left:" + cx + "px; " +
        "top:" + cy + "px; " +
        "width:" + length + "px; " +
        "-moz-transform:rotate(" + angle + "deg); " +
        "-webkit-transform:rotate(" + angle + "deg); " +
        "-o-transform:rotate(" + angle + "deg);" +
        "-ms-transform:rotate(" + angle + "deg); " +
        "transform:rotate(" + angle + "deg); " +
        "z-index:-999;'>" +
        "</div>";
    //
    //alert(htmlLine);
    document.body.innerHTML += htmlLine;
}

function getOffset(el) {
    var _x = 0;
    var _y = 0;
    var _w = el.offsetWidth | 0;
    var _h = el.offsetHeight | 0;

    while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
    }

    return { top: _y, left: _x, width: _w, height: _h };

}

//find the prerequisites
function findPrerequisites(div1, div2, lineColor, lineSize, courseLevelOffset) {

    var div1 = document.getElementById(div1);
    var div2 = document.getElementById(div2);

    //connect them
    connect(div1, div2, lineColor, lineSize, courseLevelOffset);

}

function getResultsFromFlowChartSearch(searchString)
{
    if (searchString.length==0)
    {
        document.getElementById("flowchart-search-results").innerHTML="";
        document.getElementById("flowchart-search-results").style.border="0px";
        document.getElementById("flowchart-search-results").style.display="none";
        return;
    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("flowchart-search-results").innerHTML=xmlhttp.responseText;
            document.getElementById("flowchart-search-results").style.border="1px solid #A5ACB2";
            document.getElementById("flowchart-search-results").style.display="block";
        }
    }
    xmlhttp.open("GET","inc/ajax_files/flowchart-search-results.php?search="+searchString,true);
    xmlhttp.send();
}


//END flow chart page

/* AJAX working */
function showAJAXLoadingIndicator() {

    document.getElementById('ajaxsymbol').style.display = 'block';
    document.getElementById('no-student-message').style.display = 'none';

}


/* Manage Students Page */

function getResultsFromManageStudentsSearch(searchString){
    if (searchString.length==0)
    {
        document.getElementById("manage-student-search-results").innerHTML="";
        document.getElementById("manage-student-search-results").style.border="0px";
        document.getElementById("manage-student-search-results").style.display="none";
        return;
    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("manage-student-search-results").innerHTML=xmlhttp.responseText;
            document.getElementById("manage-student-search-results").style.border="1px solid #A5ACB2";
            document.getElementById("manage-student-search-results").style.display="block";
        }
    }
    xmlhttp.open("GET","inc/ajax_files/manage-students-search-results.php?search="+searchString,true);
    xmlhttp.send();
}

function showSelectedStudent(studentnumber) {
    if (studentnumber == "") {
        //alert('studentnumber should not be null');
        // document.getElementById("studentdetailtable").innerHTML="";
        return;
    }

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("studentdetailtable").innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET", "inc/ajax_files/students-response.php?student_number=" + studentnumber, true);
    xmlhttp.send();
}

function calculateGPA() {
    var valz = document.getElementById("txtGradePercentage").value;
    var element = document.getElementById("txtLetterGrade");
    var val = parseFloat(valz);
    if (val <= 100 && val >= 90) {
        element.value = "A+";

    }
    else if (val < 90 && val >= 85) {
        element.value = "A";
        //$var=$txtLetterGrade;
    }
    else if (val < 85 && val >= 80) {
        element.value = "A-";
        //$var=$txtLetterGrade;
    }
    else if (val < 80 && val >= 77) {
        element.value = "B+";
        //$var=$txtLetterGrade;
    }
    else if (val < 77 && val >= 73) {
        element.value = "B";
        //$var=$txtLetterGrade;
    }
    else if (val < 73 && val >= 70) {
        element.value = "B-";
        //$var=$txtLetterGrade;
    }
    else if (val < 70 && val >= 67) {
        element.value = "C+";
        //$var=$txtLetterGrade;
    }
    else if (val < 67 && val >= 63) {
        element.value = "C";
        //$var=$txtLetterGrade;
    }
    else if (val < 63 && val >= 60) {
        element.value = "C-";
        //$var=$txtLetterGrade;
    }
    else if (val < 60 && val >= 57) {
        element.value = "D+";
        //$var=$txtLetterGrade;
    }
    else if (val < 57 && val >= 53) {
        element.value = "D";
        //$var=$txtLetterGrade;
    }
    else if (val < 53 && val >= 50) {
        element.value = "D-";
        //$var=$txtLetterGrade;
    }
    else if (val < 49 && val >= 0) {
        element.value = "F";
        //$var=$txtLetterGrade;
    }
    else {
        element.value = "FSP";
        //$var=$txtLetterGrade;
    }

    //document.getElementsByName("$txtLetterGrade");
    //return $txtLetterGrade;

}

//END Manage Students Page


function showSelectedBook(book_id) {
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("textbookform").innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET", "inc/ajax_files/textbooks-response.php?book_id=" + book_id, true);
    xmlhttp.send();
}

function showSelectedCourse(coursenumber) {
    if (coursenumber == "") {

        return;
    }

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("coursedetailtable").innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET", "inc/ajax_files/courses-response.php?course_number=" + coursenumber, true);
    xmlhttp.send();
}

function showSelectedUser(userID) {
    if (userID == "") {

        return;
    }

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("current-user-form").innerHTML = xmlhttp.responseText;
        }
    }

    xmlhttp.open("GET", "inc/ajax_files/users-response.php?userID=" + userID, true);
    xmlhttp.send();
}

function clearErrorMessages(){

    document.getElementsByClassName('error-message').text="";
}

function checkPasswordsMatch()
{

    var firstPassword = document.getElementById('first-pass');
    var secondPassword = document.getElementById('second-pass');
    var passwordMessage = document.getElementById('error-message');
    var passColour = "#66cc66";
    var failColour = "#ff6666";

    if( /^([A-Za-z0-9]{8,})$/.test(firstPassword.value) ){

        //if the passwords match
        if(firstPassword.value == secondPassword.value){

            secondPassword.style.backgroundColor = passColour;
            passwordMessage.style.color = passColour;
            passwordMessage.innerHTML = "Your passwords match!"

        }else{

            //the passwords don't match
            secondPassword.style.backgroundColor = failColour;
            passwordMessage.style.color = failColour;
            passwordMessage.innerHTML = "Your passwords do not match!"
        }

    }else{//password does not pass regex

        //the passwords don't match
        firstPassword.style.backgroundColor = failColour;
        passwordMessage.style.color = failColour;
        passwordMessage.innerHTML = "Your passwords must be 8 characters, one uppercase, one lowercase and one number."

    }
}

function passwordRegex(){

    var firstPassword = document.getElementById('first-pass');
    var passwordMessage = document.getElementById('error-message');
    var failColour = "#ff6666";
    var passColour = "#66cc66";

    if( /^([A-Za-z0-9]{8,})$/.test(firstPassword.value) ){

        passwordMessage.innerHTML = "";
        firstPassword.style.backgroundColor = passColour;

    }else{//password does not pass regex

        //the passwords don't match
        firstPassword.style.backgroundColor = failColour;
        passwordMessage.style.color = failColour;
        passwordMessage.innerHTML = "Your passwords must be 8 characters, one uppercase, one lowercase and one number."

    }
}

function clearErrors(){

    document.getElementById('error-message').innerHTML = "";

}