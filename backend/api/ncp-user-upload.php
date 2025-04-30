<?php
session_start();
require_once '../model/ncpUserUploadModel.php';
include('../model/ncpUserUploadFileModel.php');
include('../../library/phpmailer/send.php');
include('../model/userModel.php');
$User = new User();
$Mailer = new Mailer();
$NcpUserUpload = new NcpUserUpload();
$NcpUserUploadFile = new NcpUserUploadFile();
require_once '../security.php';

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}


$method = $_SERVER['REQUEST_METHOD'];

switch($method){

    case 'GET':
        $userUploads = $NcpUserUpload->getAllUserUploads();
        echo json_encode($userUploads);
        break;
    
    case 'POST':
        // $data = json_decode(file_get_contents('php://input'), true);
        $get_user_info = $User->getUserInfoByUserid($userid);
        $inputData = [
            'ncpid' => isset($_POST['ncpid']) && !empty($_POST['ncpid']) ? $_POST['ncpid']:'',
            'description' => isset($_POST['description']) && !empty($_POST['description']) ? $_POST['description']:'',
            'source_name' => isset($_POST['source_name']) && !empty($_POST['source_name']) ? $_POST['source_name']:'',
            'alt_name' => isset($_POST['alt_name']) && !empty($_POST['alt_name']) ? $_POST['alt_name']:'',
            'date_taken' => isset($_POST['date_taken']) && !empty($_POST['date_taken']) ? $_POST['date_taken']:'',
            'source' => isset($_POST['source']) && !empty($_POST['source']) ? $_POST['source']:'',
            'uploadedby' => isset($_POST['uploadedby']) && !empty($_POST['uploadedby']) ? $_POST['uploadedby']:'',
        ];
        $file = $_FILES['file']['name'];
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
     
        // Define constants for file handling
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp']; // Allowable file types
        $maxFileSize = 5242880; // 5MB in bytes
        $fileDirectory = "../../useruploads/ncp/";
        $filePathDB = "./useruploads/ncp/";
        $fileVersion = date('Ymd_His');
        $newFileName = $userid . "_" . $fileVersion . "_" . $file;
        $path = $fileDirectory . $newFileName;

         // Check if a file is uploaded
         if (!isset($_FILES['file']) || empty($file)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No file uploaded.'
            ]);
            return;
        }
        
        // Validate file size
        if ($fileSize > $maxFileSize) {
            echo json_encode([
                'status' => 'error',
                'message' => 'File size upload limit is 5MB or 5242880 bytes.'
            ]);
            return;
        }
        
        // Validate file type
        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid file type. Only JPG, JPEG, PNG, and WEBP are allowed.'
            ]);
            return;
        }
        

        $userUploadId = $NcpUserUpload->createUserUpload($inputData);
        if(!$userUploadId){
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to send request.'
            ]);
            return;
        }
        if($NcpUserUploadFile->createNcpUserUploadFile($userUploadId, $newFileName,$filePathDB)){
            if (move_uploaded_file($fileTmp, $path)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Your request has been sent.  Please wait for the admin to approve your request. Thank you!.'
                ]);
                $Mailer->send_filetobereviewed_email_to_user($get_user_info['email'], $get_user_info['firstname']);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to upload file.'
                ]);
            }
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to upload file.']);
        }

        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $inputData = [
            'ncpuploadid' => isset($data['ncpuploadid']) && !empty($data['ncpuploadid']) ? $data['ncpuploadid']:null,
            'ncpid' => isset($data['ncpid']) && !empty($data['ncpid']) ? $data['ncpid']:null,
            'description' => isset($data['description']) && !empty($data['description']) ? $data['description']:null,
            'source_name' => isset($data['source_name']) && !empty($data['source_name']) ? $data['source_name']:null,
            'alt_name' => isset($data['alt_name']) && !empty($data['alt_name']) ? $data['alt_name']:null,
            'date_taken' => isset($data['date_taken']) && !empty($data['date_taken']) ? $data['date_taken']:null,
            'source' => isset($data['source']) && !empty($data['source']) ? $data['source']:null,
            'uploadedby' => isset($data['uploadedby']) && !empty($data['uploadedby']) ? $data['uploadedby']:null,
            'status' => isset($data['status']) && !empty($data['status']) ? $data['status']:null,
            'statusby' => isset($data['statusby']) && !empty($data['statusby']) ? $data['statusby']:null
        ];
        if($NcpUserUpload->updateUserUpload($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Data updated successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to update data.']);
        }
        break;

    case 'DELETE':
        if(isset($_GET['ncpuploadid'])){
            $ncpuploadid = $_GET['ncpuploadid'];
            if($NcpUserUpload->deleteUserUpload($ncpuploadid)){
                echo json_encode(['status'=>'success', 'message'=>'Data deleted successfully.']);
            }else{
                echo json_encode(['status'=>'error', 'message'=>'Failed to delete data.']);
            }
        }
        break;


}
