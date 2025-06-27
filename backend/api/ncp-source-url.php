<?php
require_once '../model/ncpSourceUrlModel.php';
$NcpSourceUrl = new NcpSourceUrl();
require_once '../security.php';
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);
switch($method){

    case 'GET':
        $ncpSources = $NcpSourceUrl->getAllNcpSourceUrl();
        echo json_encode($ncpSources);
        break;
    
    case 'POST':
        $inputData = [
            'ncpid'=>isset($data['ncpid']) && !empty($data['ncpid']) ? $data['ncpid']:null,
            'sourcelink'=>isset($data['sourcelink']) && !empty($data['sourcelink']) ? $data['sourcelink']:null
        ];
        if($NcpSourceUrl->createNcpSource($inputData['ncpid'], $inputData['sourcelink'])){
            echo json_encode(['status'=>'success', 'message'=>'Ncp source has been added successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to add Ncp source']);
        }
        break;

    case 'PUT':
        $inputData = [
            'ncpid'=>isset($data['ncpid']) && !empty($data['ncpid']) ? $data['ncpid']:null,
            'sourcelink'=>isset($data['sourcelink']) && !empty($data['sourcelink']) ? $data['sourcelink']:null,
            'id' => $data['id']
        ];
        if($NcpSourceUrl->updateNcpSource($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Ncp source has been updated successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to updated Ncp source']);
        }
        break;

    case 'DELETE':
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if($NcpSourceUrl->deleteNcpSource($id)){
                echo json_encode(['status'=>'success', 'message'=>'Ncp source has been deleted successfully.']);
            }else{
                echo json_encode(['status'=>'error', 'message'=>'Failed to deleted Ncp source']);
            }
        }
        break;


}
