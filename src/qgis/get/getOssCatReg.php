<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';


$lss_category = '';
if(isset($_POST["query"]))
{
 $lssID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT lsscategory FROM lss
	WHERE lssid = '".$lssID."'
	";

	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	if($row['lsscategory']=='2')
	{
		// $('#offNm').html('<br/><strong>Official Name:</strong><br/>' + data);

		
		// $lsscategory = $row['lsscategory'];
		
		echo "<strong>Region: </strong></br>7";
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