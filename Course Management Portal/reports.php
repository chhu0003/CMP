<?php
require_once( dirname( __FILE__ ) . '/header.php' );

$report = new HTMLReportGenerator();
?>
<?php
if (($_GET["reportName"]) == "GraduatedStudentReport"){
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <input type="hidden" name="reportName" id="reportName" value="<?php echo($_GET["reportName"]);?>" />
        <select name="selectProgram" id="selectedProgram" >
            <option selected>List of programs</option>
            <?php
            $programs = Program::find_all();
            foreach( $programs as $program ) {
                echo "<option value='" . $program->ID . "'  clearErrors();' >" . $program->program_code . " " . $program->program_year . "</option>";
            }
            ?>
        </select>
        Graduating Year:
        <select name="selectYear" id="selectedYear" >
            <option selected>Select a year</option>
            <?php
            $year = 2012;
            for ( $counter = 1; $counter <= 8; $counter += 1) {
                echo "<option value='" . $year . "'>" . $year . "</option>";
                $year++;
            }

            ?>
        </select>
        <input type="submit" name="btnCreateReport" value="Create Report">
    </form>
<?php
}


 elseif(isset ($_GET["reportName"]) == "StudentMissingCourseReport" || isset($_GET["reportName"]) == "FailReport") {
    ?>
    <div class="error-message"> <?php ( !empty( $errorMessage ) ) ? print( $errorMessage ) : print( '' ); ?> </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <input type="hidden" name="reportName" id="reportName" value="<?php echo($_GET["reportName"]);?>" />
        <select name="selectProgram" id="selectedProgram" >
            <option selected>List of programs</option>
            <?php
            $programs = Program::find_all();
            foreach( $programs as $program ) {
                echo "<option value='" . $program->ID . "'  clearErrors();' >" . $program->program_code . " " . $program->program_year . "</option>";
            }
            ?>
        </select>
        <input type="submit" name="btnCreateReport" value="Create Report">
    </form>

<?php } else {
    //TODO error message
}
if(isset($_POST['btnCreateReport']) && ($_POST['reportName']) == "GraduatedStudentReport"){
    HTMLReportGenerator::generateGraduatedStudentReport($_POST);
}
elseif(isset($_POST['btnCreateReport']) && ($_POST['reportName']) == "StudentMissingCoursesReport"){
    HTMLReportGenerator::generateStudentMissingCoursesReport($_POST);
}
elseif(isset($_POST['btnCreateReport']) && ($_POST['reportName']) == "FailReport"){
    HTMLReportGenerator::generateFailReport($_POST);
}?>
