<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';



$lss_classification_status = '';
if(isset($_POST["query"]))
{
 $lssID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT lssclassificationstatus FROM lss
	WHERE lssid = '".$lssID."'
	";

	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	if($row['lssclassificationstatus']!='')
	{
		// $('#offNm').html('<br/><strong>Official Name:</strong><br/>' + data);

		
		$lss_classification_status = $row['lssclassificationstatus'];
		
		echo "<strong>Classification Status: </strong></br>".utf8_decode($lss_classification_status)."";
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