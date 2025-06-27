<?php

require_once '../../db/connection.php';

class LcpSourceUrl {
    private $con;

    public function __construct() {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    public function getAllLcpSourceUrl()
    {
        $sql ="SELECT * FROM `lss_sourceurl`";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $lcpSourceData = [];
        foreach($result as $source){
            $lcpSourceData[] = $source;
        }
        return $lcpSourceData;
    }
    public function getAllLcpSourceUrlByLcpid($lcpid)
    {
        $sql ="SELECT * FROM `lss_sourceurl` WHERE `lssid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $lcpid);
        $stmt->execute();
        $result = $stmt->get_result();

        $lcpSourceData = [];
        foreach($result as $source){
            $lcpSourceData[] = $source;
        }
        return $lcpSourceData;
    }


    public function createLcpSource($lssid, $sourcelink)
    {
        $sql="INSERT INTO `lss_sourceurl`(`lssid`, `sourcelink`) VALUES (?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('is', $lssid,$sourcelink);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function updateLcpSource($lcpSource)
    {   
        $id = $lcpSource['id'];
        $lssid = $lcpSource['lssid'];
        $sourcelink = $lcpSource['sourcelink'];

        $sql="UPDATE `lss_sourceurl` SET `lssid`=?, `sourcelink`=? WHERE `id`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('isi', $lssid,$sourcelink,$id);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function deleteLcpSource($id)
    {   
        $sql="DELETE FROM `lss_sourceurl` WHERE `id`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }


}
?>
