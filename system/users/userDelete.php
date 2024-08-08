<?php
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE users FROM users WHERE users.UserId = '$userid'";
    $db->query($sql); 
    header("Location:userManage.php");
}
?>