<?php
ob_start();
include_once '../init.php';
//checkUserType("employee");

$link = "Employee Management";
$breadcrumb_item = "Employee";
$breadcrumb_item_active = "Edit";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to fetch employee details based on the EmployeeId from the URL
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT * FROM employees WHERE EmployeeId='$employeeid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // Assign fetched employee details to variables

    $first_name = $row['FirstName'];
    $last_name = $row['LastName'];
    $nic_number = $row['NICNumber'];
    $email = $row['Email'];
    $contact_mobile = $row['ContactMobile'];
    $alt_mobile = $row['AlternateMobile'];
    $address_line_1 = $row['AddressLine1'];
    $address_line_2 = $row['AddressLine2'];
    $city = $row['City'];
    $district = $row['DistrictId'];
    $employee_image = $row['Image'];
    $designation = $row['DesignationId'];
    $dob = $row['DOB'];
    $gender = $row['Gender'];
    $civilStatus = $row['CivilStatusId'];
    $employeeStatus = $row['EmployeeStatusId'];
    $hire_date = $row['HireDate'];
    $account_name = $row['AccountName'];
    $account_number = $row['AccountNumber'];
    $bank_name = $row['BankName'];
    $bank_branch = $row['Branch'];
    $EmployeeId = $row['EmployeeId'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);

    $first_name = dataClean($first_name);
    $last_name = dataClean($last_name);
    $nic_number = dataClean($nic_number);
    $email = dataClean($email);
    $contact_mobile = dataClean($contact_mobile);
    $alt_mobile = dataClean($alt_mobile);
    $address_line_1 = dataClean($address_line_1);
    $address_line_2 = dataClean($address_line_2);
    $city = dataClean($city);
    $account_name = dataClean($account_name);
    $account_number = dataClean($account_number);
    $bank_name = dataClean($bank_name);
    $bank_branch = dataClean($bank_branch);

    $message = array();

    //    Required validation

    if (empty($first_name)) {
        $message['first_name'] = "First Name is required.";
    }
    if (empty($last_name)) {
        $message['last_name'] = "Last Name is required.";
    }
    if (empty($nic_number)) {
        $message['nic_number'] = "NIC Number is required.";
    }
    if (empty($email)) {
        $message['email'] = "Email is required.";
    }
    if (empty($contact_mobile)) {
        $message['contact_mobile'] = "Contact Mobile is required.";
    }
    if (empty($address_line_1)) {
        $message['address_line_1'] = "Address Line 1 is required.";
    }
    if (empty($city)) {
        $message['city'] = "City is required.";
    }
    if (empty($district)) {
        $message['district'] = "District is required.";
    }
    if (empty($designation)) {
        $message['designation'] = "Designation is required.";
    }
    if (empty($dob)) {
        $message['dob'] = "DOB is required.";
    }

    if (empty($gender)) {
        $message['gender'] = "Gender is required.";
    }

    if (empty($civilStatus)) {
        $message['civilStatus'] = "Civil Status is required.";
    }

    if (empty($employeeStatus)) {
        $message['employeeStatus'] = "Employee Status is required.";
    }

    if (empty($hire_date)) {
        $message['hire_date'] = "Hire Date is required.";
    }

    // File upload handling
    $employee_image = '';
    $new_employee_image = $employee_image;
    if (!empty($_FILES['employee_image']['name'])) {
        $uploadDir = '../assets/dist/img/uploads/employee/';
        $uploadFile = $uploadDir . basename($_FILES['employee_image']['name']);

        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedExtensions)) {
            $message['employee_image'] = "Only JPG, JPEG & PNG files are allowed.";
        }if ($_FILES['employee_image']['size'] > 5000000) { // 5 MB
            $message['employee_image'] = "Your file is too large.";
        }
        if (empty($message['employee_image']) && move_uploaded_file($_FILES['employee_image']['tmp_name'], $uploadFile)) {
            $new_employee_image = basename($_FILES['employee_image']['name']);
        }
    } else {
        $new_employee_image = $employee_image;
    }

// check whether a valid nic 
    if (!empty($nic_number)) {
        $nicRegex = '/^[0-9]{9}[vVxX]$|^[0-9]{12}$/';
        if (!preg_match($nicRegex, $nic_number)) {
            $message['nic_number'] = "Invalid NIC No...! NIC No should be 9 numbers with 'V'/'X' (Old NIC) or 12 numbers (New NIC)";
        }
    }


    if (empty($message)) {


        $db = dbConn();
        $sql = "UPDATE `employees` SET `FirstName`='$first_name',"
                . "`LastName`='$last_name',`NICNumber`='$nic_number',`Email`='$email',`ContactMobile`='$contact_mobile',"
                . "`AlternateMobile`='$alt_mobile',`AddressLine1`='$address_line_1',`AddressLine2`='$address_line_2',"
                . "`City`='$city',`DistrictId`='$district',`Image`='$new_employee_image',`DOB`='$dob',"
                . "`Gender`='$gender',`HireDate`='$hire_date',"
                . "`DesignationId`='$designation',`CivilStatusId`='$civilStatus',`EmployeeStatusId`='$employeeStatus',"
                . "`AccountName`='$account_name',`AccountNumber`='$account_number',`BankName`='$bank_name',"
                . "`Branch`='$bank_branch' WHERE EmployeeId='$EmployeeId'";

        if (!empty($employee_image)) {
            $sql .= ", `Image`='$employee_image'";
        }

        $db->query($sql);
        $EmployeeId = $db->insert_id;

        header("Location:manage.php");
    }
}
?> 

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>employees/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Employees Listing Table</a>
        <!--Card Start-->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Employee</h3>
            </div> 

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <!--Employee First Name and Employee Last Name-->

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name<span style = "color : red"> * </span></label>
                            <input type="text" name="first_name" class="form-control border border-1 mb-1" id="first_name" value="<?= @$first_name ?>" placeholder="Enter First Name">
                            <span class="text-danger"><?= @$message['first_name'] ?></span>

                        </div>
                        <div class="form-group col-md-6 mt-3 mt-md-0">
                            <label for="last_name">Last Name<span style = "color : red"> * </span></label>
                            <input type="text" name="last_name" class="form-control border border-1 mb-1" id="last_name" value="<?= @$last_name ?>" placeholder="Enter Last Name">
                            <span class="text-danger"><?= @$message['last_name'] ?></span>
                        </div>
                    </div>

                    <!--Employee NIC Number, Email, Contact Mobile and Alternate Mobile-->

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="nic_number">NIC Number<span style = "color : red"> * </span></label>
                            <input type="text" name="nic_number" class="form-control border border-1 mb-1" id="nic_number" value="<?= @$nic_number ?>" placeholder="Enter NIC Number">
                            <span class="text-danger"><?= @$message['nic_number'] ?></span>
                        </div>
                        <div class="form-group col-md-3 mt-3 mt-md-0">
                            <label for="email">Email<span style = "color : red"> * </span></label>
                            <input type="text" name="email" class="form-control border border-1 mb-1" id="email" value="<?= @$email ?>" placeholder="Enter Email">
                            <span class="text-danger"><?= @$message['email'] ?></span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="contact_mobile">Contact Mobile<span style = "color : red;"> * </span></label>
                            <input type="text" name="contact_mobile" class="form-control border border-1 mb-1" id="contact_mobile" value="<?= @$contact_mobile ?>" placeholder="Enter Contact Mobile">
                            <span class="text-danger"><?= @$message['contact_mobile'] ?></span>
                        </div>
                        <div class="form-group col-md-3 mt-3 mt-md-0">
                            <label for="alt_mobile">Alternate Mobile (Optional)</label>
                            <input type="text" name="alt_mobile" class="form-control border border-1 mb-1" id="alt_mobile" value="<?= @$alt_mobile ?>" placeholder="Enter Alternate Mobile">
                        </div>

                    </div>

                    <!--Employee Address Line 1 , Address Line 2, City and District-->

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="address_line_1">Address Line 1<span style = "color : red;"> * </span></label>
                            <input type="text" name="address_line_1" class="form-control border border-1 mb-1" id="address_line_1" value="<?= @$address_line_1 ?>" placeholder="Enter Address Line 1">
                            <span class="text-danger"><?= @$message['address_line_1'] ?></span>
                        </div>
                        <div class="form-group col-md-3 mt-3 mt-md-0">
                            <label for="address_line_2">Address Line 2 (Optional)</label>
                            <input type="text" name="address_line_2" class="form-control border border-1 mb-1" id="address_line_2" value="<?= @$address_line_2 ?>" placeholder="Enter Address Line 2">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="city">City<span style = "color : red"> * </span></label>
                            <input type="text" name="city" class="form-control border border-1 mb-1" id="city" value="<?= @$city ?>" placeholder="Enter City">
                            <span class="text-danger"><?= @$message['city'] ?></span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="district">District<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  districts";
                            $result = $db->query($sql);
                            ?>
                            <select name="district" id="district"  class="form-control select2 mb-1" value="<?= @$district ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select District</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" <?= ($district == $row['Id']) ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['district'] ?></span>
                        </div>
                    </div>

                    <!--Employee Image , Designation, DOB and Gender-->

                    <div class="row">

                        <div class="form-group col-md-3">
                             <label for="employee_image">Employee Image</label>
                        <div class="input-group">
                            <input type="file" name="employee_image" id="employee_image" class="form-control">
                            <span class="text-danger"><?= @$message['employee_image'] ?></span>
                        </div>
                        <?php if ($employee_image): ?>
                            <img src="../assets/dist/img/uploads/employee/<?= $employee_image ?>" alt="Employee Image" style="max-width: 100px;">
                        <?php endif; ?>
                            <input type="hidden" name="prv_employee_image" value="<?= @$employee_image ?>">
                        </div>
                        


                        <div class="form-group col-md-3">
                            <label for="designation">Designation<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  designations";
                            $result = $db->query($sql);
                            ?>
                            <select class="form-control mb-1" id="designation" name="designation" value="<?= @$designation ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select Designation</option>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['DesignationId'] ?>" <?= @$designation == $row['DesignationId'] ? 'selected' : '' ?>><?= $row['DesignationName'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="text-danger"><?= @$message['designation'] ?></span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="dob">DOB<span style = "color : red;"> * </span></label>
                            <input type="date" name="dob" class="form-control mb-1" id="dob" value="<?= @$dob ?>"  max="<?= date('Y-m-d'); ?>">
                            <span class="text-danger"><?= @$message['dob'] ?></span>
                        </div>

                        <div class="form-group col-md-3 mt-3 mt-md-0">
                            <label for="gender">Gender<span style = "color : red;"> * </span></label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="gender" value="Male" id="radioMale" class="form-check-input" <?= @$gender == 'Male' ? 'checked' : '' ?>>
                                <label for="radioMale" class="form-check-label" id="labelMale">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="gender" value="Female" id="radioFemale" class="form-check-input" <?= @$gender == 'Female' ? 'checked' : '' ?>>
                                <label for="radioFemale" class="form-check-label" id="labelFemale">Female</label>
                            </div>
                            <br>
                            <span class="text-danger"><?= @$message['gender'] ?></span>

                        </div>
                    </div>

                    <!--Employee Civil Status , Employee Status, Hire Date-->

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="civilStatus">Civil Status<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  civil_status";
                            $result = $db->query($sql);
                            ?>
                            <select class="form-control mb-1" id="civilStatus" name="civilStatus" value="<?= @$civilStatus ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select Civil Status</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['CivilStatusId'] ?>" <?= @$civilStatus == $row['CivilStatusId'] ? 'selected' : '' ?>><?= $row['CivilStatusName'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="text-danger"><?= @$message['civilStatus'] ?></span>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="employeeStatus">Employee Status<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  employee_status";
                            $result = $db->query($sql);
                            ?>
                            <select class="form-control mb-1" id="employeeStatus" name="employeeStatus" value="<?= @$employeeStatus ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select Employee Status</option>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['EmployeeStatusId'] ?>" <?= @$employeeStatus == $row['EmployeeStatusId'] ? 'selected' : '' ?>><?= $row['EmployeeStatusName'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="text-danger"><?= @$message['employeeStatus'] ?></span>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="hire_date">Hire Date<span style = "color : red;"> * </span></label>
                            <input type="date" name="hire_date" class="form-control mb-1" id="hire_date" value="<?= @$hire_date ?>" max="<?= date('Y-m-d'); ?>">
                            <span class="text-danger"><?= @$message['hire_date'] ?></span>
                        </div>
                    </div>

                    <!-- Employee Bank Details - Collapsible Section -->
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bankDetailsCollapse" aria-expanded="false" aria-controls="bankDetailsCollapse">
                                Click here to Add Employee Bank Details. (Optional)
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="bankDetailsCollapse">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="account_name">Account Name</label>
                                <input type="text" name="account_name" class="form-control mb-1" id="account_name" value="<?= @$account_name ?>" placeholder="Enter Account Name">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="account_number">Account Number</label>
                                <input type="text" name="account_number" class="form-control mb-1" id="account_number" value="<?= @$account_number ?>" placeholder="Enter Account Number">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="bank_name">Bank Name </label>
                                <input type="text" name="bank_name" class="form-control mb-1" id="bank_name" value="<?= @$bank_name ?>" placeholder="Enter Bank Name">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bank_branch">Branch</label>
                                <input type="text" name="bank_branch" class="form-control mb-1" id="bank_branch" value="<?= @$bank_branch ?>" placeholder="Enter Branch">
                            </div>
                        </div>
                    </div>
                    <!-- End Employee Bank Details - Collapsible Section -->

                </div>


                <div class="card-footer">
                    <!-- Hidden input field to pass the EmployeeId with the form submission -->
                    <input type="hidden" name="EmployeeId" value="<?= $EmployeeId ?>">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
            <!--Form End-->

        </div>
        <!--Card End-->
    </div>
</div>



<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>