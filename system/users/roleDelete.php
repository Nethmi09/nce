<?php
include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE FROM user_role WHERE Id = '$roleid'";
    $db->query($sql); 
    header("Location:roleManage.php");
}
?>