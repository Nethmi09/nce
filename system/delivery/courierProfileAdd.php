<?php
ob_start();
include_once '../init.php';

$link = "Courier Service Management";
$breadcrumb_item = "Courier Service";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $cou_company_name = dataClean($cou_company_name);
    $cont_person_name = dataClean($cont_person_name);
    $cou_contact_mobile = dataClean($cou_contact_mobile);
    $cou_alt_mobile = dataClean($cou_alt_mobile);
    $email = dataClean($email);
    $address_line_1 = dataClean($address_line_1);
    $address_line_2 = dataClean($address_line_2);
    $city = dataClean($city);
    $account_name = dataClean($account_name);
    $account_number = dataClean($account_number);
    $bank_name = dataClean($bank_name);
    $bank_branch = dataClean($bank_branch);

    $message = array();

    //    Required validation

    if (empty($cou_company_name)) {
        $message['cou_company_name'] = "Courier Service Company Name is required.";
    }
    
     if (empty($cont_person_name)) {
        $message['cont_person_name'] = "Contact Person Name is required.";
    }
    
     if (empty($cou_contact_mobile)) {
        $message['cou_contact_mobile'] = "Contact Mobile is required.";
    }
    
     if (empty($email)) {
        $message['email'] = "Email is required.";
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

    //    Advance validation

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $message['email'] = "Invalid Email Address.";
                        } else {
                            $db = dbConn();
                            $sql = "SELECT * FROM courier_service WHERE Email='$email'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $message ['email'] = "This Email Address is already exist!";
                            }
                        }

    if (empty($message)) {

        $db = dbConn();
        $sql = "INSERT INTO courier_service(CouCompanyName, ContPersonName,Email, ContactMobile, AlternateMobile,AddressLine1, AddressLine2, City, DistrictId, AccountName, AccountNumber, BankName, Branch, Status) "
                . "VALUES ('$cou_company_name','$cont_person_name','$email','$cou_contact_mobile','$cou_alt_mobile','$address_line_1','$address_line_2','$city','$district','$account_name','$account_number','$bank_name','$bank_branch','1')";
        $db->query($sql);
        $CourierServiceId = $db->insert_id;

        header("Location:courierProfileManage.php");
    }
}
?> 

<div class="row">

    <div class="col-12">

        <!--Card Start-->
 <a href="<?= SYS_URL ?>delivery/courierProfileManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Courier Services Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Courier Service</h3>
            </div>         

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <!--Courier Service Company Name, Contact Person Name and Email -->

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="cou_company_name" class="form-label fw-bold">Courier Service Company Name<span style = "color: red"> * </span></label>
                            <input type="text" name="cou_company_name" class="form-control mb-1" id="cou_company_name" value="<?= @$cou_company_name ?>" placeholder="Enter Courier Company Name">
                            <span class="text-danger"><?= @$message['cou_company_name'] ?></span>
                        </div> 

                        <div class="form-group col-md-4">
                            <label for="cont_person_name" class="form-label fw-bold">Contact Person Name<span style = "color: red"> * </span></label>
                            <input type="text" name="cont_person_name" class="form-control mb-1" id="cont_person_name" value="<?= @$cont_person_name ?>" placeholder="Enter Contact Person Name">
                            <span class="text-danger"><?= @$message['cont_person_name'] ?></span>
                        </div>
                        
                         <div class="form-group col-md-4">
                            <label for="email">Email<span style = "color : red"> * </span></label>
                            <input type="text" name="email" class="form-control mb-1" id="email" value="<?= @$email ?>" placeholder="Enter Email">
                            <span class="text-danger"><?= @$message['email'] ?></span>
                        </div>

                    </div>

                    <!--Courier Service Contact Mobile and Alternate Mobile-->

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="cou_contact_mobile">Contact Mobile<span style = "color : red;"> * </span></label>
                            <input type="text" name="cou_contact_mobile" class="form-control mb-1" id="cou_contact_mobile" value="<?= @$cou_contact_mobile ?>" placeholder="Enter Contact Mobile">
                            <span class="text-danger"><?= @$message['cou_contact_mobile'] ?></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cou_alt_mobile">Alternate Mobile (Optional)</label>
                            <input type="text" name="cou_alt_mobile" class="form-control mb-1" id="cou_alt_mobile" value="<?= @$cou_alt_mobile ?>" placeholder="Enter Alternate Mobile">
                        </div>


                    </div>


                    <!--Courier Service Address Line 1 , Address Line 2, City and District-->

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="address_line_1">Address Line 1<span style = "color : red;"> * </span></label>
                            <input type="text" name="address_line_1" class="form-control mb-1" id="address_line_1" value="<?= @$address_line_1 ?>" placeholder="Enter Address Line 1">
                            <span class="text-danger"><?= @$message['address_line_1'] ?></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="address_line_2">Address Line 2 (Optional)</label>
                            <input type="text" name="address_line_2" class="form-control mb-1" id="address_line_2" value="<?= @$address_line_2 ?>" placeholder="Enter Address Line 2">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="city">City<span style = "color : red"> * </span></label>
                            <input type="text" name="city" class="form-control mb-1" id="city" value="<?= @$city ?>" placeholder="Enter City">
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
                                    <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['district'] ?></span>
                        </div>
                    </div>

                    <!-- Courier Service Bank Details - Collapsible Section -->
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bankDetailsCollapse" aria-expanded="false" aria-controls="bankDetailsCollapse">
                                Click here to Add Courier Service Bank Details. (Optional)
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="bankDetailsCollapse">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="account_name">Account Name</label>
                                <input type="text" name="account_name" class="form-control" id="account_name" value="<?= @$account_name ?>" placeholder="Enter Account Name">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="account_number">Account Number</label>
                                <input type="text" name="account_number" class="form-control" id="account_number" value="<?= @$account_number ?>" placeholder="Enter Account Number">
                            </div>


                            <div class="form-group col-md-3">
                                <label for="bank_name">Bank Name </label>
                                <input type="text" name="bank_name" class="form-control" id="bank_name" value="<?= @$bank_name ?>" placeholder="Enter Bank Name">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bank_branch">Branch</label>
                                <input type="text" name="bank_branch" class="form-control" id="bank_branch" value="<?= @$bank_branch ?>" placeholder="Enter Branch">
                            </div>
                        </div>
                    </div>
                    <!-- End Courier Service Bank Details - Collapsible Section -->

                </div>


                <div class="card-footer">
                       <a href="<?= SYS_URL ?>delivery/courierProfileManage.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn submit">Submit</button>
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