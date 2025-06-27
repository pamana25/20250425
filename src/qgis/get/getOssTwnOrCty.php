<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';



$lss_town_or_city = '';
if(isset($_POST["query"]))
{
 $lssID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT lsstownorcity FROM lss
	WHERE lssid = '".$lssID."'
	";

	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	if($row['lsstownorcity']!='')
	{
		// $('#offNm').html('<br/><strong>Official Name:</strong><br/>' + data);

		
		$lss_town_or_city = $row['lsstownorcity'];
		
		echo "<strong>Town/City: </strong></br>".utf8_decode($lss_town_or_city)."";
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