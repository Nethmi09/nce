<?php
include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE FROM products WHERE ProductId = '$productid'";
    $db->query($sql); 
    header("Location:productManage.php");
}
?>