<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';



$lss_year_declared = '';
if(isset($_POST["query"]))
{
 $lssID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT lssyeardeclared FROM lss
	WHERE lssid = '".$lssID."'
	";

	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	if($row['lssyeardeclared']!='')
	{
		// $('#offNm').html('<br/><strong>Official Name:</strong><br/>' + data);

		
		$lss_year_declared = $row['lssyeardeclared'];
		
		echo "<strong>Year Declared: </strong></br>".utf8_decode($lss_year_declared)."";
	}
	// else
	// {
	// 	echo "NA";
	// }
}
else
{
	echo "NA";
}

?>