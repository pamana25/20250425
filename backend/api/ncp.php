<?php
session_start();
require_once '../model/ncpModel.php';
include('../model/ncpSourceUrlModel.php');
$Ncp = new Ncp();
$NcpSourceUrl = new NcpSourceUrl();

require_once '../security.php';
if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
}
$method = $_SERVER['REQUEST_METHOD'];


switch($method){

    case 'GET':
        if(isset($_GET['ncpid']) && !empty($_GET['ncpid'])){
            $ncpid = $_GET['ncpid'];
            $ncpFile = $Ncp->getLcpUploadedFileByNcpid($ncpid);
            echo json_encode($ncpFile);
        }else{
            $ncpData = $Ncp->getAllNcpData();
            echo json_encode($ncpData);
        }  
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        createNcp($data, $Ncp, $NcpSourceUrl, $userid);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $inputData = [
            'ncpid' => isset($data['ncpid']) && !empty($data['ncpid']) ? $data['ncpid'] : null,
            'ncpname' => isset($data['ncpname']) && !empty($data['ncpname']) ? $data['ncpname'] : null,
            'areaid' => isset($data['areaid']) && !empty($data['areaid']) ? $data['areaid'] : null,
            'ncpofficialname' => isset($data['ncpofficialname']) && !empty($data['ncpofficialname']) ? $data['ncpofficialname'] : null,
            'ncpfilipinoname' => isset($data['ncpfilipinoname']) && !empty($data['ncpfilipinoname']) ? $data['ncpfilipinoname'] : null,
            'ncplocalname' => isset($data['ncplocalname']) && !empty($data['ncplocalname']) ? $data['ncplocalname'] : null,
            'ncpclassificationstatus' => isset($data['ncpclassificationstatus']) && !empty($data['ncpclassificationstatus']) ? $data['ncpclassificationstatus'] : null,
            'ncptownorcity' => isset($data['ncptownorcity']) && !empty($data['ncptownorcity']) ? $data['ncptownorcity'] : null,
            'ncpyeardeclared' => isset($data['ncpyeardeclared']) && !empty($data['ncpyeardeclared']) ? $data['ncpyeardeclared'] : null,
            'ncpotherdeclarations' => isset($data['ncpotherdeclarations']) && !empty($data['ncpotherdeclarations']) ? $data['ncpotherdeclarations'] : null,
            'ncpdescription' => isset($data['ncpdescription']) && !empty($data['ncpdescription']) ? $data['ncpdescription'] : null,
            'ncpsourceA' => isset($data['ncpsourceA']) && !empty($data['ncpsourceA']) ? $data['ncpsourceA'] : null,
            'ncpsourceB' => isset($data['ncpsourceB']) && !empty($data['ncpsourceB']) ? $data['ncpsourceB'] : null,
            'uploadedbyuser' => isset($data['uploadedbyuser']) && !empty($data['uploadedbyuser']) ? $data['uploadedbyuser'] : null,
            'uploadstatus' => isset($data['uploadstatus']) && !empty($data['uploadstatus']) ? $data['uploadstatus'] : null,
            'uploadstatusby' => isset($data['uploadstatusby']) && !empty($data['uploadstatusby']) ? $data['uploadstatusby'] : null,
            'uploadstatusdate' => isset($data['uploadstatusdate']) && !empty($data['uploadstatusdate']) ? $data['uploadstatusdate'] : null

        ];
        if($Ncp->updateNcpData($inputData)){
            echo json_encode(['status'=>'success', 'message'=>'Data updated successfully']);
        }else{
            echo json_encode(['status'=>'error', 'message'=>'Failed to update Ncp']);
        }
        break;

    case 'DELETE':
        if(isset($_GET['ncpid'])){
            $ncpid = $_GET['ncpid'];
            if($Ncp->deleteNcpData($ncpid)){
                echo json_encode(['status'=>'success', 'message'=>'Ncp deletd successfully.']);
            }else{
                echo json_encode(['status'=>'error', 'message'=>'Failed to delete Ncp.']);
            }
        }
        break;


}

function createNcp($data, $Ncp, $NcpSourceUrl,$userid)
{
    $lastNcpid = $Ncp->getLastNcpid();
    $ncpid = $lastNcpid + 1;
    $sourcelink = $data['sourcelink'];
    $inputData = [
        'ncpid' => isset($ncpid) && !empty($ncpid) ? $ncpid : '',
        'ncpname' => isset($data['ncpname']) && !empty($data['ncpname']) ? $data['ncpname'] : '',
        'areaid' => isset($data['areaid']) && !empty($data['areaid']) ? $data['areaid'] : '',
        'ncpofficialname' => isset($data['ncpofficialname']) && !empty($data['ncpofficialname']) ? $data['ncpofficialname'] : '',
        'ncpfilipinoname' => isset($data['ncpfilipinoname']) && !empty($data['ncpfilipinoname']) ? $data['ncpfilipinoname'] : 'N/A',
        'ncpclassificationstatus' => isset($data['ncpclassificationstatus']) && !empty($data['ncpclassificationstatus']) ? $data['ncpclassificationstatus'] : '',
        'ncptownorcity' => isset($data['ncptownorcity']) && !empty($data['ncptownorcity']) ? $data['ncptownorcity'] : '',
        'ncpyeardeclared' => isset($data['ncpyeardeclared']) && !empty($data['ncpyeardeclared']) ? $data['ncpyeardeclared'] : '',
        'ncpotherdeclarations' => isset($data['ncpotherdeclarations']) && !empty($data['ncpotherdeclarations']) ? $data['ncpotherdeclarations'] : '',
        'ncpdescription' => isset($data['ncpdescription']) && !empty($data['ncpdescription']) ? $data['ncpdescription'] : '',
        'uploadedbyuser' => $userid,
        'category' => !empty($data['category']) ? $data['category'] : '',
        'sourcelink' => isset($data['sourcelink']) && !empty($data['sourcelink']) ? $data['sourcelink'] : ''
    ];    

    $requiredFields = [
        'category' => 'Category',
        'areaid' => 'Area',
        'ncptownorcity' => 'Location',
        'sourcelink' => 'Source URL'
    ];
    
    foreach ($requiredFields as $fieldKey => $fieldValue) {
        if (empty($inputData[$fieldKey])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'The field "' . $fieldValue . '" is required'
            ]);
            return;
        }
    }
    
    if($Ncp->createNcpData($inputData)){
        foreach($sourcelink as $link){
            $NcpSourceUrl->createNcpSource($ncpid, $link);
        }
        echo json_encode(['status'=>'success', 'message'=>'You have added Ncp Heritage, Please wait for the admin to approve your reques. Thank you']);
    }else{
        echo json_encode(['status'=>'error', 'message'=>'Failed to add Ncp']);
    }
}
