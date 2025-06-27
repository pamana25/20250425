<?php
header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';


$ncp_classification_status = '';
if(isset($_POST["query"]))
{
 $ncpID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT ncpclassificationstatus FROM ncp
	WHERE ncpid = '".$ncpID."'
	";

	$result = mysqli_query($connection, $query);
	if(mysqli_num_rows($result) > 0)
	{

		$row = mysqli_fetch_assoc($result);
		$ncp_classification_status = $row['ncpclassificationstatus'];
		
		echo utf8_decode($ncp_classification_status);
	}
	else
	{
		echo "NA";
	}
}
else
{
	echo "NA";
}

?>