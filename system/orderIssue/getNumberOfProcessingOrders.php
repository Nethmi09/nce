<?php

include '../../function.php';

$db = dbConn();
$sql = "SELECT COUNT(*) AS 'NOOFPPO' FROM orders WHERE OrderStatus=2";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFPPO'];
