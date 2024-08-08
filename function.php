<?php

//Create Database conection--------------------------
function dbConn() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "nce";

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("Database Error : " . $conn->connect_error);
    } else {
        return $conn;
    }
}

//End Database conection----------------------------

//Data Clean----------------------------------------
function dataClean($data = null) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

//End Data Clean-----------------------------------
//Check logging User Type--------------------------
//function checkUserType($usertype = null) {
//    if (session_status() == PHP_SESSION_NONE) {
//        session_start();
//    }
//    $user_id = $_SESSION['USERID'];
//    $db = dbConn();
//    $sql = "SELECT * FROM users u WHERE u.UserId='$user_id' AND u.UserType='$usertype' ";
//    $result = $db->query($sql);
//
//    if ($result->num_rows <= 0) {
//        header("Location:../unauthorized.php");
//        return false;
//    } else {
//        return true;
//    }
//}

//End Check logging User Type----------------------

//Assign Privilege---------------------------------
function checkprivilege($module_id = null) {
    session_start();
    $user_id = $_SESSION['USERID'];
    $db = dbConn();
    $sql = "SELECT * FROM user_modules u WHERE u.UserId='$user_id' AND u.ModuleId='$module_id'";

    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows <= 0) {
         header("Location:../unauthorized.php");
        return false;
    } else {
        return $row;
    }
}
//End Assign Privilege---------------------------------



?>


