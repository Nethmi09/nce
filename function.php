<?php

//Create Database conection-------------------------
function dbConn() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "nce";

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("Database Error : " . $conn->connect_error);
    }else{
        return $conn;
    }
}
//End Database conection----------------------------


//Data Clean-----------------------------
function dataClean($data = null) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
//End Data Clean-----------------------------

?>