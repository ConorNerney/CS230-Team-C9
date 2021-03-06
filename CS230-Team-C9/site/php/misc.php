<?php
/*
* Clears the user backet.
*/
function clearBasket()
{
	session_unset();
	session_destroy(); 
}

/*
* Calls the error page with a specific message.
*/
function reportError($msg)
{
		$_SESSION['error'] = $msg;
		header("Location:error.php");
}

/*
* Initialises the database, going to the error page upon failure.
*/
function initDatabase()
{
	$dbconn = pg_connect("host=webcourse.cs.nuim.ie  dbname=cs230 user=cs230teamc9 password=AuDiethe");

	if ($dbconn == null)
		reportError("Could not connect to the database.");
}

/*
* Returns an SQL query as an array of rows. Each row is an array of entries.
* Goes to the error page if the query is invalid.
* Returns null if there is no result.
*/
function makeQuery($query)
{
	$qresult = pg_query($query);
	if($qresult == null)
		reportError("Could not perform SQL query: " . $query);
	if($qresult == null)
		return null; //no result

	return pg_fetch_all($qresult);
}

function populateSearchEntryHtml($sqlRow, $searchEntryHtml)
{
	$searchEntryHtml = str_replace(
		array("<!--INST_SR_NAME-->", "<!--INST_SR_IMGSRC-->", "<!--INST_SR_AUTHOR-->","<!--INST_SR_DESCRIPTION-->",
			"<!--INST_SR_PRICE-->","<!--INST_SR_AVAILABLE-->", "<!--INST_SR_ID-->"),
		array($sqlRow['title'], $sqlRow['imgs'], $sqlRow['author'], $sqlRow['description1'], $sqlRow['price'], $sqlRow['stock'], $sqlRow['id']),
		$searchEntryHtml);

	return $searchEntryHtml;
}


function populateBookHtml($bookRow, $bookhtml)
{
	return str_replace(
			array("<!--INST_B_TITLE-->", "<!--INST_B_QUANTITY-->", "<!--INST_B_AUTHOR-->", "<!--INST_B_PRICE-->", "<!--INST_B_DESCRIPTION-->", "<!--INST_B_IMAGE-->"),
			array($bookRow['title'], $bookRow['stock'], $bookRow['author'], $bookRow['price'], $bookRow['description1'], $bookRow['imgs']),
			$bookhtml);
	
	
	return $searchEntryHtml;
}

/*
* if a purchase was made in the book page, it is handled here.
*/
function handleBookPurchase($bookRow, $bookhtml)
{
	//Check if the user added the item to the cart.
	if(isset($_POST['quantity']))
	{
		if(!isset($_SESSION['basket']))
		{
			$_SESSION['basket'] = new Basket();
		}
		
		$_SESSION['basket']->addItem($bookRow['id'], $_POST['quantity']);

		$bookhtml = str_replace("<!--INST_ORDER_CONFIRMATION_MESSAGE-->",
			file_get_contents("content/bookpurchaseconfirmation.html", true), $bookhtml);
		$_POST = array();
	}

	return $bookhtml;
}




?>