<?php
require_once '../model/lcpSourceUrlModel.php';
$LcpSourceUrl = new LcpSourceUrl();

require_once '../security.php';

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

switch($method){

    case 'GET':
        $lcpSource = $LcpSourceUrl->getAllLcpSourceUrl();
        echo json_encode($lcpSource);
        break;
    
    case 'POST':
        $inputData =[
            'lssid' => isset($data['lssid']) && !empty($data['lssid']) ? $data['lssid']:null,
            'sourcelink' => isset($data['sourcelink']) && !empty($data['sourcelink']) ? $data['sourcelink']:null
        ];
        if($LcpSourceUrl->createLcpSource($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Lcp Source has been added successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to add Lcp Source']);
        }
        break;

    case 'PUT':
        $inputData =[
            'id'=> $data['id'],
            'lssid' => isset($data['lssid']) && !empty($data['lssid']) ? $data['lssid']:null,
            'sourcelink' => isset($data['sourcelink']) && !empty($data['sourcelink']) ? $data['sourcelink']:null
        ];
        if($LcpSourceUrl->updateLcpSource($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Lcp Source has been updated successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to update Lcp Source']);
        }
        break;

    case 'DELETE':
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if($LcpSourceUrl->deleteLcpSource($id)){
                echo json_encode(['status'=>'success', 'message'=>'Lcp Source has been deleted successfully.']);
            }else{
                echo json_encode(['status'=>'error', 'message'=>'Failed to delete Lcp Source']);
            }
        }
        break;


}


