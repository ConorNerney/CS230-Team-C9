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


?>