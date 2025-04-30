<?php
require_once '../model/areaModel.php';
$Area = new Area();

require_once '../security.php';

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

switch($method){

    case 'GET':
        $areas = $Area->getAllAreas();
        echo json_encode($areas);
        break;
    
    case 'POST':
        $inputData = [
            'areaid'=>isset($data['areaid']) && !empty($data['areaid']) ? $data['areaid']:null,
            'areatype'=>isset($data['areatype']) && !empty($data['areatype']) ? $data['areatype']:null,
            'areaprovince'=>isset($data['areaprovince']) && !empty($data['areaprovince']) ? $data['areaprovince']:null,
            'areaname'=>isset($data['areaname']) && !empty($data['areaname']) ? $data['areaname']:null,
        ];
        if($Area->createArea($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Area added successfully.']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to add area.']);
        }
        break;

    case 'PUT':

        $inputData = [
            'areaid'=>isset($data['areaid']) && !empty($data['areaid']) ? $data['areaid']:null,
            'areatype'=>isset($data['areatype']) && !empty($data['areatype']) ? $data['areatype']:null,
            'areaprovince'=>isset($data['areaprovince']) && !empty($data['areaprovince']) ? $data['areaprovince']:null,
            'areaname'=>isset($data['areaname']) && !empty($data['areaname']) ? $data['areaname']:null,
            'displaystatus'=>isset($data['displaystatus']) && !empty($data['displaystatus']) ? $data['displaystatus']:null,
        ];
        if($Area->updateArea($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Area updated successfully']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to update area']);
        }
        break;

    case 'DELETE':
        if(isset($_GET['areaid'])){
            $areaid = $_GET['areaid'];
            if($Area->deleteArea($areaid)){
                echo json_encode(['status'=>'success', 'message'=>'Area deleted successfully.']);
            }else{
                echo json_encode(['status'=>'error', 'message'=>'Failed to delete this area']);
            }
        }
        break;


}

