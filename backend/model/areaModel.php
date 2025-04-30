<?php

require_once '../../db/connection.php';

class Area {
    private $con;

    public function __construct() {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    public function getAllAreas()
    {
        $sql = "SELECT * FROM `areas` ORDER BY areaname ASC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $areas = [];
        foreach($result as $area){
            $areas[] = $area;
        }
        return $areas;
    }
    public function createArea($areaData)
    {
        $areaid = $areaData['areaid'];
        $areatype = $areaData['areatype'];
        $areaprovince = $areaData['areaprovince'];
        $areaname = $areaData['areaname'];

        $sql ="INSERT INTO `areas`(`areaid`, `areatype`, `areaprovince`, `areaname`) VALUES (?,?,?,?)";
        $stmt= $this->con->prepare($sql);
        $stmt->bind_param('isss', $areaid, $areatype, $areaprovince,$areaname);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function updateArea($areaData)
    {
        $areaid = $areaData['areaid'];
        $areatype = $areaData['areatype'];
        $areaprovince = $areaData['areaprovince'];
        $areaname = $areaData['areaname'];
        $displaystatus = $areaData['displaystatus'];

        $sql= "UPDATE `areas` SET `areatype`=?,`areaprovince`=?,`areaname`=?,`displaystatus`=? WHERE areaid=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('sssii', $areatype, $areaprovince,$areaname,$displaystatus,$areaid);
        $stmt->execute();
        if($stmt->affected_rows>0){
            return true;
        }else{
            return false;
        }
    }
    public function deleteArea($areaid)
    {
        $sql ="DELETE FROM `areas` WHERE `areaid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $areaid);
        $stmt->execute();
        if($stmt->affected_rows>0){
            return true;
        }else{
            return false;
        }
    }
}
?>
