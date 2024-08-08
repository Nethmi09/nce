

<!-- Get Product count -->
<?php
include '../../function.php'; 

$db=dbConn();
$sql="SELECT COUNT(*) AS 'NUMOFProducts' FROM products";
$result=$db->query($sql);
$row=$result->fetch_assoc();


echo $row['NUMOFProducts'];
?>