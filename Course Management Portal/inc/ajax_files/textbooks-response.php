<?php

require_once( dirname( dirname( __FILE__ ) ) . '/includes.php' );

//ajax response for manage-textbooks.php

if( !empty( $_REQUEST[ "book_id" ] ) ) {

	$matchBook = Book::find_by_ID( $_REQUEST[ "book_id" ] );

	$oldValues = array(
		"book_title"     => empty( $matchBook->book_title ) ? '' : $matchBook->book_title,
		"book_edition"   => empty( $matchBook->book_edition ) ? '' : $matchBook->book_edition,
		"book_isbn"      => empty( $matchBook->book_isbn ) ? '' : $matchBook->book_isbn,
		"book_author"    => empty( $matchBook->book_author ) ? '' : $matchBook->book_author,
		"book_publisher" => empty( $matchBook->book_publisher ) ? '' : $matchBook->book_publisher,
		"book_type"      => empty( $matchBook->book_type ) ? '' : $matchBook->book_type,
		"book_required"  => empty( $matchBook->book_required ) ? '' : $matchBook->book_required,
		"book_quantity"  => empty( $matchBook->book_quantity ) ? '' : $matchBook->book_quantity
	);

	$_SESSION[ 'oldBookValues' ] = $oldValues;

	if( $matchBook ) { //send fields with the values of the selected book
		echo "<tr>";
		echo "<td>Title:</td><td><input type='textbox' name='txtTitle' id='txtTitle' value='" . $matchBook->book_title . "' required='required' /></td>";
		echo "</tr>";
		echo "<tr><td>Edition:</td><td><input type='textbox' name='txtEdition' value='" . $matchBook->book_edition . "'/></td></tr>";
		echo "<tr><td>ISBN:</td><td><input type='textbox' name='txtISBN' value='" . $matchBook->book_isbn . "'/></td></tr>";
		echo "<tr><td>Author(s)</td><td><input type='textbox' name='txtAuthor' value='" . $matchBook->book_author . "'/></td></tr>";
		echo "<tr><td>Publisher(s)</td><td><input type='textbox' name='txtPublisher' value='" . $matchBook->book_publisher . "'/></td></tr>";
		echo "<tr><td>Cover Type</td><td>Hard:<input type='radio' name='CoverType' value='1' ";
		echo ( $matchBook->book_type == 1 ) ? print( 'checked="checked"' ) : '';
		echo "/>Soft:<input type='radio' name='CoverType' value='2' ";
		echo ( $matchBook->book_type == 2 ) ? print( 'checked="checked"' ) : '';
		echo "/>e-Textbook:<input type='radio' name='CoverType' value='3' ";
		echo ( $matchBook->book_type == 3 ) ? print( 'checked="checked"' ) : '';
		echo "/></td></tr>";
		echo "<tr>";
		echo "<td>Recommended: </td><td><input type='radio' name='radioRecommendedRequired' value='0' ";
		echo ( $matchBook->book_required == 0 ) ? print( 'checked="checked"' ) : '';
		echo "</td></tr><tr><td>Required </td><td><input type='radio' name='radioRecommendedRequired' value='1' ";
		echo ( $matchBook->book_required == 1 ) ? print( 'checked="checked"' ) : '';
		echo "/></td></tr><tr><td>Quantity:</td><td><input type='textbox' name='txtQuantity' value='" . $matchBook->book_quantity . "'/></td></tr>";
		echo "<tr><td><input type='submit' name='btnSaveChanges' value='Save Changes'/></td></tr>";
		echo "<tr><td><input type='button' name='btnAddBook' value='Add New Book' onclick=\"showSelectedBook('add-new-book')\" /></td></tr>";
		echo "<tr><td><input type='submit' name='btnRemoveTextbook' value='Remove Textbook From Course' onclick='return confirm(\"Are you sure you want to remove \" + document.getElementById(\"txtTitle\").value+ \"?\"  )'/></td></tr>";

	} elseif( !$matchBook ||  $_REQUEST[ "book_id" ] == 'add-new-book' ) {

		if($_REQUEST[ "book_id" ] != 'add-new-book')
			echo "<tr><td></td><td id='no-book-message' >No book was found with that name...</td></tr>";
		echo "<tr>";
		echo "<tr>";
		echo "<td>Title:</td><td><input type='textbox' name='txtTitle' value='' required='required'/></td>";
		echo "</tr>";
		echo "<tr><td>Edition:</td><td><input type='textbox' name='txtEdition' value=''/></td></tr>";
		echo "<tr><td>ISBN:</td><td><input type='textbox' name='txtISBN' value=''/></td></tr>";
		echo "<tr><td>Author(s)</td><td><input type='textbox' name='txtAuthor' value=''/></td></tr>";
		echo "<tr><td>Publisher(s)</td><td><input type='textbox' name='txtPublisher' value=''/></td></tr>";
		echo "<tr><td>Cover Type</td><td>Hard:<input type='radio' name='CoverType' value='1'>";
		echo "Soft:<input type='radio' name='CoverType' value='2' />";
		echo "e-Textbook:<input type='radio' name='CoverType' value='3' />";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Recommended: </td><td><input type='radio' name='radioRecommendedRequired' value='Recommended' /></td></tr>";
		echo "<tr><td>Required </td><td><input type='radio' name='radioRecommendedRequired' value='Required'/></td></tr><tr>";
		echo "<td>Quantity:</td><td><input type='textbox' name='txtQuantity' value=''/></td></tr>";
		echo "<tr><td><input type='submit' name='btnAddBook' value='Add New Book'/></td></tr>";

	}
}