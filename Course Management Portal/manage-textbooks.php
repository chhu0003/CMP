<?php require_once( dirname( __FILE__ ) . '/header.php' ); ?>
<?php

$errorMessages = "";
$title = "";
$edition = "";
$ISBN = "";
$author = "";
$publisher = "";

if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

	// Setting up Post variables
	$title     = $_POST[ "txtTitle" ];
	$edition   = $_POST[ "txtEdition" ];
	$ISBN      = $_POST[ "txtISBN" ];
	$author    = $_POST[ "txtAuthor" ];
	$publisher = $_POST[ "txtPublisher" ];
	$type      = ( isset( $_POST[ "CoverType" ] ) ) ? $_POST[ "CoverType" ] : '';
	$required  = $_POST[ "radioRecommendedRequired" ];
	$book_id   = ( isset( $_POST[ "lstRegisteredTextbooks" ] ) ) ? $_POST[ "lstRegisteredTextbooks" ] : '';
	$quantity  = $_POST[ "txtQuantity" ];


	if( isset( $_POST[ "btnSaveChanges" ] ) ) {

		$values = array(
			"book_title"     => $title,
			"book_edition"   => $edition,
			"book_isbn"      => $ISBN,
			"book_author"    => $author,
			"book_publisher" => $publisher,
			"book_type"      => $type,
			"book_required"  => $required,
			"book_quantity"  => $quantity
		);

		$oldValues = $_SESSION[ 'oldBookValues' ];

		//Set Validator
		$validator = new TextbookValidator( $oldValues, $values );

		//Run Validator
		$isValid = $validator->run();

		if( $isValid !== true ) { //it has an error message in it
			$displayMessage = $isValid;
		}

		// If validation passed
		if( $isValid === true ) {

			//set the values
			$book = Book::find_by_ID( $book_id );

			if( $book ) {
				$book->book_title     = $title;
				$book->book_isbn      = $ISBN;
				$book->book_edition   = $edition;
				$book->book_author    = $author;
				$book->book_publisher = $publisher;
				$book->book_type      = $type;
				$book->book_required  = $required; //int 0=false 1=true, cannot be null
				$book->book_quantity  = $quantity;
				$book->courses_ID     = $_GET[ 'course_ID' ]; //the current courses ID, cannot be null

				//update the book in the db

				$book->save();



			}

		}
		//END if($isValid && !empty($isValid))
	}

	if( isset( $_POST[ "btnAddBook" ] ) ) {


		$values = array(
			"book_title"     => $title,
			"book_edition"   => $edition,
			"book_isbn"      => $ISBN,
			"book_author"    => $author,
			"book_publisher" => $publisher,
			"book_type"      => $type,
			"book_required"  => $required,
			"book_quantity"  => $quantity );

		$oldValues = array(
			"book_title"     => "",
			"book_edition"   => "",
			"book_isbn"      => "",
			"book_author"    => "",
			"book_publisher" => "",
			"book_type"      => "",
			"book_required"  => 0,
			"book_quantity"  => "" );

		//Set Validator
		$validator = new TextbookValidator( $oldValues, $values );

		//Run Validator
		$isValid = $validator->run();

		if( $isValid !== true ) { //it has an error message in it
			$displayMessage = $isValid;
		}

		//If validation passed
		if( $isValid === true ) {

			$book = new Book();
			//set the values
			$book->book_title     = $title; //cannot be null
			$book->book_isbn      = $ISBN;
			$book->book_edition   = $edition;
			$book->book_author    = $author;
			$book->book_publisher = $publisher;
			$book->book_type      = $type;
			$book_required        = $required; //int 0=false 1=true, cannot be null
			$book->courses_ID     = $_GET[ 'course_ID' ]; //the current courses ID, cannot be null

			//create the book
			$book->save();

			$displayMessage = "Book added successfully";

			//unset the post values so that the book doesn't show up in the form fields
			unset($_POST);

		}

	}

	if( isset( $_POST[ "btnRemoveTextbook" ] ) ) {
		$book_id = $_POST[ "lstRegisteredTextbooks" ];
		$book    = Book::find_by_ID( $book_id );
		if( $book ) {
			$book->delete();
			$success = "Book Successfully Removed";

			//unset the post values so that the deleted book doesn't show up in the form fields
			unset($_POST);

		} else {
			$success = "Book Does not Exist";
		}
	}

}//END if($_SERVER['REQUEST'] == 'POST')
?>

	<div class="PopupPage-FormHolder manage-textbooks">
		<?php ( !empty( $errorMessages ) ) ? print( $errorMessages ) : print( '' ); ?>
		<form action="#" method="post">
			<div class="PopupPage-leftformcontainer">
				<h5 class="lstheader">Registered Textbooks</h5>
				<select class="lstRegisteredTextbooks" size="10" name="lstRegisteredTextbooks">

					<?php

					//get the text books registered to this course
					$books = Book::find_by_course_ID( $_GET[ 'course_ID' ] );

					if( $books ) {

						foreach( $books as $book ) {
							$var = "showSelectedBook('" . $book->ID . "')";
							echo "<option onclick=" . $var . " value='" . $book->ID . "' >" . $book->book_title;
							!empty( $book->book_edition ) ? print( " - " . $book->book_edition ) : print( '' ) . "</option>";


						}

					}

					?>

				</select>
			</div>
			<div class="PopupPage-rightformcontainer">

				<h4 class="textbookheader">
					View/Manage Textbooks
				</h4>
				<table id="textbookform">

					<tr>
						<td>Title:</td>
						<td><input type="textbox" name="txtTitle" value="<?php echo isset($_POST['txtTitle']) ? $_POST['txtTitle'] : ''; ?>" required="required"/></td>
					</tr>
					<tr>
						<td>Edition:</td>
						<td><input type="textbox" name="txtEdition" value="<?php echo isset($_POST['txtEdition']) ? $_POST['txtEdition'] : ''; ?>" /></td>
					</tr>
					<tr>
						<td>ISBN:</td>
						<td><input type="textbox" name="txtISBN" value="<?php echo isset($_POST['txtISBN']) ? $_POST['txtISBN'] : ''; ?>"/></td>
					</tr>
					<tr>
						<td>Author(s)</td>
						<td><input type="textbox" name="txtAuthor" value="<?php echo isset($_POST['txtAuthor']) ? $_POST['txtAuthor'] : ''; ?>"/></td>
					</tr>
					<tr>
						<td>Publisher(s)</td>
						<td><input type="textbox" name="txtPublisher" value="<?php echo isset($_POST['txtPublisher']) ? $_POST['txtPublisher'] : ''; ?>"/></td>
					</tr>
					<tr>
						<td>Cover Type</td>
						<td>Hard:<input type="radio" name="CoverType" value="1"/>
							Soft:<input type="radio" name="CoverType" value="2"/>
							e-Textbook:<input type="radio" name="CoverType" value="3"/>

						</td>
					</tr>
					<tr>
						<td>Recommended:</td>
						<td><input type="radio" name="radioRecommendedRequired" value="0" checked="checked"/></td>
					</tr>
					<tr>
						<td>Required</td>
						<td><input type="radio" name="radioRecommendedRequired" value="1"/></td>
					</tr>
					<tr>
						<td>Quantity:</td>
						<td><input type="textbox" name="txtQuantity" value="<?php echo isset($_POST['txtQuantity']) ? $_POST['txtQuantity'] : ''; ?>"/></td>
					</tr>
					<tr>
						<td><input type="submit" name="btnAddBook" value="Add New Book"/></td>
					</tr>

					<tr>
						<td><div class="error-message"><?php !empty( $displayMessage ) ? print( $displayMessage ) : print( '' ); ?></div></td>
					</tr>
				</table>
		</form>
	</div>

<?php require_once( dirname( __FILE__ ) . '/footer.php' ); ?>