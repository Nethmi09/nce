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
    <h1 class="text-center text-white display-6">Contact Us</h1>
</div>
<!-- Single Page Header End -->

<!-- Contact Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-primary">Get in touch</h1>
                        <p class="mb-4">We can't solve your problem if you don't tell us about it!</p>
                    </div>
                </div>

                <div class="col-lg-7">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        extract($_POST);
                        $full_name = dataClean($full_name);
                        $email = dataClean($email);
                        $msg = dataClean($msg);

                        $message = array();

                        //Required validation-----------------------------------------------
                        if (empty($full_name)) {
                            $message['full_name'] = "Full Name is required...!";
                        }
                        if (empty($email)) {
                            $message['email'] = "Email is required...!";
                        }
                        if (empty($msg)) {
                            $message['msg'] = "Message is required...!";
                        }


                        //Advance validation------------------------------------------------

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $message['email'] = "Invalid Email Address...!";
                        }

                        if (empty($message)) {

                            $db = dbConn();
                            $sql = "INSERT INTO contactus_messages(Name,Email,Message) VALUES ('$full_name', '$email','$msg')";
                            $db->query($sql);
                            $Id = $db->insert_id;

                            header("Location:contactus_messsage_success.php");
                        }
                    }
                    ?>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate>
                        <div class="form-group">
                            <label for="full_name" class="form-label fw-bold">Full Name<span style = "color : red;"> * </span></label>
                            <input type="text" name="full_name" id="full_name" value="<?= @$full_name ?>" class="form-control border border-1 mb-1" placeholder="Enter Your Name"required>
                            <span class="text-danger"><?= @$message['full_name'] ?></span>
                            <br>
                            <label for="email" class="form-label fw-bold">Email Address<span style = "color : red;"> * </span></label>
                            <input type="email" name="email" id="email" value="<?= @$email ?>" class="form-control border border-1 mb-1" placeholder="Enter Your Email" required>
                            <span class="text-danger"><?= @$message['email'] ?></span>
                            <br>
                            <label for="msg" class="form-label fw-bold">Message<span style = "color : red;"> * </span></label>
                            <textarea class="form-control border border-1 mb-1" type="text" name="msg" id="msg" rows="3" value="<?= @$msg ?>"  placeholder="Enter Your Message"></textarea>
                            <span class="text-danger"><?= @$message['msg'] ?></span>
                            <br>
                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary " type="submit">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Address</h4>
                            <p class="mb-2">358/A, Henegama road, Radawana</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Mail Us</h4>
                            <p class="mb-2">namarathnagroup@gmail.com</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded bg-white">
                        <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Telephone</h4>
                            <p class="mb-2">0712056162</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Form End -->

<?php
include 'footer.php';
ob_end_flush();
?> 