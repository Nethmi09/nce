<?php
session_start();
include '../function.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NCE | Log in</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
   
         <!-- Custom styles -->
    <style>
        body {
            background-image: url('assets/dist/img/credit/background-image-dark.jpg'); /* Specify the path to your background image */
            background-size: cover; /* Cover the entire background */
            background-position: left; /* Align the background image to the left */
        }
        .login-box-container {
            display: flex;
            align-items: center;
   
        }
        .login-box {
            width: 600px;
            background: rgba(255, 255, 255, 0.8); /* Make the background of the login box semi-transparent */
            padding: 30px; /* Add padding for spacing */
            border-radius: 10px; /* Add border radius for rounded corners */
        }
        .login-box .form-control {
            background: rgba(255, 255, 255, 1); /* Make the input fields semi-transparent */          
            border-radius: 5px; /* Add border radius for rounded corners */
        }
        
        .login-box .btn-primary {
            background-color: #8FC1E3; /* Change button background color */
            border-color: #007bff; /* Change button border color */
            border-radius: 5px; /* Add border radius for rounded corners */
        }
        
         .forgot-password {
            text-align: center; /* Center the forgot password link */
            margin-top: 10px; /* Add some margin at the top */
        }
       
    </style>
   
    </head>
    
    <body class="hold-transition login-page">
           <div class="login-box-container">
        <div class="login-box">
            <div class="login-logo">

                <a><b>Welcome Back!</b></a>
            </div>

            <!-- /.login-logo -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                extract($_POST);

                $username = dataClean($username);

                $message = array();

                if (empty($username)) {
                    $message['username'] = "User Name is required...!";
                }
                if (empty($password)) {
                    $message['password'] = "Password is required...!";
                }

                if (empty($message)) {
                    $db = dbConn();
                    $sql = "SELECT * FROM users u INNER JOIN employees e ON e.UserId=u.UserId WHERE u.UserName='$username'";

                    $result = $db->query($sql);

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();

                        if (password_verify($password, $row['Password'])) {
                            $_SESSION['USERID'] = $row['UserId'];
                            $_SESSION['FIRSTNAME'] = $row['FirstName'];
                             $_SESSION['LASTNAME'] = $row['LastName'];
                            header("Location:dashboard.php");
                        } else {
                            $message['password'] = "Invalid User Name or Password...!";
                        }
                    } else {
                        $message['password'] = "Invalid User Name or Password...!";
                    }
                }
            }
            ?>

           
       
                    <p class="login-box-msg">Enter your Email and Password to Login.</p>

                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter Your User Name">
                          
                        </div>
                        <div class="input-group mb-3">

                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password">
                            
                        </div>



                        <div class="row">
                            <div class="col-12 mb-3">
                                <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                            </div>
                        </div>
                    </form>

                    <!-- /.social-auth-links -->

                    <div class="forgot-password">
                <a href="forgot-password.html">Forgot your password?</a>
            </div>

                    <div class="text-danger"><?= @$message['username'] ?></div>
                    <div class="text-danger"><?= @$message['password'] ?></div>

             
                <!-- /.login-card-body -->
          
        </div>
                 </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="assets/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="assets/dist/js/adminlte.min.js"></script>
    </body>
</html>