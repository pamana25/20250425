<?php

require_once '../../db/connection.php';

class LcpUserUpload
{
    private $con;

    public function __construct()
    {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    public function getAllUserUploads()
    {
        $sql = "SELECT * FROM `useruploads_lss`";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $userUploads = [];
        foreach ($result as $upload) {
            $userUploads[] = $upload;
        }
        return $userUploads;
    }
    public function getAllUserUploadsByLcpid($lcpid)
    {
        $sql = "SELECT * FROM `useruploads_lss` WHERE `lssid`=? AND `status`=1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $lcpid);
        $stmt->execute();
        $result = $stmt->get_result();

        $userUploads = [];
        foreach ($result as $upload) {
            $userUploads[] = $upload;
        }
        return $userUploads;
    }

    public function createUserUpload($userUploadData)
    {
        $lssid = $userUploadData['lssid'];
        $description = $userUploadData['description'];
        $source_name = $userUploadData['source_name'];
        $alt_name = $userUploadData['alt_name'];
        $date_taken = $userUploadData['date_taken'];
        $source = $userUploadData['source'];
        $uploadedby = $userUploadData['uploadedby'];
    
        $sql = "INSERT INTO `useruploads_lss` (`lssid`, `description`, `source_name`, `alt_name`, `date_taken`, `source`, `uploadedby`, `dateuploaded`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('isssssi', $lssid, $description, $source_name, $alt_name, $date_taken, $source, $uploadedby);
    
        if ($stmt->execute()) {
            // Return the last inserted ID
            return $this->con->insert_id;
        } else {
            // Return false if insertion fails
            return false;
        }
    }    
    public function updateUserUpload($userUploadData)
    {
        $lssuploadid = $userUploadData['lssuploadid'];
        $lssid = $userUploadData['lssid'];
        $description = $userUploadData['description'];
        $source_name = $userUploadData['source_name'];
        $alt_name = $userUploadData['alt_name'];
        $date_taken = $userUploadData['date_taken'];
        $source = $userUploadData['source'];
        $uploadedby  = $userUploadData['uploadedby'];
        $status  = $userUploadData['status'];
        $statusby  = $userUploadData['statusby'];
        $statusdate = date('Y-m-d');

        $sql = "UPDATE `useruploads_lss` 
                SET 
                    `lssid`=?,
                    `description` = ?, 
                    `source_name` = ?, 
                    `alt_name` = ?, 
                    `date_taken` = ?, 
                    `source` = ?, 
                    `uploadedby` = ?, 
                    `status`=?,
                    `statusby`=?,
                    `statusdate`=?
                WHERE `lssuploadid` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('isssssiiisi', $lssid, $description, $source_name, $alt_name, $date_taken, $source, $uploadedby, $status, $statusby,$statusdate, $lssuploadid);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteUserUpload($lssuploadid)
    {
        $sql = "DELETE FROM `useruploads_lss` WHERE `lssuploadid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $lssuploadid);
        $stmt->execute();
        if($stmt->affected_rows>0){
            return true;
        }else{
            return false;
        }
    }
}
