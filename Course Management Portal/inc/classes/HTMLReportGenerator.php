<?php

//include the database configuration file
require_once(dirname(dirname(dirname(__FILE__))) . '/conf/constants.php');

class HTMLReportGenerator
{

    public function generateGraduatedStudentReport($arrayOfStrParameters)
    {
        if (sizeof($arrayOfStrParameters) == 4) {
            $programID = $arrayOfStrParameters['selectProgram'];
            $year = $arrayOfStrParameters['selectYear'];
            $students = Student::find_all_by_graduated($programID, $year);
            ?>
            <table border="1" width="100%">
                <tr>
                    <th>Student Name</th>
                    <th>Student Number</th>
                </tr>

                <?php if ($students == null) {
                    ?>
                    <tr>
                        <td colspan="3" align="center">No data to display</td>
                    </tr>
                <?php } else
                    foreach ($students as $student) {
                        {
                            ?>
                            <tr>
                                <td><?php echo $student->student_lname . ',' . $student->student_fname?></td>
                                <td><?php echo $student->student_number?></td>
                            </tr>
                        <?php }
                    } ?>

            </table>
        <?php
        } else {
            echo "DEV ERROR: Wrong amount of parameters sent to getReport({__FUNCTION__},\$arrayOfStrParameters";
        }
    }

    public function generateStudentMissingCoursesReport($arrayOfStrParameters)
    {
        if (sizeof($arrayOfStrParameters) == 3) {
            $programID = $arrayOfStrParameters['selectProgram'];
            $students = Student::find_all_by_missing_course($programID);
            $error = "No data found";
            ?>
            <table border="1" width="100%">
                <tr>
                    <th>Student Name</th>
                    <th>Student Number</th>
                    <th>Missing Course</th>
                </tr>
                <?php if ($students == null) {
                    ?>
                    <tr>
                        <td colspan="3" align="center"><?php echo $error ?></td>
                    </tr>
                <?php } else
                    foreach ($students as $student) {
                        {
                            ?>
                            <tr>
                                <td><?php echo $student->student_lname . ',' . $student->student_fname?></td>
                                <td><?php echo $student->student_number?></td>
                                <td><?php echo $student->course_name?></td>
                            </tr>
                        <?php }
                    } ?>
            </table>
        <?php
        } else {
            echo "DEV ERROR: Wrong amount of parameters sent to getReport({__FUNCTION__},\$arrayOfStrParameters";
        }
    }

    public function generateFailReport($arrayOfStrParameters)
    {
        if (sizeof($arrayOfStrParameters) == 3) {
            $programID = $arrayOfStrParameters['selectProgram'];
            $students = Student::find_all_by_failed_course($programID);
            $error = "No data found";
            ?>
            <table border="1" width="100%">
                <tr>
                    <th>Student Name</th>
                    <th>Student Number</th>
                    <th>Failed Course</th>
                </tr>
                <?php if ($students == null) {
                    ?>
                    <tr>
                        <td colspan="3" align="center"><?php echo $error ?></td>
                    </tr>
                <?php } else
                    foreach ($students as $student) {
                        {
                            ?>
                            <tr>
                                <td><?php echo $student->student_lname . ',' . $student->student_fname?></td>
                                <td><?php echo $student->student_number?></td>
                                <td><?php echo $student->course_name?></td>
                            </tr>
                        <?php }
                    } ?>
            </table>
        <?php
        } else {
            echo "DEV ERROR: Wrong amount of parameters sent to getReport({__FUNCTION__},\$arrayOfStrParameters";
        }
    }
}



