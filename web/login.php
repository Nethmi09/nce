<?php
ob_start();
session_start();
include 'header.php';
include '../config.php';
include '../function.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Login</h1>
</div>
<!-- Single Page Header End -->

<!-- Login Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-primary">Account Login</h1>
                        <h4 class="text-primary">
                            Don't have an account?
                            <a href="register.php" class="text-primary" style="text-decoration: underline;">Register Now</a>
                        </h4>

                    </div>
                </div>

                <div class="">

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
                            $sql = "SELECT * FROM users u INNER JOIN customers c ON c.UserId=u.UserId WHERE u.UserName='$username'";

                            $result = $db->query($sql);

                            if ($result->num_rows == 1) {
                                $row = $result->fetch_assoc();

                                if (password_verify($password, $row['Password'])) {
                                    $_SESSION['USERID'] = $row['UserId'];
                                    $_SESSION['FIRSTNAME'] = $row['FirstName'];
                                    $_SESSION['LASTNAME'] = $row['LastName'];
                                    $_SESSION['EMAIL'] = $row['Email'];
                                    $_SESSION['CONTACTMOBILE'] = $row['ContactMobile'];
                                    $_SESSION['ALTERNATEMOBILE'] = $row['AlternateMobile'];
                                    $_SESSION['ADDRESSLINE1'] = $row['AddressLine1'];
                                    $_SESSION['ADDRESSLINE2'] = $row['AddressLine2'];
                                    $_SESSION['CITY'] = $row['City'];
                                    $_SESSION['DISTRICT'] = $row['DistrictId'];
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

                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate="">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="username"><b>User Name</b><span style = "color : red;"> * </span></label>
                                <input type="text" name="username" class="form-control border border-1 mb-4" id="username" placeholder="Enter User Name" required>
                                <span class="text-danger"><?= @$message['username'] ?></span>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="password"><b>Password</b><span style = "color : red;"> * </span></label>
                                <input type="password" name="password" class="form-control border border-1 mb-4" id="password" placeholder="Enter Password" required>
                                <span class="text-danger"><?= @$message['password'] ?></span>
                            </div>
                        </div>
                        <br>
                        <button class="btn form-control border-secondary py-3 bg-white text-primary " type="submit">Login</button>

                        <div class="forgot-password text-center mt-3">
                            <a href="forgot_password.php">Forgot your password?</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Login Form End -->


<?php
include 'footer.php';
ob_end_flush();
?> 