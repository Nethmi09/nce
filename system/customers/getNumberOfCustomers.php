

<!-- get employee count -->
<?php
include '../../function.php'; 

$db=dbConn();
$sql="SELECT COUNT(*) AS 'NUMOFCUSTOMERS' FROM customers";
$result=$db->query($sql);
$row=$result->fetch_assoc();


echo $row['NUMOFCUSTOMERS'];
?>
