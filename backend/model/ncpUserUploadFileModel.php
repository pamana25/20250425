<?php

require_once '../../db/connection.php';

class NcpUserUploadFile {
    private $con;

    public function __construct() {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    public function getAllNcpUserUploadFile()
    {
        $sql ="SELECT * FROM `useruploadfiles_ncp` ORDER BY ncpuploadid ASC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $ncpUserUpload = [];
        foreach($result as $lcpUpload){
            $ncpUserUpload[] = $lcpUpload;
        }
        return $ncpUserUpload;
    }
    public function getAllNcpUserUploadFileByNcpUploadedId($ncpuploadid)
    {
        $sql ="SELECT * FROM `useruploadfiles_ncp` WHERE `ncpuploadid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $ncpuploadid);
        $stmt->execute();
        $result = $stmt->get_result();

        $ncpUserUpload = [];
        foreach($result as $lcpUpload){
            $ncpUserUpload[] = $lcpUpload;
        }
        return $ncpUserUpload;
    }
    public function createNcpUserUploadFile($ncpuploadid,$ncpfile,$ncppath)
    {
        $sql="INSERT INTO `useruploadfiles_ncp`(`ncpuploadid`,`ncpfile`,`ncppath`) VALUES (?,?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('iss', $ncpuploadid,$ncpfile,$ncppath);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function updateNcpUserUpload($ncpUserUpload)
    {   
        $ncpuploadid   = $ncpUserUpload['ncpuploadid'];
        $ncpfile = $ncpUserUpload['ncpfile'];
        $ncppath = $ncpUserUpload['ncppath'];

        $sql="UPDATE `useruploadfiles_ncp` SET `ncpfile`=?, `ncppath`=? WHERE `ncpuploadid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ssi', $ncpfile,$ncppath,$ncpuploadid);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function deleteNcpUserUpload($ncpuploadid)
    {   
        $sql="DELETE FROM `useruploadfiles_ncp` WHERE `ncpuploadid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i',$ncpuploadid );
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }


}

?>
