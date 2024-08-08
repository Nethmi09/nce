

<!-- Get employee count -->
<?php
include '../../function.php'; 

$db=dbConn();
$sql="SELECT COUNT(*) AS 'NUMOFEMPLOYEES' FROM employees";
$result=$db->query($sql);
$row=$result->fetch_assoc();


echo $row['NUMOFEMPLOYEES'];
?>

