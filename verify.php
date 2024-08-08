<?php

include 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);

    $db = dbConn();
    $sql = "SELECT * FROM users WHERE token='$token' AND is_verified=0";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $UserId = $row['UserId'];

        $sql = "UPDATE users SET is_verified=1,token=null WHERE UserID='$UserId'";
        $db->query($sql);

        echo "Your account has been verified!. You can now access the dashboard.";
        echo "<a href='web/login.php'>Login</a>";
    } else {
        echo "Invalid or expired token.";
    }
}
?>