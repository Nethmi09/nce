<?php
include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE FROM user_modules WHERE Id = '$permissionid'";
    $db->query($sql); 
    header("Location:permissionManage.php");
}
?>