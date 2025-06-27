<?php
require_once '../model/lcpUserUploadFileModel.php';
 $LcpUserUploadFile = new LcpUserUploadFile();

 require_once '../security.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

    case 'GET':
        $lcpUserUpload = $LcpUserUploadFile->getAllLcpUserUploadFile();
        echo json_encode($lcpUserUpload);
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $inputData =[
            'lssuploadid' => isset($data['lssuploadid']) && !empty($data['lssuploadid']) ? $data['lssuploadid']:null,
            'lssfile' => isset($data['lssfile']) && !empty($data['lssfile']) ? $data['lssfile']:null,
            'lsspath' => isset($data['lsspath']) && !empty($data['lsspath']) ? $data['lsspath']:null
        ];
        if($LcpUserUploadFile->createLcpUserUpload($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Lcp Source has been added successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to add Lcp Source']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $inputData =[
            'lssuploadid' => isset($data['lssuploadid']) && !empty($data['lssuploadid']) ? $data['lssuploadid']:null,
            'lssfile' => isset($data['lssfile']) && !empty($data['lssfile']) ? $data['lssfile']:null,
            'lsspath' => isset($data['lsspath']) && !empty($data['lsspath']) ? $data['lsspath']:null
        ];
        if($LcpUserUploadFile->updateLcpUserUpload($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Lcp Source has been updated successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to update Lcp Source']);
        }
        break;

    case 'DELETE':
        if(isset($_GET['lssuploadid'])){
            $lssuploadid = $_GET['lssuploadid'];
            if($LcpUserUploadFile->deleteLcpUserUpload($lssuploadid)){
                echo json_encode(['status'=>'success', 'message'=>'Lcp Source has been deleted successfully.']);
            }else{
                echo json_encode(['status'=>'error', 'message'=>'Failed to delete Lcp Source']);
            }
        }
        break;


}


