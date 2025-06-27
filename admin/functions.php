<?php
include 'includes/security.php';
include 'includes/connection.php';
include 'includes/functions.php';
include 'includes/xlsxwriter.class.php';
define('SALT', 'd#f453dd');

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: PUT, DELETE"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");
include '../library/phpmailer/send.php';
$Mailer = new Mailer();
// sign up code
if (isset($_POST['sign_up'])) {

    $firstname = mysqli_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_escape_string($con, $_POST['lastname']);
    $username = mysqli_escape_string($con, $_POST['username']);
    $email = mysqli_escape_string($con, $_POST['email']);
    $password = mysqli_escape_string($con, $_POST['password']);
    $cpassword = mysqli_escape_string($con, $_POST['cpassword']);
    $usertype = mysqli_escape_string($con, $_POST['usertype']);

    // check username exist
    $query_u = "SELECT username FROM users WHERE username = '$username'";
    $query_run_u = mysqli_query($con, $query_u);

    if (mysqli_num_rows($query_run_u) > 0) {
        $_SESSION['message'] = "Username already exist.";
        header("location: sign_up.php");
    } else {
        // check email exist
        $query_a = "SELECT email FROM users WHERE email = '$email'";
        $query_run_a = mysqli_query($con, $query_a);

        if (mysqli_num_rows($query_run_a) > 0) {
            $_SESSION['message'] = "Email already exists.";
            header("location: sign_up.php");
            exit(0);
        } else {
            // check match password
            if ($password == $cpassword) {

                $query = "INSERT INTO `users`(`firstname`, `lastname`, `username`, `email`, `password`, `usertype`) VALUES ('$firstname','$lastname','$username','$email','$password','$usertype')";
                $query_run = mysqli_query($con, $query);

                if ($query_run) {
                    $_SESSION['message'] = "Registration Completed!";
                    header("location: sign_up.php");
                    exit(0);
                }
            } else {
                $_SESSION['message'] = "passwords do not match!";
                header("location: sign_up.php");
                exit(0);
            }
        }
    }
}


// delete user data
if (isset($_POST['delete_user'])) {

    $user_id = mysqli_escape_string($con, $_POST['delete_user']);

    $query = "UPDATE `users` SET deleted='1' WHERE userid='$user_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {

        $_SESSION['message'] = "User Deleted Successfuly.";
        header("location: tables.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to delete the user.";
        header("location: tables.php");
        exit(0);
    }
}


// update user data
if (isset($_POST['update_user'])) {

    $user_id = mysqli_real_escape_string($con, $_POST['id']);
    $firstname = mysqli_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_escape_string($con, $_POST['lastname']);
    $username = mysqli_escape_string($con, $_POST['username']);
    $email = mysqli_escape_string($con, $_POST['email']);
    $password = mysqli_escape_string($con, $_POST['password']);
    $usertype = mysqli_escape_string($con, $_POST['usertype']);

    // check username exist
    $query_u = "SELECT username FROM user_login WHERE username = '$username' AND userid!='$user_id'";
    $query_run_u = mysqli_query($con, $query_u);

    if (mysqli_num_rows($query_run_u) > 0) {
        $_SESSION['message'] = "Username already exist.";
        header("location: update_user.php?id=$user_id");
    } else {
        // check email exist
        $query_a = "SELECT email FROM users WHERE email = '$email' AND userid!='$user_id'";
        $query_run_a = mysqli_query($con, $query_a);

        if (mysqli_num_rows($query_run_a) > 0) {
            $_SESSION['message'] = "Email already exists.";
            header("location: update_user.php?id=$user_id");
            exit(0);
        } else {




            $query = "UPDATE `users` SET `firstname`='$firstname',`lastname`='$lastname',`email`='$email',`usertype`='$usertype' WHERE userid='$user_id'";
            $query_run = mysqli_query($con, $query);

            if ($query_run) {
                $encpass = md5(SALT . $password);
                $query_b = "UPDATE `user_login` SET `username`='$username' WHERE userid='$user_id'";
                $query_run_b = mysqli_query($con, $query_b);

                if ($query_run) {
                    $_SESSION['message'] = "User Data Updated Successfuly.";
                    header("location: update_user.php?id=$user_id");
                    exit(0);
                } else {
                    $_SESSION['message'] = "Failed to update the user.";
                    header("location: update_user.php?id=$user_id");
                    exit(0);
                }
            } else {
                $_SESSION['message'] = "Failed to update the user.";
                header("location: update_user.php?id=$user_id");
                exit(0);
            }
        }
    }
}

// update ncp data
if (isset($_POST['update_ncp'])) {

    $ncp_id = mysqli_real_escape_string($con, $_POST['ncpid']);
    $ncpname = mysqli_escape_string($con, $_POST['ncpname']);
    $ncpofficialname = mysqli_escape_string($con, $_POST['ncpofficialname']);
    $ncpfilipinoname = mysqli_escape_string($con, $_POST['ncpfilipinoname']);
    $ncplocalname = mysqli_escape_string($con, $_POST['ncplocalname']);
    $ncpclassificationstatus = mysqli_escape_string($con, $_POST['ncpclassificationstatus']);
    $ncptownorcity = mysqli_escape_string($con, $_POST['ncptownorcity']);
    $ncpyeardeclared = mysqli_escape_string($con, $_POST['ncpyeardeclared']);
    $ncpotherdeclarations = mysqli_escape_string($con, $_POST['ncpotherdeclarations']);
    $ncpdescription = mysqli_escape_string($con, $_POST['ncpdescription']);
    $ncpsourceA = isset($_POST['ncpsourceA'])  ? mysqli_real_escape_string($con, $_POST['ncpsourceA']) : '';
    $ncpsourceB = isset($_POST['ncpsourceB'])  ? mysqli_real_escape_string($con, $_POST['ncpsourceB']) : '';
    $ncpsource_id = $_POST['ncpsource_id'];
    $ncpsource = $_POST['ncpsource'];

    $latitude = mysqli_real_escape_string($con, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($con, $_POST['longitude']);
    $map_classification = mysqli_real_escape_string($con, $_POST['map_classification']);
    
    $query = "UPDATE `ncp` SET `ncpname`='$ncpname', `ncpofficialname`='$ncpofficialname', `ncpfilipinoname`='$ncpfilipinoname', `ncplocalname`='$ncplocalname', `ncpclassificationstatus`='$ncpclassificationstatus', `ncptownorcity`='$ncptownorcity', `ncpyeardeclared`='$ncpyeardeclared', `ncpotherdeclarations`='$ncpotherdeclarations', `ncpdescription`='$ncpdescription', `ncpsourceA`='$ncpsourceA', `ncpsourceB`='$ncpsourceB', `latitude`='$latitude', `longitude`='$longitude', `map_classification`='$map_classification' WHERE ncpid='$ncp_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $count = count($ncpsource);

        for($i =0; $i < $count; $i++)
        {
            $final_ncpsource = mysqli_real_escape_string($con, $ncpsource[$i]);
            $ncpsourceid = mysqli_real_escape_string($con, $ncpsource_id[$i]);

            if($final_ncpsource !='' || $final_ncpsource != null)
            {
                $cmd = "UPDATE `ncp_sourceurl` SET `sourcelink`='$final_ncpsource' WHERE id = '$ncpsourceid'";
            }
            else
            {
                $cmd = "DELETE FROM `ncp_sourceurl` WHERE id = '$ncpsourceid'";
            }

            $cmd_query = mysqli_query($con, $cmd);

            if(!$cmd_query)
            {
                $_SESSION['message'] = "Failed to update data.";
                header("location: update_ncp.php?id=$ncp_id");
                exit(0);
            }
        }

        $_SESSION['message'] = "The Data is Updated.";
        header("location: update_ncp.php?id=$ncp_id");
        exit(0);
    }
}

// update lss data
if (isset($_POST['update_lss'])) {

    $lss_id = mysqli_real_escape_string($con, $_POST['lssid']);
    $lssname = mysqli_escape_string($con, $_POST['lssname']);
    $lssofficialname = mysqli_escape_string($con, $_POST['lssofficialname']);
    $lssfilipinoname = mysqli_escape_string($con, $_POST['lssfilipinoname']);
    $lsslocalname = mysqli_escape_string($con, $_POST['lsslocalname']);
    $lssclassificationstatus = mysqli_escape_string($con, $_POST['lssclassificationstatus']);
    $lsstownorcity = mysqli_escape_string($con, $_POST['lsstownorcity']);
    $lssyeardeclared = mysqli_escape_string($con, $_POST['lssyeardeclared']);
    $lssotherdeclarations = mysqli_escape_string($con, $_POST['lssotherdeclarations']);
    $lssdescription = mysqli_escape_string($con, $_POST['lssdescription']);
    $lsslegislation = mysqli_escape_string($con, $_POST['lsslegislation']);
    $lsssource = $_POST['lsssource'];
    $lsssource_id = $_POST['lsssource_id'];
    $lsssourceA = isset($_POST['lsssourceA'])  ? mysqli_real_escape_string($con, $_POST['lsssourceA']) : '';
    $lsssourceB = isset($_POST['lsssourceB'])  ? mysqli_real_escape_string($con, $_POST['lsssourceB']) : '';

    $latitude = mysqli_real_escape_string($con, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($con, $_POST['longitude']);
    $map_classification = mysqli_real_escape_string($con, $_POST['map_classification']);

    $query = "UPDATE `lss` SET `lssname`='$lssname', `lssofficialname`='$lssofficialname', `lssfilipinoname`='$lssfilipinoname', `lsslocalname`='$lsslocalname', `lssclassificationstatus`='$lssclassificationstatus', `lsstownorcity`='$lsstownorcity', `lssyeardeclared`='$lssyeardeclared', `lssotherdeclarations`='$lssotherdeclarations', `lssdescription`='$lssdescription', `lsslegislation`='$lsslegislation', `lsssource`='$lsssourceA', `lsssourceB`='$lsssourceB',`latitude`='$latitude', `longitude`='$longitude', `map_classification`='$map_classification' WHERE lssid='$lss_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
       
        $count = count($lsssource);

        for($i = 0; $i < $count; $i++)
        {
            $final_lsssource = mysqli_real_escape_string($con, $lsssource[$i]);
            $lsssourceid = mysqli_real_escape_string($con, $lsssource_id[$i]);

            if($final_lsssource !='' || $final_lsssource != null)
            {
                $sql = "UPDATE `lss_sourceurl` SET `sourcelink`='$final_lsssource' WHERE id = '$lsssourceid'";
            }
            else
            {
                $sql = "DELETE FROM `lss_sourceurl` WHERE id = '$lsssourceid'";
            }
            
            $sql_run = mysqli_query($con,$sql);

            
            if(!$sql_run)
            {
                $_SESSION['message'] = "Failed to update data.";
                header("location: update_lss.php?id=$lss_id");
                exit(0);
            }


        }
        $_SESSION['message'] = "The Data is Updated.";
        header("location: update_lss.php?id=$lss_id");
        exit(0);

        
    }

    
}


//sign_in
if (isset($_POST['sign_in'])) {

    $username = mysqli_escape_string($con, $_POST['username']);
    $password = mysqli_escape_string($con, $_POST['password']);

    // The admin has a userid of 1 - FVT --- CONTNUEEEEE
    $query = "SELECT users.*, user_login.* FROM users INNER JOIN user_login ON user_login.userid = users.userid WHERE user_login.username = '$username' AND users.usertype='admin'";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $users);
        $db_password = $users['password'];

        if (md5(SALT . $password) == $db_password || password_verify($password, $db_password)) {
            $username = $users['username'];
            if ($users['usertype'] == 'admin') {
                $_SESSION['username'] = $username;
                header("location: index.php");
                exit(0);
            }

        } else {
            $_SESSION['status'] = "Wrong password!";
            header("location: sign_in.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Username does not exist!";
        header("location: sign_in.php");
        exit(0);
    }
}


//logout_user
if (isset($_POST['logout_user'])) {
    session_destroy();
    unset($_SESSION['email']);
    unset($_SESSION['name']);
    header("location: sign_in.php");
}


function registredMemberCount($con)
{
    $query = "SELECT COUNT(id) FROM users";
    $query_run = mysqli_query($con, $query);
    $rows = mysqli_fetch_assoc($query_run);
    return $rows[0];
}


//excell export
if (isset($_POST['file_export'])) {


    $filename = 'userdata' . date('Ymd') . ".xlsx";
    header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    $query = "SELECT * FROM users";
    $query_run = mysqli_query($con, $query);
    $rows = mysqli_fetch_assoc($query_run);
    $header = array(
        'ID' => 'integer',
        'First Name' => 'string',
        'Last Name' => 'string',
        'Username' => 'string',
        'Email' => 'string',
        'Password' => 'string',
        'Usertype' => 'string',
    );
    $writer = new XLSXWriter();
    $writer->writeSheetHeader('Sheet1', $header);
    $array = array();

    while ($row = mysqli_fetch_row($query_run)) {
        for ($i = 0; $i < mysqli_num_fields($query_run); $i++) {
            $array[$i] = $row[$i];
            //$array[$i] = strip_tag($row[$i],"<p> <b> <br> <a> <img>");
        }
        $writer->writeSheetRow('Sheet1', $array);
    };


    $writer->writeToStdOut();

    exit(0);
}

// APPROVE NCP
if (isset($_POST['ncprequest_approve'])) {
    $ncpuploadid = $_POST['ncprequest_approve'];
    $fileStatus = 'APPROVED';

    $uploadedby = get_ncp_uploader_userid($con, $ncpuploadid);
    $recipientEmail = get_email_by_userid($con, $uploadedby);
    $recipientFirstName = get_firstname_by_userid($con, $uploadedby);

    if (approve_status_ncp($con, $ncpuploadid)) {
        $_SESSION['message'] = "Request approved!";
        header("location: requestncp.php");
        exit(0);
    }
}

//to get user uploader id from ncp
function get_ncpdata_uploader_userid($con,$ncpid)
{
    $command = "SELECT uploadedbyuser FROM ncp WHERE ncpid='$ncpid'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['uploadedbyuser'];
}

//to get user uploader id from lss
function get_lssdata_uploader_userid($con,$lssid)
{
    $command = "SELECT uploadedbyuser FROM lss WHERE lssid='$lssid'";
	$query = mysqli_query($con, $command);
	$fetch = mysqli_fetch_assoc($query);
	
	return $fetch['uploadedbyuser'];
}

// to approve user request in ncp
if(isset($_GET['ncp_approve_id']))
{
    $ncpid = $_GET['ncp_approve_id'];
    $update_status = 'APPROVED';
    $approved_by = $_SESSION['username'];

    $user_uploadedid = get_ncpdata_uploader_userid($con, $ncpid);
    $recipientEmail = get_email_by_userid($con, $user_uploadedid);
    $recipientFirstName = get_firstname_by_userid($con, $user_uploadedid);
    

    $sql = "SELECT userid FROM `user_login` WHERE username = '$approved_by'";
    $result = mysqli_query($con, $sql);

    $fetch_approved_by = mysqli_fetch_assoc($result);
    $final_approved_by = $fetch_approved_by['userid'];
 
    $query = "UPDATE `ncp` SET `uploadstatus` =1 ,`uploadstatusby` = '$final_approved_by', `uploadstatusdate` = NOW() WHERE ncpid= '$ncpid'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $Mailer->send_filestatusnotif_email_to_user($recipientEmail, $recipientFirstName, $update_status);
        $_SESSION['message'] = "Request approved!";
        header("location: ncpdatarequest.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Failed to approved.";
    }

}
//to approve user request in lss
if(isset($_GET['lssdata_approve_btn']))
{
    $lssid = $_GET['lssdata_approve_btn'];
    $update_status = 'APPROVED';
    $approved_by = $_SESSION['username'];

    $user_uploadedid = get_lssdata_uploader_userid($con, $lssid);
    $recipientEmail = get_email_by_userid($con, $user_uploadedid);
    $recipientFirstName = get_firstname_by_userid($con, $user_uploadedid);

    $sql = "SELECT userid FROM `user_login` WHERE username = '$approved_by'";
    $result = mysqli_query($con, $sql);

    $fetch_approved_by = mysqli_fetch_assoc($result);
    $final_approved_by = $fetch_approved_by['userid'];
 
    $query = "UPDATE `lss` SET `uploadstatus` =1 ,`uploadstatusby` = '$final_approved_by', `uploadstatusdate` = NOW() WHERE lssid= '$lssid'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $Mailer->send_filestatusnotif_email_to_user($recipientEmail, $recipientFirstName, $update_status);
        $_SESSION['message'] = "Request approved!";
        header("location: lssdatarequest.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Failed to approved request.";
    }
   
}



if (isset($_POST['send_ncp_dissaprove_email'])) {
    $email_value = $_POST['email_value'];
   
    $ncpuploadid = $_POST['send_ncp_dissaprove_email'];
    $fileStatus = 'DISAPPROVED';
    if ($email_value == '1') {
        $email_subject = "Content Unusable";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we value your contribution, it appears that the image you recently submitted to Pamana.org cannot be used due to technical issues. It appears that the file is corrupted or otherwise inaccessible, preventing us from incorporating it into our database.";
        $email_body3 = "We understand that this may be disappointing, and we apologize for any inconvenience caused. If you require any assistance or have further questions, please don't hesitate to reach out to us. We're here to help in any way we can.";
        $email_body4 = "Alternatively, if you have any other content you'd like to share, please feel free to do so.";
        $email_body5 = '';
    } else if ($email_value == '2') {
        $email_subject = "Content Does Not Match";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we appreciate your contribution, it appears that the image you uploaded does not match the designated Category and Property.";
        $email_body3 = "We understand that errors can happen. If you're unsure about the appropriate Category and Property, feel free to reach out to us for clarification, and we'll be more than happy to assist you.";
        $email_body4 = "Your cooperation in resolving this matter is greatly appreciated as it helps us maintain the quality and accuracy of our content. Thank you for being part of our community!";
        $email_body5 = '';
    } else if ($email_value == '3') {
        $email_subject = "For Further Action";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! Your input truly enriches our platform and greatly helps us with our cause.";
        $email_body2 = "To ensure proper attribution and recognition of the content you've submitted, we kindly ask for some additional details. If you're the creator or owner of the content, kindly tell us the date it was taken and any other relevant information, like if it was captured for an article or publication. This helps us showcase your work accurately.";
        $email_body3 = "If the content was sourced online, please provide us with the full link where it was originally found, along with the name of the image owner and the date it was posted. This way, we can credit the rightful creators and maintain transparency.";
        $email_body4 = "For materials sourced from printed publications such as books or magazines, sharing details like the book's title, author, and publication date would be immensely helpful. It allows us to acknowledge the source properly and uphold copyright integrity.";
        $email_body5 = "Your assistance in providing these details ensures that our platform continues to respect intellectual property rights while celebrating the vibrant heritage of Cebu. Thank you for your cooperation and for being part of our community!";
    } else if ($email_value == '4') {
        $email_value_other = $_POST['email_value_other'];
        $email_subject = "Further Action Required";
    } else {
        echo 'failed to fetch values';
    }

    $uploadedby = get_ncp_uploader_userid($con, $ncpuploadid);
    $recipientEmail = get_email_by_userid($con, $uploadedby);
    $recipientFirstName = get_firstname_by_userid($con, $uploadedby);

    if (disapprove_status_ncp($con, $ncpuploadid)) {
        $Mailer->send_disapprove_email_to_user($recipientEmail, $recipientFirstName, $email_subject, $email_body1, $email_body2, $email_body3, $email_body4, $email_body5, $email_value_other);
        $_SESSION['message'] = "Request disapproved!";
        header("location: requestncp.php");
        exit(0);
    }
}


//disapprove ncp email data
if(isset($_POST['send_ncp_data_disapprove_email']))
{
    $email_value = $_POST['email_value'];
   
    $ncpid = $_POST['send_ncp_data_disapprove_email'];
    $fileStatus = 'DISAPPROVED';
    if ($email_value == '1') {
        $email_subject = "Content Unusable";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we value your contribution, it appears that the image you recently submitted to Pamana.org cannot be used due to technical issues. It appears that the file is corrupted or otherwise inaccessible, preventing us from incorporating it into our database.";
        $email_body3 = "We understand that this may be disappointing, and we apologize for any inconvenience caused. If you require any assistance or have further questions, please don't hesitate to reach out to us. We're here to help in any way we can.";
        $email_body4 = "Alternatively, if you have any other content you'd like to share, please feel free to do so.";
        $email_body5 = '';
    } else if ($email_value == '2') {
        $email_subject = "Content Does Not Match";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we appreciate your contribution, it appears that the image you uploaded does not match the designated Category and Property.";
        $email_body3 = "We understand that errors can happen. If you're unsure about the appropriate Category and Property, feel free to reach out to us for clarification, and we'll be more than happy to assist you.";
        $email_body4 = "Your cooperation in resolving this matter is greatly appreciated as it helps us maintain the quality and accuracy of our content. Thank you for being part of our community!";
        $email_body5 = '';
    } else if ($email_value == '3') {
        $email_subject = "For Further Action";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! Your input truly enriches our platform and greatly helps us with our cause.";
        $email_body2 = "To ensure proper attribution and recognition of the content you've submitted, we kindly ask for some additional details. If you're the creator or owner of the content, kindly tell us the date it was taken and any other relevant information, like if it was captured for an article or publication. This helps us showcase your work accurately.";
        $email_body3 = "If the content was sourced online, please provide us with the full link where it was originally found, along with the name of the image owner and the date it was posted. This way, we can credit the rightful creators and maintain transparency.";
        $email_body4 = "For materials sourced from printed publications such as books or magazines, sharing details like the book's title, author, and publication date would be immensely helpful. It allows us to acknowledge the source properly and uphold copyright integrity.";
        $email_body5 = "Your assistance in providing these details ensures that our platform continues to respect intellectual property rights while celebrating the vibrant heritage of Cebu. Thank you for your cooperation and for being part of our community!";
    } else if ($email_value == '4') {
        $email_value_other = $_POST['email_value_other'];
        $email_subject = "Further Action Required";
    } else {
        echo 'failed to fetch values';
    }

   
    $update_status = 'APPROVED';
    $statusby = $_SESSION['username'];

    $user_uploadedid = get_ncpdata_uploader_userid($con, $ncpid);
    $recipientEmail = get_email_by_userid($con, $user_uploadedid);
    $recipientFirstName = get_firstname_by_userid($con, $user_uploadedid);
    

    $sql = "SELECT userid FROM `user_login` WHERE username = '$statusby'";
    $result = mysqli_query($con, $sql);

    $fetch_status_by = mysqli_fetch_assoc($result);
    $final_status_by = $fetch_status_by['userid'];
 
    $query = "UPDATE `ncp` SET `uploadstatus` =2 ,`uploadstatusby` = '$final_status_by', `uploadstatusdate` = NOW() WHERE ncpid= '$ncpid'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $Mailer->send_disapprove_email_to_user($recipientEmail, $recipientFirstName, $email_subject, $email_body1, $email_body2, $email_body3, $email_body4, $email_body5, $email_value_other);
        $_SESSION['message'] = "Request disapproved!";
        header("location: ncpdatarequest.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Failed to disapproved.";
    }

   
}

// to disapprove user request from lssData
if(isset($_POST['lssdata_disapprove_btn']))
{
    $email_value = $_POST['email_value'];

    $lssid = $_POST['lssdata_disapprove_btn'];

    $fileStatus = 'DISAPPROVED';
    if ($email_value == '1') {
        $email_subject = "Content Unusable";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we value your contribution, it appears that the image you recently submitted to Pamana.org cannot be used due to technical issues. It appears that the file is corrupted or otherwise inaccessible, preventing us from incorporating it into our database.";
        $email_body3 = "We understand that this may be disappointing, and we apologize for any inconvenience caused. If you require any assistance or have further questions, please don't hesitate to reach out to us. We're here to help in any way we can.";
        $email_body4 = "Alternatively, if you have any other content you'd like to share, please feel free to do so.";
        $email_body5 = '';
    } else if ($email_value == '2') {
        $email_subject = "Content Does Not Match";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we appreciate your contribution, it appears that the image you uploaded does not match the designated Category and Property.";
        $email_body3 = "We understand that errors can happen. If you're unsure about the appropriate Category and Property, feel free to reach out to us for clarification, and we'll be more than happy to assist you.";
        $email_body4 = "Your cooperation in resolving this matter is greatly appreciated as it helps us maintain the quality and accuracy of our content. Thank you for being part of our community!";
        $email_body5 = '';
    } else if ($email_value == '3') {
        $email_subject = "For Further Action";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! Your input truly enriches our platform and greatly helps us with our cause.";
        $email_body2 = "To ensure proper attribution and recognition of the content you've submitted, we kindly ask for some additional details. If you're the creator or owner of the content, kindly tell us the date it was taken and any other relevant information, like if it was captured for an article or publication. This helps us showcase your work accurately.";
        $email_body3 = "If the content was sourced online, please provide us with the full link where it was originally found, along with the name of the image owner and the date it was posted. This way, we can credit the rightful creators and maintain transparency.";
        $email_body4 = "For materials sourced from printed publications such as books or magazines, sharing details like the book's title, author, and publication date would be immensely helpful. It allows us to acknowledge the source properly and uphold copyright integrity.";
        $email_body5 = "Your assistance in providing these details ensures that our platform continues to respect intellectual property rights while celebrating the vibrant heritage of Cebu. Thank you for your cooperation and for being part of our community!";
    } else if ($email_value == '4') {
        $email_value_other = $_POST['email_value_other'];
        $email_subject = "Further Action Required";
    } else {
        echo 'failed to fetch values';
    }

   
    // $update_status = 'APPROVED';
    $statusby = $_SESSION['username'];

    $user_uploadedid = get_lssdata_uploader_userid($con, $lssid);
    $recipientEmail = get_email_by_userid($con, $user_uploadedid);
    $recipientFirstName = get_firstname_by_userid($con, $user_uploadedid);
    

    $sql = "SELECT userid FROM `user_login` WHERE username = '$statusby'";
    $result = mysqli_query($con, $sql);

    $fetch_status_by = mysqli_fetch_assoc($result);
    $final_status_by = $fetch_status_by['userid'];
 
    $query = "UPDATE `lss` SET `uploadstatus` =2 ,`uploadstatusby` = '$final_status_by', `uploadstatusdate` = NOW() WHERE lssid= '$lssid'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $Mailer->send_disapprove_email_to_user($recipientEmail, $recipientFirstName, $email_subject, $email_body1, $email_body2, $email_body3, $email_body4, $email_body5, $email_value_other);
        $_SESSION['message'] = "Request disapproved!";
        header("location: lssdatarequest.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Failed to disapproved request.";
    }

    
}

// APPROVE LSS
if (isset($_POST['lssrequest_approve'])) {
    $lssuploadid = $_POST['lssrequest_approve'];
    $fileStatus = 'APPROVED';

    $uploadedby = get_lss_uploader_userid($con, $lssuploadid);
    $recipientEmail = get_email_by_userid($con, $uploadedby);
    $recipientFirstName = get_firstname_by_userid($con, $uploadedby);

    if (approve_status_lss($con, $lssuploadid)) {
        // send_filestatusnotif_email_to_user($senderHost, $senderEmail, $senderName, $recipientEmail, $recipientFirstName, $fileStatus);
        $_SESSION['message'] = "Request approved!";
        header("location: requestlss.php");
        exit(0);
    }
}



if (isset($_POST['send_lss_dissaprove_email'])) {
    $email_value = $_POST['email_value'];
    $lssuploadid = $_POST['send_lss_dissaprove_email'];
    $fileStatus = 'DISAPPROVED';

    if ($email_value == '1') {
        $email_subject = "Content Unusable";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we value your contribution, it appears that the image you recently submitted to Pamana.org cannot be used due to technical issues. It appears that the file is corrupted or otherwise inaccessible, preventing us from incorporating it into our database.";
        $email_body3 = "We understand that this may be disappointing, and we apologize for any inconvenience caused. If you require any assistance or have further questions, please don't hesitate to reach out to us. We're here to help in any way we can.";
        $email_body4 = "Alternatively, if you have any other content you'd like to share, please feel free to do so.";
        $email_body5 = '';
    } else if ($email_value == '2') {
        $email_subject = "Content Does Not Match";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we appreciate your contribution, it appears that the image you uploaded does not match the designated Category and Property.";
        $email_body3 = "We understand that errors can happen. If you're unsure about the appropriate Category and Property, feel free to reach out to us for clarification, and we'll be more than happy to assist you.";
        $email_body4 = "Your cooperation in resolving this matter is greatly appreciated as it helps us maintain the quality and accuracy of our content. Thank you for being part of our community!";
        $email_body5 = '';
    } else if ($email_value == '3') {
        $email_subject = "For Further Action";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! Your input truly enriches our platform and greatly helps us with our cause.";
        $email_body2 = "To ensure proper attribution and recognition of the content you've submitted, we kindly ask for some additional details. If you're the creator or owner of the content, kindly tell us the date it was taken and any other relevant information, like if it was captured for an article or publication. This helps us showcase your work accurately.";
        $email_body3 = "If the content was sourced online, please provide us with the full link where it was originally found, along with the name of the image owner and the date it was posted. This way, we can credit the rightful creators and maintain transparency.";
        $email_body4 = "For materials sourced from printed publications such as books or magazines, sharing details like the book's title, author, and publication date would be immensely helpful. It allows us to acknowledge the source properly and uphold copyright integrity.";
        $email_body5 = "Your assistance in providing these details ensures that our platform continues to respect intellectual property rights while celebrating the vibrant heritage of Cebu. Thank you for your cooperation and for being part of our community!";
    } else {
        echo 'failed to fetch values';
    }

    $uploadedby = get_lss_uploader_userid($con, $lssuploadid);
    $recipientEmail = get_email_by_userid($con, $uploadedby);
    $recipientFirstName = get_firstname_by_userid($con, $uploadedby);

    if (disapprove_status_lss($con, $lssuploadid)) {
        $Mailer->send_disapprove_email_to_user( $recipientEmail, $recipientFirstName, $email_subject, $email_body1, $email_body2, $email_body3, $email_body4, $email_body5, $email_value_other);
        $_SESSION['message'] = "Request disapproved!";
        header("location: requestlss.php");
        exit(0);
    }
}

//UPDATE UPLOADED LSS USER DATA's
if (isset($_POST['update_uploaded_lss'])) {

    $lssuploadid = mysqli_real_escape_string($con, $_POST['lssuploadid']);
    $description = mysqli_escape_string($con, $_POST['description']);
    $source_name = mysqli_escape_string($con, $_POST['source_name']);
    $date_taken = isset($_POST['date_taken']) && !empty($_POST['date_taken']) ? mysqli_escape_string($con, date('M d,Y', strtotime($_POST['date_taken']))) : null;
    $source_link = mysqli_escape_string($con, $_POST['source_link']);

   

    $query = "UPDATE useruploads_lss
    INNER JOIN useruploadfiles_lss
    ON useruploads_lss.lssuploadid = useruploadfiles_lss.lssuploadid 
    SET useruploads_lss.description = '$description', useruploads_lss.source_name = '$source_name',
        useruploads_lss.date_taken = '$date_taken', useruploads_lss.source = '$source_link'
            WHERE useruploads_lss.lssuploadid = '$lssuploadid'";
    $query_run = mysqli_query($con, $query);

    $_SESSION['message'] = "The Data is Updated.";
    header("location: manage_uploaded_lss.php?id=$lssuploadid");
    exit(0);
}

//DELETE UPLOADED LSS USER DATA's
if (isset($_POST['delete_uploaded_lss'])) {
    $pageUrl = mysqli_escape_string($con, $_POST['page']);
    $lssuploadid = mysqli_real_escape_string($con, $_POST['lssuploadid']);
    $query = "DELETE useruploads_lss, useruploadfiles_lss
    FROM useruploads_lss
    JOIN useruploadfiles_lss
    ON useruploads_lss.lssuploadid = useruploadfiles_lss.lssuploadid
    WHERE useruploads_lss.lssuploadid = '$lssuploadid'";
    $query_run = mysqli_query($con, $query);
    if (!$query_run) {
        $_SESSION['message'] = "Error occurred: " . mysqli_error($con);
    } else {
        $_SESSION['message'] = "The Data is Deleted.";
    }
    header("location: view_uploaded_lss.php$pageUrl");
    exit(0);
}


//UPDATE UPLOADED NCP USER DATA's
if (isset($_POST['update_uploaded_ncp'])) {

    $ncpuploadid = mysqli_real_escape_string($con, $_POST['ncpuploadid']);
    $description = mysqli_escape_string($con, $_POST['description']);
    $source_name = mysqli_escape_string($con, $_POST['source_name']);
    $date_taken = isset($_POST['date_taken']) && !empty($_POST['date_taken']) ? mysqli_escape_string($con, date('M d,Y', strtotime($_POST['date_taken']))) : null;
    $source_link = mysqli_escape_string($con, $_POST['source_link']);

    

    $query = "UPDATE useruploads_ncp
    INNER JOIN useruploadfiles_ncp
    ON useruploads_ncp.ncpuploadid = useruploadfiles_ncp.ncpuploadid 
    SET useruploads_ncp.description = '$description', useruploads_ncp.source_name = '$source_name',
        useruploads_ncp.date_taken = '$date_taken', useruploads_ncp.source = '$source_link'
             WHERE useruploads_ncp.ncpuploadid = '$ncpuploadid'";
    $query_run = mysqli_query($con, $query);

    $_SESSION['message'] = "The Data is Updated.";
    header("location: manage_uploaded_ncp.php?id=$ncpuploadid");
    exit(0);
}

//DELETE UPLOADED NCP USER DATA's
if (isset($_POST['delete_uploaded_ncp'])) {
    $pageUrl = mysqli_escape_string($con, $_POST['page']);
    $ncpuploadid = mysqli_real_escape_string($con, $_POST['ncpuploadid']);
    $query = "DELETE useruploads_ncp, useruploadfiles_ncp
    FROM useruploads_ncp
    JOIN useruploadfiles_ncp
    ON useruploads_ncp.ncpuploadid = useruploadfiles_ncp.ncpuploadid
    WHERE useruploads_ncp.ncpuploadid = '$ncpuploadid'";
    $query_run = mysqli_query($con, $query);
    if (!$query_run) {
        $_SESSION['message'] = "Error occurred: " . mysqli_error($con);
    } else {
        $_SESSION['message'] = "The Data is Deleted.";
    }
    header("location: view_uploaded_ncp.php$pageUrl");
    exit(0);
}

if(isset($_POST['delete_lss_and_send_email']))
{
//   
    
    $delete_lss_id = mysqli_real_escape_string($con, $_POST['delete_lss_and_send_email']);
    $email_value = $_POST['email_value'];
    
    $fileStatus = 'REMOVED';
    if ($email_value == '2') {
        $email_subject = "Content Does Not Match";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we appreciate your contribution, it appears that the image you uploaded does not match the designated Category and Property.";
        $email_body3 = "We understand that errors can happen. If you're unsure about the appropriate Category and Property, feel free to reach out to us for clarification, and we'll be more than happy to assist you.";
        $email_body4 = "Your cooperation in resolving this matter is greatly appreciated as it helps us maintain the quality and accuracy of our content. Thank you for being part of our community!";
        $email_body5 = '';
    } else if ($email_value == '3') {
        $email_subject = "For Further Action";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! Your input truly enriches our platform and greatly helps us with our cause.";
        $email_body2 = "To ensure proper attribution and recognition of the content you've submitted, we kindly ask for some additional details. If you're the creator or owner of the content, kindly tell us the date it was taken and any other relevant information, like if it was captured for an article or publication. This helps us showcase your work accurately.";
        $email_body3 = "If the content was sourced online, please provide us with the full link where it was originally found, along with the name of the image owner and the date it was posted. This way, we can credit the rightful creators and maintain transparency.";
        $email_body4 = "For materials sourced from printed publications such as books or magazines, sharing details like the book's title, author, and publication date would be immensely helpful. It allows us to acknowledge the source properly and uphold copyright integrity.";
        $email_body5 = "Your assistance in providing these details ensures that our platform continues to respect intellectual property rights while celebrating the vibrant heritage of Cebu. Thank you for your cooperation and for being part of our community!";
    } else if ($email_value == '4') {
        $email_value_other = $_POST['email_value_other'];
        $email_subject = "Further Action Required";
    } else {
        echo 'failed to fetch values';
    }

    $user_uploadedid = get_lssdata_uploader_userid($con, $delete_lss_id);
    $recipientEmail = get_email_by_userid($con, $user_uploadedid);
    $recipientFirstName = get_firstname_by_userid($con, $user_uploadedid);

    $sql = "DELETE FROM `lss` WHERE lssid = '$delete_lss_id'";
    $sql_result = mysqli_query($con, $sql);

    if($sql_result)
    {
        $Mailer->send_disapprove_email_to_user( $recipientEmail, $recipientFirstName, $email_subject, $email_body1, $email_body2, $email_body3, $email_body4, $email_body5, $email_value_other);
        $_SESSION['message'] = "Data deleted successfully";
    }
    else
    {
        $_SESSION['message'] = "Failed to delete data";
    }
    header('location: managelss.php');
}

if(isset($_POST['delete_ncp_send_email']))
{
    
    $email_value = $_POST['email_value'];
    $delete_ncpid = mysqli_real_escape_string($con, $_POST['delete_ncp_send_email']);
  
    $fileStatus = 'REMOVED';
 
    if ($email_value == '2') {
        $email_subject = "Content Does Not Match";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! ";
        $email_body2 = "While we appreciate your contribution, it appears that the image you uploaded does not match the designated Category and Property.";
        $email_body3 = "We understand that errors can happen. If you're unsure about the appropriate Category and Property, feel free to reach out to us for clarification, and we'll be more than happy to assist you.";
        $email_body4 = "Your cooperation in resolving this matter is greatly appreciated as it helps us maintain the quality and accuracy of our content. Thank you for being part of our community!";
        $email_body5 = '';
    } else if ($email_value == '3') {
        $email_subject = "For Further Action";
        $email_body1 = "Thank you so much for your contribution to the Cebu Built Heritage website! Your input truly enriches our platform and greatly helps us with our cause.";
        $email_body2 = "To ensure proper attribution and recognition of the content you've submitted, we kindly ask for some additional details. If you're the creator or owner of the content, kindly tell us the date it was taken and any other relevant information, like if it was captured for an article or publication. This helps us showcase your work accurately.";
        $email_body3 = "If the content was sourced online, please provide us with the full link where it was originally found, along with the name of the image owner and the date it was posted. This way, we can credit the rightful creators and maintain transparency.";
        $email_body4 = "For materials sourced from printed publications such as books or magazines, sharing details like the book's title, author, and publication date would be immensely helpful. It allows us to acknowledge the source properly and uphold copyright integrity.";
        $email_body5 = "Your assistance in providing these details ensures that our platform continues to respect intellectual property rights while celebrating the vibrant heritage of Cebu. Thank you for your cooperation and for being part of our community!";
    } else if ($email_value == '4') {
        $email_value_other = $_POST['email_value_other'];
        $email_subject = "Further Action Required";
    } else {
        echo 'failed to fetch values';
    }
   
    $user_uploadedid = get_ncpdata_uploader_userid($con, $delete_ncpid);
    $recipientEmail = get_email_by_userid($con, $user_uploadedid);
    $recipientFirstName = get_firstname_by_userid($con, $user_uploadedid);
    
    // var_dump($delete_ncpid);
    // exit();
    
    $sql = "DELETE FROM ncp WHERE ncpid = '$delete_ncpid'";
    $sql_run = mysqli_query($con, $sql);

    if($sql_run)
    {
        $Mailer->send_disapprove_email_to_user($recipientEmail, $recipientFirstName, $email_subject, $email_body1, $email_body2, $email_body3, $email_body4, $email_body5, $email_value_other);
        $_SESSION['message'] = "Data deleted successfully";
    }
    else
    {
        $_SESSION['message'] = "Failed to delete data";
    }
    header('location: managencp.php');

}
//to add sourcelink in NCP update data
if(isset($_POST['add_source_btn']))
{
    $ncpid = mysqli_real_escape_string($con, $_POST['ncpid']);
    $sourcelink = mysqli_real_escape_string($con, $_POST['sourcelink']);

    $sql = "INSERT INTO `ncp_sourceurl`(`ncpid`, `sourcelink`) VALUES ('$ncpid','$sourcelink')";
    $result = mysqli_query($con, $sql);

    if($result)
    {
        $_SESSION['message'] = "Source URL added succesfully";
    }
    else
    {
        $_SESSION['message'] = "Failed to add source URL";
    }
    header('location: update_ncp.php?id='.$ncpid.'');
}

//to add sourcelink in NCP update data
if(isset($_POST['add_source_lss']))
{
    $lssid = mysqli_real_escape_string($con, $_POST['lssid']);
    $sourcelink = mysqli_real_escape_string($con, $_POST['sourcelink']);

    $sql = "INSERT INTO `lss_sourceurl`(`lssid`, `sourcelink`) VALUES ('$lssid','$sourcelink')";
    $result = mysqli_query($con, $sql);

    if($result)
    {
        $_SESSION['message'] = "Source URL added succesfully";
    }
    else
    {
        $_SESSION['message'] = "Failed to add source URL";
    }
    header('location: update_lss.php?id='.$lssid.'');
}

if(isset($_GET['notif_id'])){
    $notification_id = mysqli_real_escape_string($con, $_GET['notif_id']);
    $sql = "DELETE FROM `notifications` WHERE `id`=$notification_id";
    $result = mysqli_query($con, $sql);

    if($result){
        echo json_encode(['status'=>'success', 'message'=>'Notification removed']);
    }else{
        echo json_encode(['status'=>'error', 'message'=>'Failed to remove notification']);
    }
}
if ($_SERVER['REQUEST_METHOD'] === "PUT") {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['update_notification'])) {

        $notification_id = mysqli_real_escape_string($con, $data['notification_id']);

        $sql = "UPDATE `notifications` SET `status`=1 WHERE `id`=$notification_id";
        $result = mysqli_query($con, $sql);
        if($result){
            echo json_encode(['status'=>'success', 'message'=>'Notification updated']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to update notification']);
        }
    } 
}






