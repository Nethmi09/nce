<?php
include_once '../init.php'; //Include initialization script for database connection and other settings

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to delete a brand based on the BrandId from the URL
    extract($_GET);
    $db = dbConn();// Execute the query
    $sql = "DELETE FROM brands WHERE BrandId = '$brandid'"; // SQL query to delete the brand
    $db->query($sql); // Execute the query
    // Redirect to the brand management page after deletion
    header("Location:brandManage.php");
}
?>