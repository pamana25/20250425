<?php
// Prevent direct access to this file
// if (!defined('APP_INIT')) {
//     die('Direct access not allowed');
// }

class Connection
{
    // Local database
    // private $host = 'localhost';
    // private $db = 'pamana';
    // private $user = 'root';
    // private $pass = '';

    //Production database
    private $host = 'localhost';
    private $db = 'u331919308_pamana1225';
    private $user = 'u331919308_M9071pb';
    private $pass = '@QXho8oD8HGJr';


    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        // Check for connection errors
        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
// session_start();
// header('Content-Type: application/json');
