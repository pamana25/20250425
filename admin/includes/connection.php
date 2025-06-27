<?php 

    // $host = "localhost";
    // $username = "root";
    // $password = "";
    // $database = "pamana";

    
    $host = "localhost";
    $username = "u331919308_M9071pb";
    $password = "@QXho8oD8HGJr";
    $database = "u331919308_pamana1225";
    
    $con = new mysqli ($host, $username, $password, $database);

    if($con -> connect_error){
        echo $conn-> connect_erorr;
    }
    // else{
    //     echo "connected";
    // }
    date_default_timezone_set("Asia/Manila");
?>