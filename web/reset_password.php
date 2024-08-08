<?php
ob_start();
session_start();
include 'header.php';
include '../config.php';
include '../mail.php';
include '../function.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Reset Password</h1>
</div>
<!-- Single Page Header End -->

<!-- Reset Password Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="">
                    
                    <?php
                    extract($_GET);
                    extract($_POST);
                    $db = dbConn();
                   $sql = "SELECT u.Email FROM users u
                   INNER JOIN customers c ON c.UserId=u.UserId
                   WHERE u.token='$token' AND reset_expiration > NOW()";
                    $result = $db->query($sql);
                    if ($result->num_rows <= 0) {
                        $message['Email'] = "The password reset link is now invalid.";
                    }

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        if (empty($password)) {
                            $message['password'] = "Password is required";
                        }
                        if (empty($confirm_password)) {
                            $message['confirm_password'] = "Confirm Password is required";
                        }
                        if (!empty($password)) {
                            if (strlen($password) < 8) {
                                $message['password'] = "The password should be 8 characters more";
                            }
                        }
                        if (!empty($password && $confirm_password)) {
                            if ($password != $confirm_password) {
                                $message['confirm_password'] = "The password do not match";
                            }
                        }
                        if (empty($message)) {
                            $db = dbConn();
                            $pw = password_hash($password, PASSWORD_DEFAULT);
                            $conpw = password_hash($confirm_password, PASSWORD_DEFAULT);
                            // Verify the reset token and check if it's still valid
                            $sql = "SELECT u.Email FROM users u
                   INNER JOIN customers c ON c.UserId=u.UserId
                   WHERE u.token='$token' AND reset_expiration > NOW()";

                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $Email = $row['Email'];
                                echo $sql_update_password = "UPDATE users u
                                SET u.Password='$pw', u.ConfirmPassword='$conpw', u.token=null,u.reset_expiration=NULL
                                WHERE u.Email='$Email'";
                                if ($db->query($sql_update_password) === TRUE) {
                                    $message['Email'] = "Your password has been reset successfully.";
                                    header("Location:login.php");
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
                            } 
                        }
                    }
                    ?>
                    <h1><span class="text-danger"><?= @$message['Email'] ?></span></h1>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form"
                          class="php-email-form loginbgcolor" novalidate>

                        <div class="form-group mt-3">
                            <label for="Email"><b>New Password</b><span style="color : red;"> * </span></label>
                            <input type="password" class="form-control border border-1 mb-4" name="password"
                                   id="password" placeholder="Password">
                            <span class="text-danger"><?= @$message['password'] ?></span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="Email"><b>Confirm Password</b><span style="color : red;"> * </span></label>
                            <input type="password" class="form-control border border-1 mb-4"
                                   name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                            <span class="text-danger"><?= @$message['confirm_password'] ?></span>
                        </div>

                        <input type="hidden" name="token" value="<?php echo @$token; ?>">
                        <br>
                        <div><button class="btn form-control border-secondary py-3 bg-white text-primary " type="submit">Reset Password</button></div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reset Password Form End -->

<?php
include 'footer.php';
ob_end_flush();
?>
