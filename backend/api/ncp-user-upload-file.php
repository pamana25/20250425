<?php
require_once '../model/ncpUserUploadFileModel.php';
 $NcpUserUploadFile = new NcpUserUploadFile();

 require_once '../security.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

    case 'GET':
        $ncpUserUpload = $NcpUserUploadFile->getAllNcpUserUploadFile();
        echo json_encode($ncpUserUpload);
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $inputData =[
            'ncpuploadid' => isset($data['ncpuploadid']) && !empty($data['ncpuploadid']) ? $data['ncpuploadid']:null,
            'ncpfile' => isset($data['ncpfile']) && !empty($data['ncpfile']) ? $data['ncpfile']:null,
            'ncppath' => isset($data['ncppath']) && !empty($data['ncppath']) ? $data['ncppath']:null
        ];
        if($NcpUserUploadFile->createNcpUserUploadFile($inputData['ncpuploadid'], $inputData['ncpfile'],$inputData['ncppath'])){
            echo json_encode(['status'=>'success', 'message'=>'Ncp Source has been added successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to add Ncp Source']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $inputData =[
            'ncpuploadid' => isset($data['ncpuploadid']) && !empty($data['ncpuploadid']) ? $data['ncpuploadid']:null,
            'ncpfile' => isset($data['ncpfile']) && !empty($data['ncpfile']) ? $data['ncpfile']:null,
            'ncppath' => isset($data['ncppath']) && !empty($data['ncppath']) ? $data['ncppath']:null
        ];
        if($NcpUserUploadFile->updateNcpUserUpload($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Ncp Source has been updated successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to update Ncp Source']);
        }
        break;

    case 'DELETE':
        if(isset($_GET['ncpuploadid'])){
            $ncpuploadid  = $_GET['ncpuploadid'];
            if($NcpUserUploadFile->deleteNcpUserUpload($ncpuploadid )){
                echo json_encode(['status'=>'success', 'message'=>'Ncp Source has been deleted successfully.']);
            }else{
                echo json_encode(['status'=>'error', 'message'=>'Failed to delete Ncp Source']);
            }
        }
        break;


}


