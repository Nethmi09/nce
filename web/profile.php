<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['USERID'])) {
    header("Location:login.php");
}
include 'header.php';
include '../function.php';
include '../config.php';

$userid = $_SESSION['USERID']; // Assuming the session stores the logged-in user's ID
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Profile</h1>
</div>
<!-- Single Page Header End -->

<!-- Profile Content Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h4 class="text-primary">Update your registered information with ease on this page to keep your profile accurate and up-to-date.</h4>
                    </div>
                </div>

                <div class="">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        extract($_GET);
                        $db = dbConn();
                        $sql = "SELECT *,d.Name FROM users u "
                                . "INNER JOIN customers c "
                                . "ON c.UserId=u.UserId " . "INNER JOIN districts d "
                                . "ON d.Id=c.DistrictId "
                                . "WHERE u.UserId='$userid'";
                        $result = $db->query($sql);

                        $row = $result->fetch_assoc();
                        // Assign fetched customer details to variables
                        $first_name = $row['FirstName'];
                        $last_name = $row['LastName'];
                        $address_line_1 = $row['AddressLine1'];
                        $address_line_2 = $row['AddressLine2'];
                        $city = $row['City'];
                        $district = $row['Id'];
                        $contact_mobile = $row['ContactMobile'];
                        $alt_mobile = $row['AlternateMobile'];
                        $email = $row['Email'];
                        $user_name = $row['UserName'];
                        $UserId = $row['UserId'];
                    }


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

                        $message = array();
                        // Required validation
                        if (empty($first_name)) {
                            $message['first_name'] = "First Name is required!";
                        }
                        if (empty($last_name)) {
                            $message['last_name'] = "Last Name is required!";
                        }
                        if (empty($address_line_1)) {
                            $message['address_line_1'] = "Address Line 1 is required!";
                        }
                        if (empty($city)) {
                            $message['city'] = "City is required!";
                        }
                        if (empty($district)) {
                            $message['district'] = "District is required!";
                        }
                        if (empty($contact_mobile)) {
                            $message['contact_mobile'] = "Contact Mobile is required!";
                        }

                        // Advanced validation
                        if (ctype_alpha(str_replace(' ', '', $first_name)) === false) {
                            $message['first_name'] = "Only letters and white space allowed!";
                        }
                        if (ctype_alpha(str_replace(' ', '', $last_name)) === false) {
                            $message['last_name'] = "Only letters and white space allowed!";
                        }

                        if (empty($message)) {
                            $db = dbConn();
                            $sql = "UPDATE users SET FirstName='$first_name', LastName='$last_name' WHERE UserId='$userid'";
                            $db->query($sql);

                            $sql = "UPDATE customers SET FirstName='$first_name', LastName='$last_name', AddressLine1='$address_line_1', AddressLine2='$address_line_2', City='$city', DistrictId='$district', ContactMobile='$contact_mobile', AlternateMobile='$alt_mobile' WHERE UserId='$userid'";
                            $db->query($sql);
                            echo "<script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Your Profile Details Successfully updated',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            </script>";
                        }
                    }
                    ?>

                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name<span style="color: red;"> * </span></label>
                                <input type="text" name="first_name" class="form-control border border-1 mb-4" id="first_name" value="<?= @$first_name ?>" placeholder="Enter First Name" required>
                                <span class="text-danger"><?= @$message['first_name'] ?></span>
                            </div>
                            <div class="form-group col-md-6 mt-3 mt-md-0">
                                <label for="last_name">Last Name<span style="color: red;"> * </span></label>
                                <input type="text" name="last_name" class="form-control border border-1 mb-4" id="last_name" value="<?= @$last_name ?>" placeholder="Enter Last Name" required>
                                <span class="text-danger"><?= @$message['last_name'] ?></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="address_line_1">Address Line 1<span style="color: red;"> * </span></label>
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
                                <label for="city">City<span style="color: red;"> * </span></label>
                                <input type="text" name="city" class="form-control border border-1 mb-4" id="city" value="<?= @$city ?>" placeholder="Enter City" required>
                                <span class="text-danger"><?= @$message['city'] ?></span>
                            </div>
                            <div class="form-group col-md-6">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM districts";
                                $result = $db->query($sql);
                                ?>
                                <label for="district">District<span style="color: red;"> * </span></label>
                                <select name="district" id="district" class="form-select mb-4 border border-1" value="<?= @$district ?>" aria-label="Large select example">
                                    <option value="">Select District</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['Id'] ?>" <?= ($row['Id'] == @$district) ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?= @$message['district'] ?></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="contact_mobile">Contact Mobile<span style="color: red;"> * </span></label>
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
                                <label for="email">Email Address<span style="color: red;"> * </span></label>
                                <input type="text" name="email" class="form-control border border-1 mb-4" id="email" value="<?= @$email ?>" placeholder="Enter Email" disabled required>
                                <span class="text-danger"><?= @$message['email'] ?></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="user_name">User Name<span style="color: red;"> * </span></label>
                                <input type="text" name="user_name" class="form-control border border-1 mb-4" id="user_name" value="<?= @$user_name ?>" placeholder="Enter User Name" disabled required>
                                <span class="text-danger"><?= @$message['user_name'] ?></span>
                            </div>
                        </div>

                        <button class="btn form-control border-secondary py-3 bg-white text-primary " type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Profile Content End -->

<?php
include 'footer.php';
?>
