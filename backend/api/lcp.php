<?php
session_start();
require_once '../model/lcpModel.php';
include('../model/lcpSourceUrlModel.php');
$LcpSourceUrl = new LcpSourceUrl();
$Lss = new Lcp();
// Allow Cross-Origin Resource Sharing (CORS)
require_once '../security.php';

if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
            if(isset($_GET['lssid']) && !empty($_GET['lssid'])){
                $lssid = $_GET['lssid'];
                $lssFile = $Lss->getLcpUploadedFileByLssid($lssid);
                echo json_encode($lssFile);
            }else{
                $lssData = $Lss->getAllLssData();
                echo json_encode($lssData);
            }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        createLss($data, $Lss, $LcpSourceUrl, $userid);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $inputData = [
            'lssid' => isset($data['lssid']) && !empty($data['lssid']) ? $data['lssid'] : '',
            'lssname' => isset($data['lssname']) && !empty($data['lssname']) ? $data['lssname'] : '',
            'areaid' => isset($data['areaid']) && !empty($data['areaid']) ? $data['areaid'] : '',
            'lsscategory' => isset($data['lsscategory']) && !empty($data['lsscategory']) ? $data['lsscategory'] : '',
            'lssofficialname' => isset($data['lssofficialname']) && !empty($data['lssofficialname']) ? $data['lssofficialname'] : '',
            'lssfilipinoname' => isset($data['lssfilipinoname']) && !empty($data['lssfilipinoname']) ? $data['lssfilipinoname'] : '',
            'lsslocalname' => isset($data['lsslocalname']) && !empty($data['lsslocalname']) ? $data['lsslocalname'] : '',
            'lssclassificationstatus' => isset($data['lssclassificationstatus']) && !empty($data['lssclassificationstatus']) ? $data['lssclassificationstatus'] : '',
            'lsstownorcity' => isset($data['lsstownorcity']) && !empty($data['lsstownorcity']) ? $data['lsstownorcity'] : '',
            'lssyeardeclared' => isset($data['lssyeardeclared']) && !empty($data['lssyeardeclared']) ? $data['lssyeardeclared'] : '',
            'lssotherdeclarations' => isset($data['lssotherdeclarations']) && !empty($data['lssotherdeclarations']) ? $data['lssotherdeclarations'] : '',
            'lsslegislation' => isset($data['lsslegislation']) && !empty($data['lsslegislation']) ? $data['lsslegislation'] : '',
            'lssdescription' => isset($data['lssdescription']) && !empty($data['lssdescription']) ? $data['lssdescription'] : '',
            'lsssource' => isset($data['lsssource']) && !empty($data['lsssource']) ? $data['lsssource'] : '',
            'lsssourceB' => isset($data['lsssourceB']) && !empty($data['lsssourceB']) ? $data['lsssourceB'] : '',
            'uploadedbyuser' => $userid,
            'uploadstatus' => isset($data['uploadstatus']) && !empty($data['uploadstatus']) ? $data['uploadstatus'] : '',
            'uploadstatusby' => isset($data['uploadstatusby']) && !empty($data['uploadstatusby']) ? $data['uploadstatusby'] : '',
            'uploadstatusdate' => isset($data['uploadstatusdate']) && !empty($data['uploadstatusdate']) ? $data['uploadstatusdate'] : '',
            
        ];    
        if($Lss->updateLssData($inputData)){
            echo json_encode(['status'=> 'success', 'message'=>'Data updated successfully']);
        }else{
            echo json_encode(['status'=> 'error', 'message'=>'Failed to update data.']);
        }
        break;

    case 'DELETE':
        if(isset($_GET['lssid'])){
            $lssid = $_GET['lssid'];

            if($Lss->deleteLssData($lssid)){
                echo json_encode(['status'=> 'success', 'message'=>'Data deleted successfully']);
            }else{
                echo json_encode(['status'=> 'error', 'message'=>'Failed to delete data.']);
            }

        }
        break;


}

function createLss($data, $Lss, $LcpSourceUrl,$userid)
{
    $lastNcpid = $Lss->getLastNcpid();
    $lssidAdd = $lastNcpid +1;
    $lssid = $lssidAdd;
    $sourcelink = $data['sourcelink'];
    $inputData = [
        'lssid' => $lssid,
        'lssname' => isset($data['lssname']) && !empty($data['lssname']) ? $data['lssname'] : '',
        'areaid' => isset($data['areaid']) && !empty($data['areaid']) ? $data['areaid'] : '',
        'lssofficialname' => isset($data['lssofficialname']) && !empty($data['lssofficialname']) ? $data['lssofficialname'] : '',
        'lssfilipinoname' => isset($data['lssfilipinoname']) && !empty($data['lssfilipinoname']) ? $data['lssfilipinoname'] : '',
        'lssclassificationstatus' => isset($data['lssclassificationstatus']) && !empty($data['lssclassificationstatus']) ? $data['lssclassificationstatus'] : '',
        'lsstownorcity' => isset($data['lsstownorcity']) && !empty($data['lsstownorcity']) ? $data['lsstownorcity'] : '',
        'lssyeardeclared' => isset($data['lssyeardeclared']) && !empty($data['lssyeardeclared']) ? $data['lssyeardeclared'] : '',
        'lssotherdeclarations' => isset($data['lssotherdeclarations']) && !empty($data['lssotherdeclarations']) ? $data['lssotherdeclarations'] : '',
        'lssdescription' => isset($data['lssdescription']) && !empty($data['lssdescription']) ? $data['lssdescription'] : '',
        'lsssource' => isset($data['lsssource']) && !empty($data['lsssource']) ? $data['lsssource'] : '',
        'lsssourceB' => isset($data['lsssourceB']) && !empty($data['lsssourceB']) ? $data['lsssourceB'] : '',
        'uploadedbyuser' => $userid,
        'category' => !empty($data['category']) ? $data['category'] : '',
        'sourcelink' => isset($data['sourcelink']) && !empty($data['sourcelink']) ? $data['sourcelink'] : ''
    ];

    $requiredFields = [
        'category' => 'Category',
        'areaid' => 'Area',
        'lsstownorcity' => 'Location',
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
    
    if($Lss->createLssData($inputData)){
        foreach($sourcelink as $link){
            $LcpSourceUrl->createLcpSource($inputData['lssid'], $link); 
        }
        echo json_encode(['status'=> 'success', 'message'=>'You have added Local Heritage info, Please wait for the admin approve your entry. Thank you','data'=>$inputData]);
    }else{
        echo json_encode(['status'=> 'error', 'message'=>'Failed to add data.']);
    }
}
