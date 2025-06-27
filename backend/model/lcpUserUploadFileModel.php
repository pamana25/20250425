<?php

require_once '../../db/connection.php';

class LcpUserUploadFile {
    private $con;

    public function __construct() {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    public function getAllLcpUserUploadFile()
    {
        $sql ="SELECT * FROM `useruploadfiles_lss` ORDER BY lssuploadid ASC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $lcpUserUpload = [];
        foreach($result as $lcpUpload){
            $lcpUserUpload[] = $lcpUpload;
        }
        return $lcpUserUpload;
    }

    public function getAllLcpUserUploadFileByLcpUploadId($lcpUploadId)
    {
        $sql ="SELECT * FROM `useruploadfiles_lss` WHERE `lssuploadid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $lcpUploadId);
        $stmt->execute();
        $result = $stmt->get_result();

        $lcpUserUpload = [];
        foreach($result as $lcpUpload){
            $lcpUserUpload[] = $lcpUpload;
        }
        return $lcpUserUpload;
    }

    public function createLcpUserUploadFile($lssuploadid, $lssfile, $lsspath)
    {
        $sql="INSERT INTO `useruploadfiles_lss`(`lssuploadid`,`lssfile`,`lsspath`) VALUES (?,?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('iss', $lssuploadid,$lssfile,$lsspath);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function updateLcpUserUploadFile($lcpUserUpload)
    {   
        $lssuploadid  = $lcpUserUpload['lssuploadid'];
        $lssfile = $lcpUserUpload['lssfile'];
        $lsspath = $lcpUserUpload['lsspath'];

        $sql="UPDATE `useruploadfiles_lss` SET `lssfile`=?, `lsspath`=? WHERE `lssuploadid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ssi', $lssfile,$lsspath,$lssuploadid);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function deleteLcpUserUpload($lssuploadid)
    {   
        $sql="DELETE FROM `useruploadfiles_lss` WHERE `lssuploadid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i',$lssuploadid);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }


}
?>
