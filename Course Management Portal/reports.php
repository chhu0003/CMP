<?php
require_once( dirname( __FILE__ ) . '/header.php' );
//$__SHARED__->share("HTMLReportGenerator",HTMLReportGenerator);
$report = new HTMLReportGenerator();
?>
<?php
if(isset ($_GET["reportName"]))
{
   //TODO add dropdown list for program and year to appear after user clicks on report type. one div for dropdowns
   // and generate report button
    //a second div for the report (this will show only once the generate report button
   // $report->getReport($_GET["reportName"],);

    $availablePrograms = Program::find_distinct_program();
    //$programYear = Program::find_distinct_year();
    $concatString = "-^-";

    ?>
    <div class="error-message"> <?php ( !empty( $errorMessage ) ) ? print( $errorMessage ) : print( '' ); ?> </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

    <select name="selectProgram" id="selectedProgram" onchange="unlockYears()">
        <option selected>List of programs</option>
        <?php

        foreach($availablePrograms as $availableProgram)
       {
          echo '<option value="' . $availableProgram->program_code . '">'.$availableProgram->program_name.'</option>';
        }
        ?>
    </select>
    <select name="selectYear" id="selectedYear" disabled>
        <option selected>Select a year</option>
    </select>
    <input type="submit" name="btnCreateReport" value="Create Report">
    </form>

<?php

}
else
{
    //TODO error message
}
if(isset($btnRunReport)){
    {

        HTMLReportGenerator::getReport($availableProgram,$program);


    }
}
?>
<script>
    var concatString = '<?php echo $concatString; ?>';

    function unlockYears()
    {
        var ddlProgramList = document.getElementById('selectedProgram').options;
        var selectedProgram = ddlProgramList[ddlProgramList.selectedIndex].value;

        $programYear = Program::find_distinct_year(selectedProgram);

        findOptionsByCodeAndCreateDDLSelectYear(selectedProgram);

        if (ddlProgramList.selectedIndex != 0) {
            document.getElementById('selectedYear').removeAttribute('disabled');
        } else {
            document.getElementById('selectedYear').setAttribute('disabled', 'disabled');
        }
    }

    function findOptionsByCodeAndCreateDDLSelectYear(selectedProgram){
        clearSelectedYearList();
        var ddlProgramList = document.getElementById('selectedProgram').options;
        if (ddlProgramList.selectedIndex != 0) {
            var ddlYears = document.getElementById('selectedYear').options;

            var programList = [<?php foreach ($availablePrograms as $program) {
            echo "'" . $program->program_code . $concatString . $program->program_year . "', ";
        } ?>];

            //Loop through programList/ split item using concatString
            //compare program[0] with selectedProgramInfo
            //if match add program[1] to year ddl
            for (var x in programList) {
                var program = programList[x].split(concatString);
                if (program[0] == selectedProgram) {
                    var option = document.createElement("option");
                    option.text = program[1];
                    option.value = program[1]
                    ddlYears.add(option);
                }
            }
        }
    }

    function clearSelectedYearList() {
        //loop through option elements in list
        //ddlYears.remove if index != 0
        var ddlYears = document.getElementById('selectedYear');
        var defaultYear = ddlYears.options[0].innerHTML;

        for (var year in ddlYears) {
            ddlYears.remove(year);
        }

        var option = document.createElement('option');
        option.text = defaultYear;
        ddlYears.add(option);
    }

</script>