<?php

require_once '../../db/connection.php';

class User
{
    private $con;

    public function __construct()
    {
        $connection = new Connection();
        $this->con = $connection->getConnection();
    }

    // Fetch all users
    public function getAllUsers()
    {
        $sql = "SELECT * FROM `users`";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        foreach ($result as $user) {
            $users[] = $user;
        }
        return $users;
    }
    public function getUserInfoByUserid($userid)
    {
        $sql = "SELECT * FROM `users` WHERE userid=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();
        return $fetch;
    }
    public function getUserPasswordByUserid($userid)
    {
        $sql = "SELECT * FROM `user_login` WHERE userid=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();
        return $fetch;
    }
    public function getUserByEmail($email){
        $sql = "SELECT * FROM `users` WHERE email=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();
        return $fetch;
    }
    public function getUserByToken($token)
    {
        $sql = "SELECT * FROM `user_login` WHERE token=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();
        return $fetch;
    }

    public function verifyEmail($token)
    {
        $getUser = $this->getUserByToken($token);
        $userid = $getUser['userid'];
        $sql = "UPDATE `users` SET `verified`=1 WHERE `userid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        if($stmt->affected_rows>0){

            $notification_sql = "INSERT INTO `notifications`(`userid`) VALUES (?)";
            $notification_stmt = $this->con->prepare($notification_sql);
            $notification_stmt->bind_param('i', $userid);
            $notification_stmt->execute();

            return true;
        }else{
            return false;
        }
    }

    public function isTokenExists($token)
    {
        $sql = "SELECT 1 FROM user_login WHERE token = ?";
        $stmt = $this->con->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->con->error);
        }
    
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if a row exists
        $exists = $result->num_rows > 0;
    
        // Free resources
        $stmt->close();
    
        return $exists;
    }
    public function isEmailExists($email)
    {
        $sql = "SELECT 1 FROM `users` WHERE `email`=?";
        $stmt = $this->con->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->con->error);
        }
    
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if a row exists
        $exists = $result->num_rows > 0;
    
        // Free resources
        $stmt->close();
    
        return $exists;
    }
    public function isUsernameExists($username)
    {
        $sql = "SELECT 1 FROM `user_login` WHERE `username`=?";
        $stmt = $this->con->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->con->error);
        }
    
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if a row exists
        $exists = $result->num_rows > 0;
    
        // Free resources
        $stmt->close();
    
        return $exists;
    }
    public function getUserLastId()
    {
        $sql = "SELECT * FROM `users` ORDER BY userid DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch = $result->fetch_assoc();
        return $fetch['userid'];
    }
    public function createUser($userData)
    {
        $userid = mysqli_real_escape_string($this->con, $userData['userid']);
        $firstname = mysqli_real_escape_string($this->con, $userData['firstname']);
        $lastname = mysqli_real_escape_string($this->con, $userData['lastname']);
        $email = mysqli_real_escape_string($this->con, $userData['email']);
        $datecreated = date('Y-m-d');

        $sql="INSERT INTO `users`(`userid`,`firstname`, `lastname`, `email`, `datecreated`) VALUES (?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('issss', $userid, $firstname,$lastname,$email,$datecreated);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function createUserLogin($userData)
    {
        $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT); 
        $userid = mysqli_real_escape_string($this->con, $userData['userid']);
        $username = mysqli_real_escape_string($this->con, $userData['username']);
        $password =$hashedPassword;
        $token = mysqli_real_escape_string($this->con, $userData['token']);

        $sql="INSERT INTO `user_login`(`userid`, `username`, `password`, `token`) VALUES (?,?,?,?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('isss', $userid, $username,$password,$token);
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }
    public function userLogin($userData)
    {
        $username = $userData['username'];

        $sql = "SELECT userid,password FROM `user_login` WHERE `username`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public function verifyAccount($token)
    {
        $getUser = $this->getUserByToken($token);
        $userid = $getUser['userid'];
        $sql = "UPDATE `user_login` SET `token`= NULL WHERE `userid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        if($stmt->affected_rows>0){
            return true;
        }else{
            return false;
        }
    }
    public function forgotPassword($token, $email)
    {
        $fetchUser = $this->getUserByEmail($email);
        $userid = isset($fetchUser['userid']) && !empty($fetchUser['userid']) ? $fetchUser['userid']:null;
        $sql = "UPDATE `user_login` SET `token`=? WHERE `userid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('si', $token, $userid);
        $stmt->execute();
        if($stmt->affected_rows >0){
            return true;
        }else{
            return false;
        }
    }
    public function resetPassword($token, $password)
    {
        $userToken = $this->getUserByToken($token);
        $userid = isset($userToken['userid']) && !empty($userToken['userid']) ? $userToken['userid']:null;
        // var_dump($userid);
        // exit;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE `user_login` SET `token`=NUll, `password`=? WHERE `userid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('si', $hashedPassword, $userid);
        $stmt->execute();
        if($stmt->affected_rows > 0)
        {
            return true;
        }else{
            return false;
        }
    }
    public function changePassword($password, $userid)
    {
        $sql = "UPDATE `user_login` SET `password`=? WHERE `userid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('si', $password,$userid);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            return true;
        }else{
            return false;
        }
    }
    public function updateUserInfo($userData, $userid)
    {
        $sql = "UPDATE `users` SET `firstname`=?,`lastname`=?,`alias`=? WHERE `userid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('sssi', $userData['firstname'], $userData['lastname'], $userData['alias'], $userid);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    public function updateReceiveEmail($status, $userid)
    {
        $sql = "UPDATE `users` SET `subscribe_email`=? WHERE `userid`=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ii',$status, $userid);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            return true;
        }else{
            return false;
        }
    }
}
