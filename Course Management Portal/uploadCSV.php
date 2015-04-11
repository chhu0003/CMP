<?
//get all of the includes
require_once( dirname( __FILE__ ) . '/inc/includes.php' );
$file_location='';

?>

<html>
<head>

	<title>Upload Student CSV</title>
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
			<h4>Upload Student CSV</h4>
		</div>
	</div>
	<div class="PopupPage-NavigationContainer">
		<ul class="nav">
		</ul>
	</div>
	<div class="PopupPage-BodyContainer">
		<div class="PopupPage-FormHolder manage-users">
		<section id="wrapper">

			<form action="" method="post" enctype="multipart/form-data">

				<table cellpadding="0" cellspacing="0" border="0" class="table">
					<tr>
						<th><label for="file">Select file</label> <?php echo $message; ?></th>
					</tr>
					<tr>
						<td><input type="file" name="file" id="file" size="30" /></td>
					</tr>
					<tr>
						<td><input type="submit" id="btn" class="fl_l" value="Submit" /></td>
					</tr>
				</table>

			</form>

		</section>
<?

$message = null;

$allowed_extensions = array('csv');

$upload_path = 'uploads/';
if (!empty($_FILES['file'])) {

	if ($_FILES['file']['error'] == 0) {

		// check extension
		$file = explode(".", $_FILES['file']['name']);
		$extension = array_pop($file);

		if (in_array($extension, $allowed_extensions)) {

			if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path.'/'.$_FILES['file']['name'])) {
             $location = $upload_path.'/'.$_FILES['file']['name'];
				$file_location = $_SESSION['location'];
                session_start(); 
                
                echo '<h3>Preview of CSV</h3><form action="upload.php"><input type="submit" value="Confirm Upload"></form>';


				if (($handle = fopen($location, "r")) !== false) {

					$keys = array();
					$out = array();

					$insert = array();

					$line = 1;
					echo '<div style="width: 100%; height: 400px; overflow: scroll;">';
					echo "<table border='1'>\n\n ";
					echo "<tbody>";
					while (($row = fgetcsv($handle, 0, ',', '"')) !== FALSE) {
						echo "<tr>";
						list($column1, $column2, $column3, $column4, $column5, $column6, $column7,
							$column8, $column9, $column10, $column11, $column12, $column13, $column14) = $row;
						foreach ($row as $cell){
							echo '<td ">' . htmlspecialchars($cell) . "</td>";
						}
						foreach($row as $key => $value) {

							if ($line === 3) {
								$keys[$key] = $value;

							} else {
								$out[$line][$key] = $value;

							}
						}

						echo "</tr>\n";
						$line++;

					}

					fclose($handle);
					echo "\n</tbody>";
					echo "\n</table>";

				}

			}

		} else {
			$message = '<span class="red">Only .csv file format is allowed</span>';
		}

	} else {
		$message = '<span class="red">There was a problem with your file</span>';
	}

}

?>
</div>
	</div>
	</div>


<?php




?>




<?php require_once( dirname( __FILE__ ) . '/footer.php' ); ?>



