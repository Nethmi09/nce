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
                        $Email = dataclean($Email);
                        
                        $message = array();
                        
                         // Required Validation

                        if (empty($Email)) {
                            $message['Email'] = "The email should not be empty...!";
                        } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                            $message['Email'] = "Invalid email format...!";
                        }

                        if (empty($message)) {
                            $db = dbConn();
                            $sql = "UPDATE users u INNER JOIN customers c ON c.UserId = u.UserId
                                    SET u.token = '$reset_token', u.reset_expiration='$expiration_time'
                                    WHERE c.Email = '$Email'";
                            if ($db->query($sql) === TRUE && $db->affected_rows > 0) {
                                $sql_select = "SELECT * FROM users u
                                               INNER JOIN customers c ON c.UserId = u.UserId
                                               WHERE c.Email = '$Email'";
                                $result = $db->query($sql_select);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $myemail = $row['Email'];
                                    $first_name = $row['FirstName'];

                                    $reset_link = "http://localhost/nce/web/reset_password.php?token=$reset_token";

                                    $msg = "<h1>Reset Password</h1>";
                                    $msg .= "<p>Hi, click the link below to reset your password.</p>";
                                    $msg .= "<p>This link will expire within 1 hours.</p>";
                                    $msg .= "<a href='$reset_link'>Reset Your Password</a>";

                                    sendEmail($myemail, $first_name, "Password Reset Request", $msg);

                                    
                                }
                            } else {
                                $message['Email'] = "Email not found! Are you sure you are already a member?";
                            }
                        }
                    }
                    ?> 

                    <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate="">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Email"><b>Email</b><span style="color : red;"> * </span></label>
                                <input type="email" name="Email" class="form-control border border-1 mb-4" id="Email" placeholder="Enter Email Address" required>
                                <span class="text-danger"><?= @$message['Email'] ?></span>
                            </div>
                        </div>
                        <br>
                        <button class="btn form-control border-secondary py-3 bg-white text-primary " type="submit">Send Password Reset Link</button>
                        <div class="login-link text-center mt-3">
                            <a href="login.php">Back to Login</a>
                        </div>
                    </form>
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
