<?php

include '../../function.php';

$db = dbConn();
$sql = "SELECT COUNT(*) AS 'NUMOFMESSAGES' FROM contactus_messages";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NUMOFMESSAGES'];
