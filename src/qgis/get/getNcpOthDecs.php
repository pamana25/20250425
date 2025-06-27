<?php

header('Content-Type: text/html; charset=ISO-8859-1');

include '../../../_db/connection.php';



$ncp_other_declarations = '';
if(isset($_POST["query"]))
{
 $ncpID = mysqli_real_escape_string($connection, $_POST["query"]);

	$query = "
	SELECT ncpotherdeclarations FROM ncp
	WHERE ncpid = '".$ncpID."'
	";

	$result = mysqli_query($connection, $query);
	if(mysqli_num_rows($result) > 0)
	{

		$row = mysqli_fetch_assoc($result);

		if( $row['ncpotherdeclarations']!=''){

			$ncp_other_declarations = $row['ncpotherdeclarations'];
		
			echo utf8_decode($ncp_other_declarations);
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