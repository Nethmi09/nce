<?php
include_once 'init.php';
include '../mail.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NCE | Forgot Password</title>

    <!-- Favicon -->
    <link rel="icon" href="<?= SYS_URL ?>assets/dist/img/NCE-Logo-1.jpg" type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- Summernote -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/summernote/summernote-bs4.min.css">
    <!-- MyStyleFile -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/newstyle.css" type="text/css"/>

    <style>
        html, body {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            background-color: #f4f6f9;
        }

        .contact {
            max-width: 100%;
        }

        .form-container {
            max-width: 600px;
            background: #fff;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- Forgot Password Form Start -->
<div class="container-fluid contact py-5">
    <div class="form-container">
        <div class="text-center">
            <h1>Forgot Password</h1>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);
            // Create a unique reset token
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
                $sql = "UPDATE users u INNER JOIN employees e ON e.UserId = u.UserId
                        SET u.token = '$reset_token', u.reset_expiration='$expiration_time'
                        WHERE e.Email = '$Email'";
                if ($db->query($sql) === TRUE && $db->affected_rows > 0) {
                    $sql_select = "SELECT * FROM users u
                                   INNER JOIN employees e ON e.UserId = u.UserId
                                   WHERE e.Email = '$Email'";
                    $result = $db->query($sql_select);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $myemail = $row['Email'];
                        $first_name = $row['FirstName'];

                        $reset_link = "http://localhost/nce/system/reset_password.php?token=$reset_token";

                        $msg = "<h1>Reset Password</h1>";
                        $msg .= "<p>Hi, click the link below to reset your password.</p>";
                        $msg .= "<p>This link will expire within 1 hour.</p>";
                        $msg .= "<a href='$reset_link'>Reset Your Password</a>";

                        sendEmail($myemail, $first_name, "Password Reset Request", $msg);
                    }
                } else {
                    $message['Email'] = "Email not found! Are you sure you are already a member?";
                }
            }
        }
        ?>

        <form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post" class="mt-4" novalidate="">
            <div class="form-group">
                <label for="Email"><b>Email</b><span style="color: red;"> * </span></label>
                <input type="email" name="Email" class="form-control border border-1 mb-4" id="Email" placeholder="Enter Email Address" required>
                <span class="text-danger"><?= @$message['Email'] ?></span>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" type="submit">Send Password Reset Link</button>
            </div>
            <div class="login-link text-center mt-3">
                <a href="login.php">Back to Login</a>
            </div>
        </form>
    </div>
</div>
<!-- Forgot Password Form End -->

<!-- jQuery -->
<script src="<?= SYS_URL ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= SYS_URL ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= SYS_URL ?>assets/dist/js/adminlte.js"></script>

</body>
</html>
