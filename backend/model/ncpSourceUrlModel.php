<?php

require_once '../../db/connection.php';

class NcpSourceUrl {
    private $con;

    public function __construct() {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }
    public function getAllNcpSourceUrl()
    {
        $sql ="SELECT * FROM `ncp_sourceurl`";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $sources = [];
        foreach($result as $ncp){
            $sources[]= $ncp;
        }
        return $sources;
    }
    public function getAllNcpSourceUrlByNcpid($ncpid)
    {
        $sql ="SELECT * FROM `ncp_sourceurl` WHERE `ncpid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $ncpid);
        $stmt->execute();
        $result = $stmt->get_result();

        $sources = [];
        foreach($result as $ncp){
            $sources[]= $ncp;
        }
        return $sources;
    }
    public function createNcpSource($ncpid, $sourcelink)
    {
        $sql = "INSERT INTO `ncp_sourceurl`(`ncpid`, `sourcelink`) VALUES (?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('is', $ncpid, $sourcelink);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function updateNcpSource($ncpSource)
    {
        $ncpid = $ncpSource['ncpid'];
        $sourcelink = $ncpSource['sourcelink'];
        $id = $ncpSource['id'];
        $sql = "UPDATE ncp_sourceurl SET `ncpid`=?, `sourcelink`=? WHERE `id`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('isi', $ncpid, $sourcelink, $id);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function deleteNcpSource($id)
    {
        $sql = "DELETE FROM ncp_sourceurl WHERE `id`=?";
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
