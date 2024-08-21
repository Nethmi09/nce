<?php

include '../../function.php';

$db = dbConn();
$sql = "SELECT COUNT(*) AS 'NOOFPO' FROM orders WHERE OrderStatus=3";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFPO'];
