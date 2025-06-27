<?php
session_start();
require_once '../model/lcpModel.php';
include('../model/lcpSourceUrlModel.php');
include('../model/lcpUserUploadModel.php');
include('../model/lcpUserUploadFileModel.php');
include('../model/ncpModel.php');
include('../model/ncpSourceUrlModel.php');
include('../model/ncpUserUploadModel.php');
include('../model/ncpUserUploadFileModel.php');
$NcpUserUploadFile = new NcpUserUploadFile();
$NcpUserUpload = new NcpUserUpload();
$Ncp = new Ncp();
$NcpSourceUrl = new NcpSourceUrl();
$LcpSourceUrl = new LcpSourceUrl();
$Lcp = new Lcp();
$LcpUserUpload = new LcpUserUpload();
$LcpUserUploadFile = new LcpUserUploadFile();
// Allow Cross-Origin Resource Sharing (CORS)
require_once '../security.php';

header('Content-Type: application/json');

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['type']) && isset($_GET['id'])) {
            getPropertyDetails($_GET['id'], $_GET['type'], $Lcp, $Ncp);
            return;
        }
        $hasNcpid = isset($_GET['ncpid']) ? $_GET['ncpid'] : '';
        $hasLcpid = isset($_GET['lcpid']) ? $_GET['lcpid'] : '';

        if ($hasLcpid) {
            $lcpModel = $hasLcpid ? $Lcp->getLssDataById($hasLcpid) : $Lcp->getAllLssData();


            $lcp = [];

            foreach ($lcpModel as $lcpRow) {
                // Get the URLs and user uploads associated with the current lcpRow based on lssid
                $lcpUrlModel = $LcpSourceUrl->getAllLcpSourceUrlByLcpid($lcpRow['lssid']);
                $lcp_user_upload = $LcpUserUpload->getAllUserUploadsByLcpid($lcpRow['lssid']);

                $url = [];
                $lcp_upload = [];
                $lcp_upload_file = [];

                foreach ($lcpUrlModel as $urlData) {
                    $url[] = $urlData;
                }
                foreach ($lcp_user_upload as $upload) {
                    $lcp_upload_file = $LcpUserUploadFile->getAllLcpUserUploadFileByLcpUploadId($upload['lssuploadid']);
                    $lcp_upload[] = [
                        'user_upload' => $upload,
                        'user_upload_file' => $lcp_upload_file
                    ];
                }


                $lcp = [
                    'property' => $lcpRow,
                    'url' => $url,
                    'uploaded' => $lcp_upload,
                ];
            }
            echo json_encode($lcp);
        }


        if ($hasNcpid) {

            $ncpModel = $hasNcpid ? $Ncp->getNcpDataById($hasNcpid) : $Ncp->getAllNcpData();
            $ncp = [];

            foreach ($ncpModel as $ncpRow) {
                $ncpUrlModel = $NcpSourceUrl->getAllNcpSourceUrlByNcpid($ncpRow['ncpid']);
                $ncp_user_upload = $NcpUserUpload->getAllUserUploadsByNcpid($ncpRow['ncpid']);

                $ncpUrl = [];
                $ncp_uplaod = [];
                $ncp_uplaod_file = [];

                foreach ($ncpUrlModel as $ncpUrlData) {
                    $ncpUrl[] = $ncpUrlData;
                }

                foreach ($ncp_user_upload as $user_upload) {
                    $ncp_uplaod_file = $NcpUserUploadFile->getAllNcpUserUploadFileByNcpUploadedId($user_upload['ncpuploadid']);
                    $ncp_uplaod[] = [
                        'user_upload' => $user_upload,
                        'user_upload_file' => $ncp_uplaod_file
                    ];
                }

                $ncp = [
                    'property' => $ncpRow,
                    'url' => $ncpUrl,
                    'uploaded' => $ncp_uplaod,

                ];
            }
            echo json_encode($ncp);
        }

        // $combined = array_merge($ncp, $lcp);



        break;
}


function getPropertyDetails($id, $type, $Lcp, $Ncp)
{
    $propertyDetails = $type == 'ncp' ? $Ncp->getNcpDataById($id) : $Lcp->getLssDataById($id);
    echo json_encode($propertyDetails);
    return;
}
