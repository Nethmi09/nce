<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Colombo');
include 'header.php';
include '../config.php';
include '../mail.php';
include '../function.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Forgot Password</h1>
</div>
<!-- Single Page Header End -->

<!-- Forgot Password Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="">
                    <?php
                    

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        extract($_POST);
                        //Create a unique reset token
                        $reset_token = bin2hex(random_bytes(16));
                        // Calculate the token expiration time (1 hour from now)
                        $expiration_time = date("Y-m-d H:i:s", strtotime("+1 hour"));
                        $db = dbConn();
                        $sql = "UPDATE users u INNER JOIN customers c ON c.UserId = u.UserId
                                    SET u.token = '$reset_token', u.reset_expiration='$expiration_time'
                                    WHERE c.Email = '$email'";

                        $db->query($sql);
                        $sql = "SELECT * FROM users u
                                               INNER JOIN customers c ON c.UserId = u.UserId
                                               WHERE c.Email = '$email'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $email = $row['Email'];
                        $first_name = $row['FirstName'];

                        if ($result->num_rows > 0) {
                            $reset_link = "http://localhost/nce/web/reset_password.php?token=$reset_token";
                            $msg = "<h1>Reset Password</h1>";
                            $msg .= "<p>Hi, click the link below to reset your password.</p>";
                            $msg .= "<p>This link will expire within 1 hour.</p>";
                            $msg .= "<a href='$reset_link'>Reset Your Password</a>";

                            sendEmail($email, $first_name, "Password Reset Request", $msg);
                        }
                    }
                    ?> 


                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Form End -->

<?php
include 'footer.php';
ob_end_flush();
?>
