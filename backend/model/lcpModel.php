<?php

require_once '../../db/connection.php';

class Lcp
{
    private $con;

    public function __construct()
    {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    public function getAllLssData()
    {
        $sql = "SELECT * FROM `lss` WHERE `uploadstatus`=1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $lssData = [];
        foreach ($result as $lss) {
            $lssData[] = $lss;
        }

        return $lssData;
    }

    public function getLssDataById($lcpid)
    {
        $sql = "SELECT * FROM `lss` WHERE `lssid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $lcpid);
        $stmt->execute();
        $result = $stmt->get_result();

        $lssData = [];
        foreach ($result as $lss) {
            $lssData[] = $lss;
        }

        return $lssData;
    }

    public function getLastNcpid()
    {
        $sql = "SELECT * FROM `lss` ORDER BY `lssid` DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();
        return $fetch['lssid'];
    }
    public function createLssData($lssData)
    {
        $sql = "INSERT INTO `lss`(
                `lssid`, `lssname`, `areaid`, `lssofficialname`, `lssfilipinoname`,
                `lssclassificationstatus`, `lsstownorcity`, `lssyeardeclared`,
                `lssotherdeclarations`, `lssdescription`, `lsssource`, `lsssourceB`,
                `uploadedbyuser`
            ) 
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            return $this->con->error; // SQL preparation failed.
        }

        $stmt->bind_param(
            'isisssssssssi',
            $lssData['lssid'],
            $lssData['lssname'],
            $lssData['areaid'],
            $lssData['lssofficialname'],
            $lssData['lssfilipinoname'],
            $lssData['lssclassificationstatus'],
            $lssData['lsstownorcity'],
            $lssData['lssyeardeclared'],
            $lssData['lssotherdeclarations'],
            $lssData['lssdescription'],
            $lssData['lsssource'],
            $lssData['lsssourceB'],
            $lssData['uploadedbyuser']
        );

        if (!$stmt->execute()) {
            return $stmt->error; // Log SQL execution errors.
        }

        return true;
    }

    public function updateLssData($lssData)
    {
        $lssid = $lssData['lssid']; // Unique identifier for the record to update
        $lssname = $lssData['lssname'];
        $areaid = $lssData['areaid'];
        $lsscategory = $lssData['lsscategory'];
        $lssofficialname = $lssData['lssofficialname'];
        $lssfilipinoname = $lssData['lssfilipinoname'];
        $lsslocalname = $lssData['lsslocalname'];
        $lssclassificationstatus = $lssData['lssclassificationstatus'];
        $lsstownorcity = $lssData['lsstownorcity'];
        $lssyeardeclared = $lssData['lssyeardeclared'];
        $lssotherdeclarations = $lssData['lssotherdeclarations'];
        $lsslegislation = $lssData['lsslegislation'];
        $lssdescription = $lssData['lssdescription'];
        $lsssource = $lssData['lsssource'];
        $lsssourceB = $lssData['lsssourceB'];
        $uploadedbyuser = $lssData['uploadedbyuser'];
        $uploadstatus = $lssData['uploadstatus'];
        $uploadstatusby = $lssData['uploadstatusby'];
        $uploadstatusdate = $lssData['uploadstatusdate'];

        $sql = "UPDATE `lss` SET 
                `lssname` = ?, 
                `areaid` = ?, 
                `lsscategory` = ?, 
                `lssofficialname` = ?, 
                `lssfilipinoname` = ?, 
                `lsslocalname` = ?, 
                `lssclassificationstatus` = ?, 
                `lsstownorcity` = ?, 
                `lssyeardeclared` = ?, 
                `lssotherdeclarations` = ?, 
                `lsslegislation` = ?, 
                `lssdescription` = ?, 
                `lsssource` = ?, 
                `lsssourceB` = ?, 
                `uploadedbyuser` = ?,
                `uploadstatus`=?,
                `uploadstatusby`=?,
                `uploadstatusdate`=? 
            WHERE `lssid` = ?";

        $stmt = $this->con->prepare($sql);
        $stmt->bind_param(
            'sissssssssssssiiisi',
            $lssname,
            $areaid,
            $lsscategory,
            $lssofficialname,
            $lssfilipinoname,
            $lsslocalname,
            $lssclassificationstatus,
            $lsstownorcity,
            $lssyeardeclared,
            $lssotherdeclarations,
            $lsslegislation,
            $lssdescription,
            $lsssource,
            $lsssourceB,
            $uploadedbyuser,
            $uploadstatus,
            $uploadstatusby,
            $uploadstatusdate,
            $lssid
        );

        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteLssData($lssid)
    {
        $sql = "DELETE FROM `lss` WHERE lssid=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $lssid);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getLcpUploadedFileByLssid($lssid)
    {
        $sql = "SELECT uploadfiles.lssfile FROM useruploads_lss as uploads INNER JOIN useruploadfiles_lss as uploadfiles ON uploads.lssuploadid = uploadfiles.lssuploadid WHERE uploads.lssid=? AND uploads.status=1 LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $lssid);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            return $fetch['lssfile'];
        } else {
            return null;
        }
    }

    public function getLcpMapDetails()
    {
        $sql = "SELECT lssid, lssname, latitude, longitude, map_classification  
        FROM `lss` 
        WHERE `uploadstatus` = 1 
        AND (latitude IS NOT NULL AND latitude != '')
        AND (longitude IS NOT NULL AND longitude != '')
        AND (map_classification IS NOT NULL AND map_classification != '')";

        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // echo $result->fetch_assoc(MYSQLI_ASSOC);
            // exit;
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return null;
        }
    }
}
