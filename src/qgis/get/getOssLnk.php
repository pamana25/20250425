<?php

header('Content-Type: text/html; charset=ISO-8859-1');

error_reporting(0);
include '../../../_db/connection.php';


$userid = $_GET['id'];


if(isset($_POST["query"]))
{
	$lssID = mysqli_real_escape_string($connection, $_POST["query"]);
	$userid = mysqli_real_escape_string($connection, $_POST["query2"]);
 	echo "<a href='lssgallery?lss={$lssID}'>More info...</a>";
}
else
{
	echo "NA";
}

?>