<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';
include '../config.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Resend Email</h1>
</div>
<!-- Single Page Header End -->


<!-- Register Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="" style="max-width: 700px;">
                         <h5 class="">It seems you haven't received the verification email. Please enter your email address again to resend the verification email.</h5>
                    </div>
                </div>

                <div class="">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        extract($_POST);

                        $db = dbConn();

                        $sql = "SELECT * FROM customers C LEFT JOIN users U ON U.UserId=C.UserId  WHERE C.Email='$email'";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $myemail = $row['Email'];
                            $UserId = $row['UserId'];
                            $first_name = $row['FirstName'];
                            $token = bin2hex(random_bytes(16));

                            $sql = "UPDATE users SET token='$token', is_verified='0' WHERE UserId='$UserId'";
                            $db->query($sql);

                            $msg = "<h1>SUCCESS</h1>";
                            $msg .= "<h2>Congratulations</h2>";
                            $msg .= "<p>Your account has been successfully created</p>";
                            $msg .= "<a href='http://localhost/bittest/verify.php?token=$token'>Click here to verifiy your account</a>";
                            sendEmail($myemail, $first_name, "Account Verification", $msg);

                            echo "Verification email has been sent..!";
                        } else {
                            echo "Your enter wrong email address!, please check your email address agian.";
                        }
                    }
                    ?>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="" style="max-width: 700px;">
                        <label>Enter Your Email Address</label>
                        <input type="text" name="email">
                        <button type="submit">Resend</button>
                        </div>
                    </form> 
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Register Form End -->


<?php
include 'footer.php';
ob_end_flush();
?> 