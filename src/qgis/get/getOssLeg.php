<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';



$lss_legislation = '';
if(isset($_POST["query"]))
{
 $lssID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT lsslegislation FROM lss
	WHERE lssid = '".$lssID."'
	";

	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	if($row['lsslegislation']!='')
	{
		// $('#offNm').html('<br/><strong>Official Name:</strong><br/>' + data);

		
		$lss_legislation = $row['lsslegislation'];
		
		echo "<strong>Legislation: </strong></br>".utf8_decode($lss_legislation)."";
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