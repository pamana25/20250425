<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';


$lss_official_name = '';
if(isset($_POST["query"]))
{
 $lssID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT lssofficialname FROM lss
	WHERE lssid = '".$lssID."'
	";

	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	if($row['lssofficialname']!='')
	{
		// $('#offNm').html('<br/><strong>Official Name:</strong><br/>' + data);

		
		$lss_official_name = $row['lssofficialname'];
		
		echo "<br/><strong>Official Name: </strong></br>".utf8_decode($lss_official_name)."";
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