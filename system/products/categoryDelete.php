<?php
include_once '../init.php'; //Include initialization script for database connection and other settings

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
     // Handle GET request to delete a category based on the CategoryId from the URL
    extract($_GET);
    $db = dbConn(); // Establish database connection
    $sql = "DELETE FROM categories WHERE CategoryId = '$categoryid'"; // SQL query to delete the category
    $db->query($sql); // Execute the query
     // Redirect to the category management page after deletion
    header("Location:categoryManage.php");
}
?>