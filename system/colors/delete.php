<?php
include_once '../init.php'; // Include initialization script for database connection and other settings

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to delete a color based on the ColorId from the URL
    extract($_GET);
    $db = dbConn(); // Establish a database connection
    $sql = "DELETE FROM colors WHERE ColorId = '$colorid'"; // SQL query to delete the color
    $db->query($sql); // Execute the query

    // Redirect to the color management page after deletion
    header("Location:manage.php");
}
?>
