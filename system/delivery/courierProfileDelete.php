<?php
include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE FROM courier_service WHERE CourierServiceId = '$courierProfileId'";
    $db->query($sql); 
    header("Location:courierProfileManage.php");
}
?>