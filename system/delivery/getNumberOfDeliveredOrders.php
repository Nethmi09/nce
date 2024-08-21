<?php

include '../../function.php';

$db = dbConn();
$sql = "SELECT COUNT(*) AS 'NOOFDO' FROM orders WHERE OrderStatus=5";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFDO'];
