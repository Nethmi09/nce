<?php
include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE FROM employees WHERE EmployeeId = '$employeeid'";
    $db->query($sql); 
    header("Location:manage.php");
}
?>