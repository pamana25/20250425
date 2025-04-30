<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';



$ncp_local_name = '';
if(isset($_POST["query"]))
{
 $ncpID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT ncplocalname FROM ncp
	WHERE ncpid = '".$ncpID."'
	";

	$result = mysqli_query($connection, $query);
	if(mysqli_num_rows($result) > 0)
	{

		$row = mysqli_fetch_assoc($result);
		$ncp_local_name = $row['ncplocalname'];
		
		echo utf8_decode($ncp_local_name);
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