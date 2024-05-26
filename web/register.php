<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Register</h1>
</div>
<!-- Single Page Header End -->


<!-- Register Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-primary">Registration Form</h1>
                        <p class="mb-4">Register for our great service.</p>
                    </div>
                </div>

                <div class="">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        extract($_POST);
                        $first_name = dataClean($first_name);
                        $last_name = dataClean($last_name);
                        $address_line_1 = dataClean($address_line_1);
                        $address_line_2 = dataClean($address_line_2);
                        $city = dataClean($city);
                        $district = dataClean($district);
                        $contact_mobile = dataClean($contact_mobile);
                        $alt_mobile = dataClean($alt_mobile);
                        $email = dataClean($email);
                        $user_name = dataClean($user_name);

                        $message = array();
                        //Required validation-----------------------------------------------
                        if (empty($first_name)) {
                            $message['first_name'] = "First Name is required...!";
                        }
                        if (empty($last_name)) {
                            $message['last_name'] = "Last Name is required...!";
                        }
                        if (empty($address_line_1)) {
                            $message['address_line_1'] = "Address Line 1 is required...!";
                        }
                        if (empty($city)) {
                            $message['city'] = "City is required...!";
                        }
                        if (empty($district)) {
                            $message['district'] = "District is required...!";
                        }
                        if (empty($contact_mobile)) {
                            $message['contact_mobile'] = "Contact Mobile is required...!";
                        }
                        if (empty($email)) {
                            $message['email'] = "Email Address is required...!";
                        }
                        if (empty($user_name)) {
                            $message['user_name'] = "User Name is required...!";
                        }
                        if (empty($password)) {
                            $message['password'] = "Password is required...!";
                        }
//                        if (empty($confirm_password)) {
//                            $message['confirm_password'] = "Confirm Password is required...!";
//                        }

                        
                        //Advance validation------------------------------------------------
                        if (ctype_alpha(str_replace(' ', '', $first_name)) === false) {
                            $message['first_name'] = "Only letters and white space allowed";
                        }
                        if (ctype_alpha(str_replace(' ', '', $last_name)) === false) {
                            $message['last_name'] = "Only letters and white space allowed";
                        }

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $message['email'] = "Invalid Email Address...!";
                        } else {
                            $db = dbConn();
                            $sql = "SELECT * FROM customers WHERE Email='$email'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $message ['email'] = "This Email Address is already exist...!";
                            }
                        }

                        if (!empty($user_name)) {
                            $db = dbConn();
                            $sql = "SELECT * FROM users WHERE UserName='$user_name'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $message ['user_name'] = "This User Name is already exist...!";
                            }
                        }

                        if (!empty($password)) {
                            if (strlen($password) < 8) {
                                $message['password'] = "Password should be 8 characters more...!";
                            }
                        }
                        
//                         if (!empty($confirm_password)) {
//                            if (strlen($confirm_password) < 8) {
//                                $message['confirm_password'] = "Confirm Password should be 8 characters more...!";
//                            }
//                        }


                        if (empty($message)) {
                            //Use bcrypt hashing algorithm
                            $pw = password_hash($password, PASSWORD_DEFAULT);
                            $db = dbConn();
                          //youhave to check the query
                            echo $sql = "INSERT INTO `users`(`UserName`, `Password`,`UserType`) VALUES ('$user_name','$pw' , 'customer')";
                            $db->query($sql);

                            $user_id = $db->insert_id;
                            $reg_number = date('Y') . date('m') . date('d') . $user_id;
                            $_SESSION['RNO'] = $reg_number;

                           echo $sql = "INSERT INTO `customers`(`FirstName`, `LastName`, `AddressLine1`, `AddressLine2`, `City`, `DistrictId`, `ContactMobile`, `AlternateMobile`, `Email`, `RegNo`, `UserId`) VALUES ('$first_name','$last_name','$address_line_1','$address_line_2','$city','$district','$contact_mobile','$alt_mobile','$email', '$reg_number' , '$user_id')";
                            $db->query($sql);

                            $msg = "<h1>Success</h1>";
                            $msg .= "<h2>Congratulation</h2>";
                            $msg .= "<p>Yor account has been successfully created</p>";
                            $msg .= "<a href = 'http://localhost/nce/verify.php'>Click here to verify your account</a>";
                            sendEmail($email, $first_name, "Account Verification", $msg);

                            header("Location:register_success.php");
                        }
                    }
                    ?>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name<span style = "color : red;"> * </span></label>
                                <input type="text" name="first_name" class="form-control border border-1 mb-4" id="first_name" value="<?= @$first_name ?>" placeholder="Enter First Name" required>
                                <span class="text-danger"><?= @$message['first_name'] ?></span>

                            </div>
                            <div class="form-group col-md-6 mt-3 mt-md-0">
                                <label for="last_name">Last Name<span style = "color : red;"> * </span></label>
                                <input type="text" name="last_name" class="form-control border border-1 mb-4" id="last_name" value="<?= @$last_name ?>" placeholder="Enter Last Name" required>
                                <span class="text-danger"><?= @$message['last_name'] ?></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="address_line_1">Address Line 1<span style = "color : red;"> * </span></label>
                                <input type="text" name="address_line_1" class="form-control border border-1 mb-4" id="address_line_1" value="<?= @$address_line_1 ?>" placeholder="Enter Address Line 1" required>
                                <span class="text-danger"><?= @$message['address_line_1'] ?></span>
                            </div>
                            <div class="form-group col-md-6 mt-3 mt-md-0">
                                <label for="address_line_2">Address Line 2 (Optional)</label>
                                <input type="text" name="address_line_2" class="form-control border border-1 mb-4" id="address_line_2" value="<?= @$address_line_2 ?>" placeholder="Enter Address Line 2">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="city">City<span style = "color : red;"> * </span></label>
                                <input type="text" name="city" class="form-control border border-1 mb-4" id="city" value="<?= @$city ?>" placeholder="Enter City" required>
                                <span class="text-danger"><?= @$message['city'] ?></span>
                            </div>
                            <div class="form-group col-md-6">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM  districts";
                                $result = $db->query($sql);
                                ?>
                                <label for="district">District<span style = "color : red;"> * </span></label>
                                <select name="district" id="district"  class="form-select mb-4 border border-1" value="<?= @$district ?>" aria-label="Large select example">
                                    <option value="" >Select District</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?= @$message['district'] ?></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="contact_mobile">Contact Mobile<span style = "color : red;"> * </span></label>
                                <input type="text" name="contact_mobile" class="form-control border border-1 mb-4" id="contact_mobile" value="<?= @$contact_mobile ?>" placeholder="Enter Contact Mobile" required>
                                <span class="text-danger"><?= @$message['contact_mobile'] ?></span>
                            </div>
                            <div class="form-group col-md-6 mt-3 mt-md-0">
                                <label for="alt_mobile">Alternate Mobile (Optional)</label>
                                <input type="text" name="alt_mobile" class="form-control border border-1 mb-4" id="alt_mobile" value="<?= @$alt_mobile ?>" placeholder="Enter Alternate Mobile">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Email Address<span style = "color : red;"> * </span></label>
                                <input type="text" name="email" class="form-control border border-1 mb-4" id="email" value="<?= @$email ?>" placeholder="Enter Email Address" required>
                                <span class="text-danger"><?= @$message['email'] ?></span>
                            </div>
                            <div class="form-group col-md-6 mt-3 mt-md-0">
                                <label for="user_name">User Name<span style = "color : red;"> * </span></label>
                                <input type="text" name="user_name"  class="form-control border border-1 mb-4" id="user_name" value="<?= @$user_name ?>" placeholder="Enter User Name" required>
                                <span class="text-danger"><?= @$message['user_name'] ?></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="password">Password<span style = "color : red;"> * </span></label>
                                <input type="password" name="password" class="form-control border border-1 mb-4" id="password" value="<?= @$password ?>" placeholder="Enter Password" required>
                                <span class="text-danger"><?= @$message['password'] ?></span>
                            </div>
                            
                        </div>

                        <button class="btn form-control border-secondary py-3 bg-white text-primary " type="submit">Submit</button>


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