<?php
ob_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Add";
?> 




<?php
$content = ob_get_clean();
include '../layouts.php';
?>