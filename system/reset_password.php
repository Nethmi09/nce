<?php
include 'init.php';
include '../mail.php';
?> 

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NCE | Dashboard</title>

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
        <!-- JQVMap -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/jqvmap/jqvmap.min.css">
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
        <!-- summernote -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/summernote/summernote-bs4.min.css">
        <!-- MyStyleFile -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/newstyle.css" type="text/css"/>

        <style>
            body, html {
                height: 100%;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #f4f6f9;
            }

            .contact {
                width: 100%;
                max-width: 500px;
            }

            .form-container {
                padding: 30px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            .form-container h1 {
                margin-bottom: 20px;
            }
            
            .login-link {
                margin-top: 10px;
                text-align: center;
            }
        </style>
    </head>

    <body>

        <!-- Reset Password Form Start -->
        <div class="contact">
            <div class="form-container">
                <div class="row g-4">
                    <div class="">
                    
                        <?php
                        extract($_GET);
                        extract($_POST);
                        $db = dbConn();
                        $sql = "SELECT u.Email FROM users u 
                        WHERE u.token='$token' AND reset_expiration > NOW()";
                        $result = $db->query($sql);
                        
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
                        <h1 class="text-center">Reset Password</h1>
                        <br>
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
                            <div class="text-center"><button class="btn btn-primary" type="submit">Reset Password</button></div>
                            <div class="login-link text-center mt-3">
                                <a href="login.php">Back to Login</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Reset Password Form End -->

        <!-- jQuery -->
        <script src="assets/plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
        <script src="assets/plugins/chart.js/Chart.min.js"></script>
        <!-- Sparkline -->
        <script src="assets/plugins/sparklines/sparkline.js"></script>
        <!-- JQVMap -->
        <script src="assets/plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="assets/plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="assets/plugins/moment/moment.min.js"></script>
        <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Summernote -->
        <script src="assets/plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="assets/dist/js/adminlte.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="assets/dist/js/demo.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="assets/dist/js/pages/dashboard.js"></script>
    </body>
</html>
