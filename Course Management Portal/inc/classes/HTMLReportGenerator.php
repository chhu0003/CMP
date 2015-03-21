<?php

//include the database configuration file
require_once(dirname(dirname(dirname(__FILE__))) . '/conf/constants.php');

class HTMLReportGenerator
{

    public function generateGraduatedStudentReport($arrayOfStrParameters)
    {
        var_dump($arrayOfStrParameters);
        if(sizeof($arrayOfStrParameters) == 2) {
            $programID = $arrayOfStrParameters[0];
            $year = $arrayOfStrParameters[1];
            $students = Student::find_all_by_graduated($programID, $year);
            $error = "No students found";
            ?>
            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Student Number</th>
                    <th>Graduating Year</th>
                </tr>
                //if false write a message on one row
                //else generate results
                <?php if ($students = false) {
                    ?>
                    <tr>
                        <td colspan="3"><?php echo $error ?></td>
                    </tr>
                <?php } else
                    foreach ($students as $student) {
                        {
                            ?>
                            <tr>
                                <td><?php echo $student->student_lname . ',' . student_fname?></td>
                                <td><?php echo $student->student_number?></td>
                            </tr>
                        <?php }
                    }?>

            </table>
        <?php
        }
        else
        {
            echo "DEV ERROR: Wrong amount of parameters sent to getReport({__FUNCTION__},\$arrayOfStrParameters";
        }
    }

    protected function generateStudentMissingCoursesReport($arrayOfStrParameters)
    {
        if(sizeof($arrayOfStrParameters) == 2) {
            $programID = $arrayOfStrParameters[0];
            $course = $arrayOfStrParameters[1];
            $students = Student::find_all_by_course($programID, $course);
            $error = "No missing courses found";
            ?>
            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Student Number</th>
                    <th>Missing Course</th>
                </tr>
                //if false write a message on one row
                //else generate results
                <?php if ($students = false) {
                    ?>
                    <tr>
                        <td colspan="3"><?php echo $error ?></td>
                    </tr>
                <?php } else
                    foreach ($students as $student) {
                        {
                            ?>
                            <tr>
                                <td><?php echo $student->student_lname . ',' . student_fname?></td>
                                <td><?php echo $student->student_number?></td>
                                <td><?php echo $student->course?></td>
                            </tr>
                        <?php }
                    }?>

            </table>
        <?php
        }
        else
        {
            echo "DEV ERROR: Wrong amount of parameters sent to getReport({__FUNCTION__},\$arrayOfStrParameters";
        }
    }

    protected function generateFailReport($arrayOfStrParameters)
    {
        if(sizeof($arrayOfStrParameters) == 2) {
            $programID = $arrayOfStrParameters[0];
            $course = $arrayOfStrParameters[1];
            $students = Student::find_all_by_course($programID, $course);
            $error = "No courses found";
            ?>
            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Student Number</th>
                    <th>Failed Course</th>
                </tr>
                //if false write a message on one row
                //else generate results
                <?php if ($students = false) {
                    ?>
                    <tr>
                        <td colspan="3"><?php echo $error ?></td>
                    </tr>
                <?php } else
                    foreach ($students as $student) {
                        {
                            ?>
                            <tr>
                                <td><?php echo $student->student_lname . ',' . student_fname?></td>
                                <td><?php echo $student->student_number?></td>
                                <td><?php echo $student->course?></td>
                            </tr>
                        <?php }
                    }?>

            </table>
        <?php
        }
        else
        {
            echo "DEV ERROR: Wrong amount of parameters sent to getReport({__FUNCTION__},\$arrayOfStrParameters";
        }
    }

    public function getReport($strReportName, $arrayOfStrParameters){
        call_user_func($this,"generate". $strReportName, $arrayOfStrParameters);
    }
}



