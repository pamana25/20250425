<?php

function pop_msg($msg){ echo "<script>alert('{$msg}')</script>"; }

function get_userid_by_username($con, $username)
{
	$command = "SELECT userid FROM user_login WHERE username='$username'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);

	return $fetch['userid'];
}

function get_email_by_userid($con, $userid)
{
	$command = "SELECT email FROM users WHERE userid='$userid'"; $query = mysqli_query($con, $command); $fetch = mysqli_fetch_assoc($query); return $fetch['email'];
}

function get_firstname_by_userid($con, $userid)
{
	$command = "SELECT firstname FROM users WHERE userid='$userid'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);

	return $fetch['firstname'];
}

function get_propertyname_by_ncp_id($con, $ncp_id)
{
	$command = "SELECT ncpname FROM ncp WHERE ncpid='$ncp_id'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['ncpname'];
}

function get_sitename_by_lss_id($con, $lss_id)
{
	$command = "SELECT lssname FROM lss WHERE lssid='$lss_id'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['lssname'];
}

function count_all_users($con)
{
	$command = "SELECT COUNT(userid) AS countUsers FROM users WHERE usertype='user'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['countUsers'];
}

function count_all_tobereviewed_files_npc($con)
{
	$command = "SELECT COUNT(ncpuploadid) AS countNcpUploads FROM useruploads_ncp WHERE status is NULL OR useruploads_ncp.status='0'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['countNcpUploads'];
}

function count_all_tobereviewed_files_lss($con)
{
	$command = "SELECT COUNT(lssuploadid) AS countLssUploads FROM useruploads_lss WHERE status is NULL OR useruploads_lss.status='0'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['countLssUploads'];
}

function count_all_approved_files_npc($con)
{
	$command = "SELECT COUNT(ncpuploadid) AS countNcpUploads FROM useruploads_ncp WHERE status='1'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['countNcpUploads'];
}

function count_all_approved_files_lss($con)
{
	$command = "SELECT COUNT(lssuploadid) AS countLssUploads FROM useruploads_lss WHERE status='1'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['countLssUploads'];
}

function get_ncp_uploader_userid($con, $ncpuploadid)
{
	$command = "SELECT uploadedby FROM useruploads_ncp WHERE ncpuploadid='$ncpuploadid'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['uploadedby'];
}

function get_lss_uploader_userid($con, $lssuploadid)
{
	$command = "SELECT uploadedby FROM useruploads_lss WHERE lssuploadid='$lssuploadid'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['uploadedby'];
}

function approve_status_ncp($con, $ncpuploadid)
{
	$statusby = get_userid_by_username($con, $_SESSION['username']);
	$statusdate = date('Y-m-d H:i:s');

	$command = "UPDATE useruploads_ncp SET status='1', statusby='$statusby', statusdate='$statusdate'  WHERE ncpuploadid='$ncpuploadid'";
	$query = mysqli_query($con, $command);
	
	return $query;
}

function disapprove_status_ncp($con, $ncpuploadid)
{
	$statusby = get_userid_by_username($con, $_SESSION['username']);
	$statusdate = date('Y-m-d H:i:s');

	$command = "UPDATE useruploads_ncp SET status='2', statusby='$statusby', statusdate='$statusdate'  WHERE ncpuploadid='$ncpuploadid'";
	$query = mysqli_query($con, $command);
	
	return $query;
}
function disapprove_status_ncp_data($con, $ncpid)
{
	$statusby = get_userid_by_username($con, $_SESSION['username']);
	$statusdate = date('Y-m-d H:i:s');

	$command = "UPDATE ncp SET status='2', uploadstatusby ='$statusby', uploadstatusdate ='$statusdate'  WHERE ncpid='$ncpid'";
	$query = mysqli_query($con, $command);
	
	return $query;
}

function approve_status_lss($con, $lssuploadid)
{
	$statusby = get_userid_by_username($con, $_SESSION['username']);
	$statusdate = date('Y-m-d H:i:s');

	$command = "UPDATE useruploads_lss SET status='1', statusby='$statusby', statusdate='$statusdate'  WHERE lssuploadid='$lssuploadid'";
	$query = mysqli_query($con, $command);
	
	return $query;
}

function disapprove_status_lss($con, $lssuploadid)
{
	$statusby = get_userid_by_username($con, $_SESSION['username']);
	$statusdate = date('Y-m-d H:i:s');

	$command = "UPDATE useruploads_lss SET status='2', statusby='$statusby', statusdate='$statusdate'  WHERE lssuploadid='$lssuploadid'";
	$query = mysqli_query($con, $command);
	
	return $query;
}


?>