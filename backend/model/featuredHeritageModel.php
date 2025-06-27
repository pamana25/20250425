<?php

require_once '../../db/connection.php';

class FeaturedHeritage {
    private $con;

    public function __construct() {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    // public function getAllNcpUploadedFiles($ncpuploadid )
    // {
    //     $sql = "SELECT * FROM `useruploadfiles_ncp` WHERE `ncpuploadid`=?";
    //     $stmt = $this->con->prepare($sql);
    //     $stmt->bind_param('i', $ncpuploadid);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
        
    //     $ncpFiles = [];
    //     foreach($result as $ncpRow)
    //     {
    //         $ncpFiles[] = $ncpRow;
    //     }
    //     return $ncpFiles;
    // }

    public function getNcpHeritage()
    {
        $sql = "SELECT 
                    ncp.ncpid, 
                    ncp.ncpname, 
                    ncp.areaid, 
                    ncp.ncptownorcity, 
                    useruploadfiles_ncp.ncpfile, 
                    useruploadfiles_ncp.ncppath, 
                    useruploads_ncp.ncpuploadid
                FROM ncp
                INNER JOIN useruploads_ncp ON ncp.ncpid = useruploads_ncp.ncpid
                INNER JOIN useruploadfiles_ncp ON useruploads_ncp.ncpuploadid = useruploadfiles_ncp.ncpuploadid
                WHERE useruploads_ncp.status=1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $ncp = [];
        foreach ($result as $row) {
            $id = $row['ncpid'];
            if (!isset($ncp[$id])) {
                $ncp[$id] = [
                    'title' => $row['ncpname'],
                    'town' => $row['ncptownorcity'],
                    'areaid' => $row['areaid'],
                    'image' => [],
                    'type' => 'ncp',
                    'id' => $row['ncpid'],
                ];
            }
            $ncp[$id]['image'][] = [
                'file' => $row['ncpfile'],
                'path' => $row['ncppath'],
            ];
        }
        return array_values($ncp);
    }
    
    public function getLcpHeritage()
    {
        $sql = "SELECT 
                    lss.lssid, 
                    lss.lssname, 
                    lss.areaid, 
                    lss.lsstownorcity, 
                    useruploadfiles_lss.lssfile, 
                    useruploadfiles_lss.lsspath 
                FROM 
                    lss
                INNER JOIN 
                    useruploads_lss 
                    ON lss.lssid = useruploads_lss.lssid
                INNER JOIN 
                    useruploadfiles_lss 
                    ON useruploads_lss.lssuploadid = useruploadfiles_lss.lssuploadid
                WHERE 
                    useruploads_lss.status = 1";
        
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $lcp = [];
        
        foreach ($result as $row) {
            $id = $row['lssid'];
            // Group by `lssid` and accumulate files
            if (!isset($lcp[$id])) {
                $lcp[$id] = [
                    'title' => $row['lssname'],
                    'town' => $row['lsstownorcity'],
                    'areaid' => $row['areaid'],
                    'image' => [], // Initialize as an array to hold multiple files
                    'type' => 'lss',
                    'id' => $row['lssid']
                ];
            }
            // Add file details to the 'image' array
            $lcp[$id]['image'][] = [
                'file' => $row['lssfile'],
                'path' => $row['lsspath']
            ];
        }
        
        // Reset keys to a zero-based array
        return array_values($lcp);
    }
    

    public function getProperty()
    {
        $ncp = $this->getNcpHeritage();
        $lcp = $this->getLcpHeritage();

        $property = array_merge($ncp, $lcp);
        return $property;
    }
}