<?php
ob_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Supplier";
$breadcrumb_item_active = "Edit";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to fetch supplier details based on the supplierid from the URL
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT * FROM suppliers WHERE SupplierId='$supplierid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // Assign fetched category details to variables
    $sup_company_name = $row['SupCompanyName'];
    $cont_person_name = $row['ContPersonName'];
    $sup_contact_mobile = $row['ContactMobile'];
    $sup_alt_mobile = $row['AlternateMobile'];
    $email = $row['Email'];
    $address_line_1 = $row['AddressLine1'];
    $address_line_2 = $row['AddressLine2'];
    $city = $row['City'];
    $district = $row['DistrictId'];
    $account_name = $row['AccountName'];
    $account_number = $row['AccountNumber'];
    $bank_name = $row['BankName'];
    $bank_branch = $row['Branch'];
    $SupplierId = $row['SupplierId'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);
    $sup_company_name = dataClean($sup_company_name);
    $cont_person_name = dataClean($cont_person_name);
    $sup_contact_mobile = dataClean($sup_contact_mobile);
    $sup_alt_mobile = dataClean($sup_alt_mobile);
    $email = dataClean($email);
    $address_line_1 = dataClean($address_line_1);
    $address_line_2 = dataClean($address_line_2);
    $city = dataClean($city);
    $district = dataClean($district);
    $account_name = dataClean($account_name);
    $account_number = dataClean($account_number);
    $bank_name = dataClean($bank_name);
    $bank_branch = dataClean($bank_branch);

    $message = array();

    //    Required validation

    if (empty($sup_company_name)) {
        $message['sup_company_name'] = "Supplier Company Name is required.";
    }

    if (empty($cont_person_name)) {
        $message['cont_person_name'] = "Contact Person Name is required.";
    }

    if (empty($sup_contact_mobile)) {
        $message['sup_contact_mobile'] = "Contact Mobile is required.";
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

   

    if (empty($message)) {
        $db = dbConn();
        $sql = "UPDATE suppliers SET SupCompanyName='$sup_company_name', ContPersonName='$cont_person_name',"
                . " Email='$email', ContactMobile='$sup_contact_mobile', AlternateMobile='$sup_alt_mobile', "
                . "AddressLine1='$address_line_1', AddressLine2='$address_line_2', City='$city', "
                . "DistrictId='$district', AccountName='$account_name', AccountNumber='$account_number', "
                . "BankName='$bank_name', Branch='$bank_branch' WHERE SupplierId='$SupplierId'";

        $db->query($sql);
        header("Location: manage.php");
        exit();
    }
}
?> 

<div class="row">

    <div class="col-12">
  <a href="<?= SYS_URL ?>suppliers/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Supplier Listing Table</a>
        <!--Card Start-->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Supplier</h3>
            </div>         

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <!--Supplier Company Name and Contact Person Name-->

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="sup_company_name" class="form-label fw-bold">Supplier Company Name<span style = "color: red"> * </span></label>
                            <input type="text" name="sup_company_name" class="form-control mb-1" id="sup_company_name" value="<?= @$sup_company_name ?>" placeholder="Enter Supplier Company Name">
                            <span class="text-danger"><?= @$message['sup_company_name'] ?></span>
                        </div> 

                        <div class="form-group col-md-6">
                            <label for="cont_person_name" class="form-label fw-bold">Contact Person Name<span style = "color: red"> * </span></label>
                            <input type="text" name="cont_person_name" class="form-control mb-1" id="cont_person_name" value="<?= @$cont_person_name ?>" placeholder="Enter Contact Person Name">
                            <span class="text-danger"><?= @$message['cont_person_name'] ?></span>
                        </div>

                    </div>

                    <!--Supplier Contact Mobile and Alternate Mobile-->

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="sup_contact_mobile">Contact Mobile<span style = "color : red;"> * </span></label>
                            <input type="text" name="sup_contact_mobile" class="form-control mb-1" id="sup_contact_mobile" value="<?= @$sup_contact_mobile ?>" placeholder="Enter Contact Mobile">
                            <span class="text-danger"><?= @$message['sup_contact_mobile'] ?></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sup_alt_mobile">Alternate Mobile (Optional)</label>
                            <input type="text" name="sup_alt_mobile" class="form-control mb-1" id="sup_alt_mobile" value="<?= @$sup_alt_mobile ?>" placeholder="Enter Alternate Mobile">
                        </div>


                    </div>

                    <!--Supplier email-->

                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="email">Email<span style = "color : red"> * </span></label>
                            <input type="text" name="email" class="form-control mb-1" id="email" value="<?= @$email ?>" placeholder="Enter Email">
                            <span class="text-danger"><?= @$message['email'] ?></span>
                        </div>


                    </div>


                    <!--Supplier Address Line 1 , Address Line 2, City and District-->

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
                                  
                                      <option value="<?= $row['Id'] ?>" <?= ($district == $row['Id']) ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['district'] ?></span>
                        </div>
                    </div>

                    <!-- Supplier Bank Details - Collapsible Section -->
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#bankDetailsCollapse" aria-expanded="false" aria-controls="bankDetailsCollapse">
                                Click here to Add Supplier Bank Details. (Optional)
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
                    <!-- End Supplier Bank Details - Collapsible Section -->

                </div>

                <div class="card-footer">
                    <!-- Hidden input field to pass the SupplierId with the form submission -->
                    <input type="hidden" name="SupplierId" value="<?= $SupplierId ?>">
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