<?php

include '../../function.php';

$db = dbConn();
$sql = "SELECT COUNT(*) AS 'NOOFROLES' FROM user_role WHERE Status=1";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFROLES'];
