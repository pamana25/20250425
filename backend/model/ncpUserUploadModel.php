<?php

require_once '../../db/connection.php';

class NcpUserUpload
{
    private $con;

    public function __construct()
    {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    public function getAllUserUploads()
    {
        $sql = "SELECT * FROM `useruploads_ncp`";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $userUploads = [];
        foreach ($result as $upload) {
            $userUploads[] = $upload;
        }
        return $userUploads;
    }
    
    public function getAllUserUploadsByNcpid($ncpid)
    {
        $sql = "SELECT * FROM `useruploads_ncp` WHERE `ncpid`=? AND `status`=1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $ncpid);
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
        $ncpid = $userUploadData['ncpid'];
        $description = $userUploadData['description'];
        $source_name = $userUploadData['source_name'];
        $alt_name = $userUploadData['alt_name'];
        $date_taken = $userUploadData['date_taken'];
        $source = $userUploadData['source'];
        $uploadedby  = $userUploadData['uploadedby'];

        $sql = "INSERT INTO `useruploads_ncp`(`ncpid`, `description`, `source_name`, `alt_name`, `date_taken`, `source`, `uploadedby`, `dateuploaded`) VALUES (?,?,?,?,?,?,?,NOW())";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('isssssi', $ncpid, $description, $source_name, $alt_name, $date_taken, $source, $uploadedby);
        if($stmt->execute()){
            return $this->con->insert_id;
        }else{
            return false;
        }
    }
    public function updateUserUpload($userUploadData)
    {
        $ncpuploadid = $userUploadData['ncpuploadid'];
        $ncpid = $userUploadData['ncpid'];
        $description = $userUploadData['description'];
        $source_name = $userUploadData['source_name'];
        $alt_name = $userUploadData['alt_name'];
        $date_taken = $userUploadData['date_taken'];
        $source = $userUploadData['source'];
        $uploadedby  = $userUploadData['uploadedby'];
        $status  = $userUploadData['status'];
        $statusby  = $userUploadData['statusby'];
        $statusdate = date('Y-m-d');

        $sql = "UPDATE `useruploads_ncp` 
                SET 
                    `ncpid`=?,
                    `description` = ?, 
                    `source_name` = ?, 
                    `alt_name` = ?, 
                    `date_taken` = ?, 
                    `source` = ?, 
                    `uploadedby` = ?, 
                    `status`=?,
                    `statusby`=?,
                    `statusdate`=?
                WHERE `ncpuploadid` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('isssssiiisi', $ncpid, $description, $source_name, $alt_name, $date_taken, $source, $uploadedby, $status, $statusby,$statusdate, $ncpuploadid);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteUserUpload($ncpuploadid)
    {
        $sql = "DELETE FROM `useruploads_ncp` WHERE `ncpuploadid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $ncpuploadid);
        $stmt->execute();
        if($stmt->affected_rows>0){
            return true;
        }else{
            return false;
        }
    }
}
