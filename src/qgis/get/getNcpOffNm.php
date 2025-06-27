<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';


$ncp_official_name = '';
if(isset($_POST["query"]))
{
 $ncpID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT ncpofficialname FROM ncp
	WHERE ncpid = '".$ncpID."'
	";

	$result = mysqli_query($connection, $query);
	if(mysqli_num_rows($result) > 0)
	{

		$row = mysqli_fetch_assoc($result);
		$ncp_official_name = $row['ncpofficialname'];
		
		echo utf8_decode($ncp_official_name);
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