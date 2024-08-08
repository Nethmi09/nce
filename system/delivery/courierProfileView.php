<?php
ob_start();
include_once '../init.php';

$link = "Courier Service Management";
$breadcrumb_item = "Courier Service";
$breadcrumb_item_active = "View";

extract($_GET);
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>delivery/courierProfileManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Courier Services Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Courier Service Details</h3>
            </div>

            <div class="card-body">

                <?php
                $db = dbConn();
                $sql = "SELECT CourierServiceId, CouCompanyName, ContPersonName, Email, ContactMobile, AlternateMobile, "
                        . "AddressLine1, AddressLine2, City, AccountName, AccountNumber, BankName, Branch, "
                        . "t.Name FROM courier_service INNER JOIN districts t ON t.ID=courier_service.DistrictId "
                        . "WHERE courier_service.CourierServiceId='$courierProfileId'";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the courier service details
                    $courierService = $result->fetch_assoc();
                } else {
                    echo "Courier Service not found.";
                    exit;
                }
                ?>

                <!-- Courier Service Details Tables Start -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3><u>Courier Service Details</u></h3>
                                    <table class="table table-bordered">
                                        <tbody>

                                            <tr>
                                                <th style="width: 400px;">Courier Service ID</th>
                                                <td><?= $courierService['CourierServiceId'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Supplier Company Name</th>
                                                <td><?= $courierService['CouCompanyName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Contact Person Name</th>
                                                <td><?= $courierService['ContPersonName'] ?></td>
                                            </tr>                                             
                                            <tr>
                                                <th style="width: 400px;">Email</th>
                                                <td><?= $courierService['Email'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Contact Mobile</th>
                                                <td><?= $courierService['ContactMobile'] ?></td>
                                            </tr>                                           
                                            <tr>
                                                <th style="width: 400px;">Alternate Mobile</th>
                                                <td><?= $courierService['AlternateMobile'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Address Line 1</th>
                                                <td><?= $courierService['AddressLine1'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Address Line 2</th>
                                                <td><?= $courierService['AddressLine2'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">City</th>
                                                <td><?= $courierService['City'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">District</th>
                                                <td><?= $courierService['Name'] ?></td>
                                            </tr>
                                                                                       
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3><u>Courier Service Bank Details</u></h3>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th style="width: 400px;">Account Name</th>
                                                <td><?= $courierService['AccountName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Account Number</th>
                                                <td><?= $courierService['AccountNumber'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Bank Name</th>
                                                <td><?= $courierService['BankName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Branch</th>
                                                <td><?= $courierService['Branch'] ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Courier Service Details Tables End -->
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
