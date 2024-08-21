<?php

include '../../function.php';

$db = dbConn();
$sql = "SELECT COUNT(*) AS 'NOOFAC' FROM orders WHERE OrderStatus=7";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFAC'];
