<<<<<<< HEAD
<?php
$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'uploads';   //2
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile,$targetFile); //6
     
}
?> 
- See more at: http://www.startutorial.com/articles/view/how-to-build-a-file-upload-form-using-dropzonejs-and-php#sthash.HL8WLKRp.dpuf
=======
<?
//get all of the includes
require_once( dirname( __FILE__ ) . '/inc/includes.php' );
?>

<?php
session_start(); 
//declare variables
$f_location = $upload_path = $_SESSION['location'];
$f = fopen($f_location, "r");
$csvData = file_get_contents($f_location);
$lines = explode(PHP_EOL, $csvData);
$array = array();
$arrayExistingStudent = array();
$array_student_id = array();
$array_student_grade = '';
$array_student_course = '';
$id=Student::count_students()+1;
$semester;
$semester_id='';
$program_id;
$result;

//get csv data
foreach ($lines as $line){
    if($line[1] != null){
        $array[] = str_getcsv($line);
    }
}
if (strpos($array[0][0],'FALL') !== false){
    $semester = 'F';
}else {
    $semester = 'W';
}
if (strpos($array[0][0],'3002X') !== false && strpos($array[0][0],'2012') !== false && strpos($array[0][0],'FALL') !== false) {
    $program_id = 1;
    $semester_id = '12'.$semester;

} elseif (strpos($array[0][0],'3002X') !== false && strpos($array[0][0],'2013') !== false){
    $program_id = 2;
    $semester_id = '13'.$semester;
} elseif (strpos($array[0][0],'3002X') !== false && strpos($array[0][0],'2014') !== false){
    $program_id = 3;
    $semester_id = '14'.$semester;
} elseif (strpos($array[0][0],'3002X') !== false && strpos($array[0][0],'2015') !== false){
    $program_id = 4;
    $semester_id = '15'.$semester;
}


$j=0;
$x=4;
//insert students and student grades
for($i =2 ; $i < count($array); $i++) {
    $student = new Student();
    $studentCourse = new StudentCourse();
    $studentGrade = new StudentGrade();

    if ($student->find_by_student_number(str_replace("-", "", $array[$i][0]))) {
        $arrayExistingStudent[] = $array[$i][0] . " " . $array[$i][1];
    } else {
        $student->ID=++$id;
        $student->student_number = str_replace("-", "", $array[$i][0]);
        $student->student_fname  = $array[$i][1];
        $student->student_lname  = $array[$i][2];
        $student->programs_id = $program_id;
        $student->create1();

        //build fields required for student course reg
        //$array_student_id[$j][$j] = Student::find_id_by_student_number(str_replace("-", "", $array[$i][0]));
      for($x=4;$x<count($array);$x++) {
          if ($array[$i][$x] != "") {
              $array_student_course = Course::get_id_by_course_number($array[0][$x]);
              $array_student_grade = $array[$i][$x];


       $studentCourse->student_courses_semester = $semester_id;
       $studentCourse->courses_ID = $array_student_course->ID;
        $studentCourse->students_ID = $id;
        $studentCourse->students_student_number = str_replace("-", "", $array[$i][0]);
        $studentCourse->save();
     
              $studentGrade->letter_grade=$array_student_grade;
              $studentGrade->courses_ID=$array_student_course->ID;
              $studentGrade->students_ID=$id;
              $studentGrade->students_student_number=str_replace("-", "", $array[$i][0]);
              $studentGrade->save();
          }


      }
    }
$j++;
    $x++;
}


//var_dump($array_student_course);
if(count($arrayExistingStudent) > 0  ){
    foreach ($arrayExistingStudent as $existingStudent) {
        echo $existingStudent." already exists and has not been registered<br>";
    }
}else {
    echo "Your csv has been uploaded.  <a href='uploadCSV.php'>Click here to return</a>";
    unset($_GET['file']);
}
//for($i=3;$i<count($array[0]);$i++) {
//    $array_student_course[] = Course::get_id_by_course_number($array[0][$i]);
//}







?>
>>>>>>> origin/master
