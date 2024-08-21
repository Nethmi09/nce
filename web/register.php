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
                        <h4 class="text-primary">
                            Already have an account?
                            <a href="register.php" class="text-primary" style="text-decoration: underline;">Login</a>
                        </h4>
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
                        $password = dataClean($password);
                        $confirm_password = dataClean($confirm_password);

                        $message = array();
                        //Required validations-----------------------------------------------
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
                        if (empty($confirm_password)) {
                            $message['confirm_password'] = "Confirm Password is required...!";
                        }

                        //Advance validations------------------------------------------------
//                        if (ctype_alpha(str_replace(' ', '', $first_name)) === false) {
//                            $message['first_name'] = "Only letters and white space allowed";
//                        }
//                        if (ctype_alpha(str_replace(' ', '', $last_name)) === false) {
//                            $message['last_name'] = "Only letters and white space allowed";
//                        }
//                        
//                        
                        // Mobile Number validation----------------------
                        if (!empty($contact_mobile)) {
                            $mobilelength = strlen($contact_mobile);
                            if ($mobilelength == 10) {
                                if ($contact_mobile === '0000000000') {
                                    $message['contact_mobile'] = "Please enter a valid mobile number";
                                } if ($contact_mobile === '1111111111') {
                                    $message['contact_mobile'] = "Please enter a valid  mobile number";
                                } if ($contact_mobile === '0123456789') {
                                    $message['contact_mobile'] = "Please enter a  proper mobile number";
                                }
                            } else {
                                $message['contact_mobile'] = "The mobile bnumber should must have only 10 numbers";
                            }
                        }
                        
                        
                        
                        // Email validation(Email already exist or not)----------------------

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

                        // User Name validation(User name already exist or not)-------------

                        if (!empty($user_name)) {
                            $db = dbConn();
                            $sql = "SELECT * FROM users WHERE UserName='$user_name'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $message ['user_name'] = "This User Name is already exist...!";
                            }
                        }

                        //Password Validation(password stength)------------------------------------------------

                        if (!empty($password)) {
                            $uppercase = preg_match('@[A-Z]@', $password);
                            $lowercase = preg_match('@[a-z]@', $password);
                            $number = preg_match('@[0-9]@', $password);
                            $specialChars = preg_match('@[^\w]@', $password);

                            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                                $message['password'] = 'Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.';
                            }
                        }

                        //Confirm Password Validation(confirm password stength)--------------------------------

                        if (!empty($confirm_password)) {
                            $uppercase = preg_match('@[A-Z]@', $confirm_password);
                            $lowercase = preg_match('@[a-z]@', $confirm_password);
                            $number = preg_match('@[0-9]@', $confirm_password);
                            $specialChars = preg_match('@[^\w]@', $confirm_password);

                            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($confirm_password) < 8) {
                                $message['confirm_password'] = 'Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.';
                            }
                        }

                        // Check password and confirm password same
                        if ($password != $confirm_password) {
                            $message['confirm_password'] = "Password and confirm password should be the same";
                        }


                        if (empty($message)) {
                            //Use bcrypt hashing algorithm
                            $pw = password_hash($password, PASSWORD_DEFAULT);
                            $conpw = password_hash($confirm_password, PASSWORD_DEFAULT);

                            $db = dbConn();
                            $token = bin2hex(random_bytes(16));

                            //Insert data to users table
                            echo $sql = "INSERT INTO users(UserName, Password, ConfirmPassword, FirstName, LastName, Email, UserType, token, is_verified) VALUES ('$user_name','$pw','$conpw','$first_name','$last_name','$email','customer','$token','0')";
                            $db->query($sql);
                            $user_id = $db->insert_id;
                            $reg_number = date('Y') . date('m') . date('d') . $user_id;
                            $_SESSION['RNO'] = $reg_number;

                            echo $sql = "INSERT INTO customers(FirstName, LastName, AddressLine1, AddressLine2, City, DistrictId, "
                                    . "ContactMobile, AlternateMobile, Email, RegNo, UserId) VALUES ('$first_name','$last_name',"
                                    . "'$address_line_1','$address_line_2','$city','$district','$contact_mobile','$alt_mobile','$email', '$reg_number' , '$user_id')";
                            $db->query($sql);

                            $msg = "<h1>Success</h1>";
                            $msg .= "<h2>Congratulation</h2>";
                            $msg .= "<p>Yor account has been successfully created</p>";
                            $msg .= "<a href = 'http://localhost/nce/verify.php?token=$token'>Click here to verify your account</a>";
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
                            <div class="form-group col-md-6">
                                <label for="confirm_password">Confirm Password<span style = "color : red;"> * </span></label>
                                <input type="password" name="confirm_password" class="form-control border border-1 mb-4" id="confirm_password" value="<?= @$confirm_password ?>" placeholder="Enter Confirm Password" required>
                                <span class="text-danger"><?= @$message['confirm_password'] ?></span>
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