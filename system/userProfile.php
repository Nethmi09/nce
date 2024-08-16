<?php
ob_start();
include_once 'init.php';

$link = "User Profile Management";
$breadcrumb_item = "Profile";
$breadcrumb_item_active = "Manage";
?>


<?php
$content = ob_get_clean(); // Capture the output buffer content
include 'layouts.php'; // Include the layout for the page
?>