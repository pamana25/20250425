<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';



$ncp_year_declared = '';
if(isset($_POST["query"]))
{
 $ncpID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT ncpyeardeclared FROM ncp
	WHERE ncpid = '".$ncpID."'
	";

	$result = mysqli_query($connection, $query);
	if(mysqli_num_rows($result) > 0)
	{
		$row = mysqli_fetch_assoc($result);
		if( $row['ncpyeardeclared']!=''){

			$ncp_year_declared = $row['ncpyeardeclared'];
			
			echo utf8_decode($ncp_year_declared);
		}else{
			echo "NA";
		}
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