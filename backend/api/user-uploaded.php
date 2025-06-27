<?php
require_once '../model/ncpUserUploadFileModel.php';
require_once '../model/ncpUserUploadModel.php';
require_once '../model/ncpModel.php';
require_once '../model/lcpUserUploadFileModel.php';
require_once '../model/lcpUserUploadModel.php';
require_once '../model/lcpModel.php';
header('content-type: application/json');
$ncp_user_upload_file = new NcpUserUploadFile();
$ncp_user_upload_data = new NcpUserUpload();
$ncp = new Ncp();
$lcp_user_upload_file = new LcpUserUploadFile();
$lcp_user_upload = new LcpUserUpload();
$lcp = new Lcp();

error_reporting(1);


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['type']) && isset($_GET['userid'])) {
            get_user_uploaded_info($ncp_user_upload_file, $ncp_user_upload_data, $ncp, $lcp_user_upload_file, $lcp_user_upload, $lcp, $_GET['type'], $_GET['userid']);
        }
        break;
    case 'POST':
        echo json_encode(["error" => "Invalid request method"]);
        break;
    case 'PUT':
        echo json_encode(["error" => "Invalid request method"]);
        break;
    case 'DELETE':
        echo json_encode(["error" => "Invalid request method"]);
        break;
}



function get_user_uploaded_info($ncp_user_upload_file, $ncp_user_upload, $ncp, $lcp_user_upload_file, $lcp_user_upload, $lcp, $type, $userid)
{
    if ($type == 'ncp') {
        $ncp_upload_files = $ncp_user_upload_file->getAllNcpUserUploadFile();
        $ncp_upload_data = $ncp_user_upload->getAllUserUploads();
        $ncp_data = $ncp->getAllNcpData();

        $filtered_upload_data = array_filter($ncp_upload_data, function ($upload_data) use ($userid) {
            return $upload_data['uploadedby'] == $userid;
        });

        $ncpuploadids = array_column($filtered_upload_data, 'ncpuploadid');
        $ncpids = array_column($filtered_upload_data, 'ncpid');

        $filtered_upload_files = array_filter($ncp_upload_files, function ($upload_file) use ($ncpuploadids) {
            return in_array($upload_file['ncpuploadid'], $ncpuploadids);
        });

        // Create a lookup for ncp data by ncpid
        $ncp_lookup = [];
        foreach ($ncp_data as $ncp_item) {
            $ncp_lookup[$ncp_item['ncpid']] = $ncp_item;
        }

        // Merge the filtered upload files, data, and ncp data
        $merged_results = [];
        foreach ($filtered_upload_files as $upload_file) {
            foreach ($filtered_upload_data as $upload_data) {
                if ($upload_file['ncpuploadid'] == $upload_data['ncpuploadid']) {
                    $merged_result = array_merge($upload_file, $upload_data);
                    // Add ncp data if available
                    if (isset($ncp_lookup[$upload_data['ncpid']])) {
                        $ncp_info = $ncp_lookup[$upload_data['ncpid']];
                        $merged_result = array_merge($merged_result, [
                            'ncpname' => $ncp_info['ncpname'] ?? null,
                            'ncpofficialname' => $ncp_info['ncpofficialname'] ?? null,
                            'ncpfilipinoname' => $ncp_info['ncpfilipinoname'] ?? null,
                        ]);
                    } else {
                        $merged_result = array_merge($merged_result, [
                            'ncpname' => 'N/A',
                            'ncpofficialname' => 'N/A',
                            'ncpfilipinoname' => 'N/A',
                        ]);
                    }
                    $merged_results[] = $merged_result;
                }
            }
        }
        echo json_encode($merged_results);
        return;
    }

    if ($type == 'lcp') {
        $lcp_upload_files = $lcp_user_upload_file->getAllLcpUserUploadFile();
        $lcp_upload_data = $lcp_user_upload->getAllUserUploads();
        $lcp_data = $lcp->getAllLssData();

        // Filter upload data by user ID
        $filtered_upload_data = array_filter($lcp_upload_data, function ($upload_data) use ($userid) {
            return $upload_data['uploadedby'] == $userid;
        });

        $lcpuploadids = array_column($filtered_upload_data, 'lssuploadid');

        // Filter upload files based on the filtered upload data
        $filtered_upload_files = array_filter($lcp_upload_files, function ($upload_file) use ($lcpuploadids) {
            return in_array($upload_file['lssuploadid'], $lcpuploadids);
        });

        // Create a lookup for LCP data by lssid
        $lcp_lookup = [];
        foreach ($lcp_data as $lcp_item) {
            $lcp_lookup[$lcp_item['lssid']] = $lcp_item;
        }

        // Merge the filtered upload files, data, and LCP data
        $merged_results = [];
        foreach ($filtered_upload_files as $upload_file) {
            foreach ($filtered_upload_data as $upload_data) {
                error_log("Comparing Upload File ID: " . $upload_file['lssuploadid'] . " with Upload Data ID: " . $upload_data['lssuploadid']);
                if ($upload_file['lssuploadid'] == $upload_data['lssuploadid']) {
                    $merged_result = array_merge($upload_file, $upload_data);

                    // Add LCP data if available
                    if (isset($lcp_lookup[$upload_data['lssid']])) {
                        $lcp_info = $lcp_lookup[$upload_data['lssid']];
                        $merged_result = array_merge($merged_result, [
                            'lssname' => $lcp_info['lssname'] ?? null,
                            'lssofficialname' => $lcp_info['lssofficialname'] ?? null,
                            'lssfilipinoname' => $lcp_info['lssfilipinoname'] ?? null,
                        ]);
                    } else {
                        $merged_result = array_merge($merged_result, [
                            'lssname' => 'N/A',
                            'lssofficialname' => 'N/A',
                            'lssfilipinoname' => 'N/A',
                        ]);
                    }

                    $merged_results[] = $merged_result;
                }
            }
        }
        echo json_encode($merged_results);
        return;
    }

    return [];
}
