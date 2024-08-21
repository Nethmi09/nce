<?php

include '../../function.php';

$db = dbConn();
$sql = "SELECT COUNT(*) AS 'NOOFSO' FROM orders WHERE OrderStatus=4";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFSO'];
