<?php

include '../../function.php';

$db = dbConn();
$sql = "SELECT COUNT(*) AS 'NOOFUSERS' FROM users WHERE Status=1";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFUSERS'];
