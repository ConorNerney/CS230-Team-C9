<?php

function initDatabase()
{
	$dbconn = pg_connect("host=webcourse.cs.nuim.ie  dbname=cs230 user=cs230teamc9 password=AuDiethe");

	if ($dbconn == null)
	{
		$_SESSION['error'] = "Could not connect to the database.";
		header("Location:error.php");
	}
}


?>