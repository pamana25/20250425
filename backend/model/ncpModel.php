<?php

require_once '../../db/connection.php';

class Ncp
{
    private $con;

    public function __construct()
    {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    public function getAllNcpData()
    {
        $sql = "SELECT * FROM `ncp` WHERE `uploadstatus`=1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $ncpData = [];
        foreach ($result as $ncp) {
            $ncpData[] = $ncp;
        }

        return $ncpData;
    }
    public function getNcpDataById($ncpid)
    {
        $sql = "SELECT * FROM `ncp` WHERE `ncpid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $ncpid);
        $stmt->execute();
        $result = $stmt->get_result();

        $ncpData = [];
        foreach ($result as $ncp) {
            $ncpData[] = $ncp;
        }

        return $ncpData;
    }
    
    public function getLastNcpid()
    {
        $sql = "SELECT * FROM `ncp` ORDER BY `ncpid` DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();
        return $fetch['ncpid'];
    }

    public function createNcpData($ncpData)
    {
        // Extract values from the input data
        $ncpid = $ncpData['ncpid'];
        $ncpname = $ncpData['ncpname'];
        $areaid = $ncpData['areaid'];
        $ncpofficialname = $ncpData['ncpofficialname'];
        $ncpfilipinoname = $ncpData['ncpfilipinoname'];
        $ncpclassificationstatus = $ncpData['ncpclassificationstatus'];
        $ncptownorcity = $ncpData['ncptownorcity'];
        $ncpyeardeclared = $ncpData['ncpyeardeclared'];
        $ncpotherdeclarations = $ncpData['ncpotherdeclarations'];
        $ncpdescription = $ncpData['ncpdescription'];
        $uploadedbyuser = $ncpData['uploadedbyuser'];
    
        $sql = "INSERT INTO `ncp`(
                    `ncpid`, `ncpname`, `areaid`, `ncpofficialname`, `ncpfilipinoname`,
                    `ncpclassificationstatus`, `ncptownorcity`, `ncpyeardeclared`,
                    `ncpotherdeclarations`, `ncpdescription`, `uploadedbyuser`
                ) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $this->con->prepare($sql);
    

        $stmt->bind_param(
            'isisssssssi',
            $ncpid,
            $ncpname,
            $areaid,
            $ncpofficialname,
            $ncpfilipinoname,
            $ncpclassificationstatus,
            $ncptownorcity,
            $ncpyeardeclared,
            $ncpotherdeclarations,
            $ncpdescription,
            $uploadedbyuser
        );
    
        $stmt->execute();
        if ($stmt) {
            return true; 
        } else {
            return false; 
        }
    }
    
    public function updateNcpData($ncpData)
    {
        // Extract values from the input data
        $ncpid = $ncpData['ncpid'];
        $ncpname = $ncpData['ncpname'];
        $areaid = $ncpData['areaid'];
        $ncpofficialname = $ncpData['ncpofficialname'];
        $ncpfilipinoname = $ncpData['ncpfilipinoname'];
        $ncplocalname = $ncpData['ncplocalname'];
        $ncpclassificationstatus = $ncpData['ncpclassificationstatus'];
        $ncptownorcity = $ncpData['ncptownorcity'];
        $ncpyeardeclared = $ncpData['ncpyeardeclared'];
        $ncpotherdeclarations = $ncpData['ncpotherdeclarations'];
        $ncpdescription = $ncpData['ncpdescription'];
        $ncpsourceA = $ncpData['ncpsourceA'];
        $ncpsourceB = $ncpData['ncpsourceB'];
        $uploadedbyuser = $ncpData['uploadedbyuser'];
        $uploadstatus = $ncpData['uploadstatus'];
        $uploadstatusby = $ncpData['uploadstatusby'];
        $uploadstatusdate = $ncpData['uploadstatusdate'];

        // Prepare the SQL query for updating the data
        $sql = "UPDATE `ncp` SET 
            `ncpname` = ?, 
            `areaid` = ?, 
            `ncpofficialname` = ?, 
            `ncpfilipinoname` = ?, 
            `ncplocalname` = ?, 
            `ncpclassificationstatus` = ?, 
            `ncptownorcity` = ?, 
            `ncpyeardeclared` = ?, 
            `ncpotherdeclarations` = ?, 
            `ncpdescription` = ?, 
            `ncpsourceA` = ?, 
            `ncpsourceB` = ?, 
            `uploadedbyuser` = ? ,
            `uploadstatus` = ? ,
            `uploadstatusby` = ? ,
            `uploadstatusdate` = ? 
            WHERE `ncpid` = ?";

        // Prepare the statement
        $stmt = $this->con->prepare($sql);

        // Bind the parameters (assuming the types are i for integers and s for strings)
        $stmt->bind_param(
            'sissssssssssiiisi',
            $ncpname,
            $areaid,
            $ncpofficialname,
            $ncpfilipinoname,
            $ncplocalname,
            $ncpclassificationstatus,
            $ncptownorcity,
            $ncpyeardeclared,
            $ncpotherdeclarations,
            $ncpdescription,
            $ncpsourceA,
            $ncpsourceB,
            $uploadedbyuser,
            $uploadstatus,
            $uploadstatusby,
            $uploadstatusdate,
            $ncpid // Include ncpid to specify which record to update
        );

        // Execute the query and check if the operation was successful
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true; // Data was updated successfully
        } else {
            return false; // Update failed (e.g., no rows affected)
        }
    }
    public function deleteNcpData($ncpid)
    {
        $sql = "DELETE FROM `ncp` WHERE `ncpid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $ncpid);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    public function getLcpUploadedFileByNcpid($ncpid)
    {
        $sql = "SELECT uploadfiles.ncpfile FROM useruploads_ncp as uploads INNER JOIN useruploadfiles_ncp as uploadfiles ON uploads.ncpuploadid = uploadfiles.ncpuploadid WHERE uploads.ncpid=? AND uploads.status=1 LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $ncpid);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            return $fetch['ncpfile'];
        } else {
            return null;
        }
    }

    public function getNcpMapDetails()
    {
        $sql = "SELECT ncpid, ncpname, latitude, longitude, map_classification  
        FROM `ncp` 
        WHERE `uploadstatus` = 1 
        AND (latitude IS NOT NULL AND latitude != '')
        AND (longitude IS NOT NULL AND longitude != '')
        AND (map_classification IS NOT NULL AND map_classification != '')";

        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return null;
        }
    }
}
