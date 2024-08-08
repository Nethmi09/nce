<?php
ob_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Supplier";
$breadcrumb_item_active = "View";

extract($_GET);
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>suppliers/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Supplier List</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Supplier Details</h3>
            </div>

            <div class="card-body">

                <?php
                $db = dbConn();
                $sql = "SELECT SupplierId, SupCompanyName, ContPersonName, ContactMobile, AlternateMobile, Email, "
                        . "RegDate,AddressLine1, AddressLine2, City, AccountName, AccountNumber, BankName, Branch, "
                        . "t.Name FROM suppliers INNER JOIN districts t ON t.ID=suppliers.DistrictId "
                        . "WHERE suppliers.SupplierId='$supplierid'";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the supplier details
                    $supplier = $result->fetch_assoc();
                } else {
                    echo "Supplier not found.";
                    exit;
                }
                ?>

                <!-- Supplier Details Tables Start -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3><u>Supplier Details</u></h3>
                                    <table class="table table-bordered">
                                        <tbody>

                                            <tr>
                                                <th style="width: 400px;">Supplier ID</th>
                                                <td><?= $supplier['SupplierId'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Supplier Company Name</th>
                                                <td><?= $supplier['SupCompanyName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Contact Person Name</th>
                                                <td><?= $supplier['ContPersonName'] ?></td>
                                            </tr>                                            
                                            <tr>
                                                <th style="width: 400px;">Contact Mobile</th>
                                                <td><?= $supplier['ContactMobile'] ?></td>
                                            </tr>                                           
                                            <tr>
                                                <th style="width: 400px;">Alternate Mobile</th>
                                                <td><?= $supplier['AlternateMobile'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Email</th>
                                                <td><?= $supplier['Email'] ?></td>
                                            </tr>
                                             <tr>
                                                <th style="width: 400px;">Register Date</th>
                                                <td><?= $supplier['RegDate'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Address Line 1</th>
                                                <td><?= $supplier['AddressLine1'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Address Line 2</th>
                                                <td><?= $supplier['AddressLine2'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">City</th>
                                                <td><?= $supplier['City'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">District</th>
                                                <td><?= $supplier['Name'] ?></td>
                                            </tr>
                                                                                       
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3><u>Supplier Bank Details</u></h3>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th style="width: 400px;">Account Name</th>
                                                <td><?= $supplier['AccountName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Account Number</th>
                                                <td><?= $supplier['AccountNumber'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Bank Name</th>
                                                <td><?= $supplier['BankName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Branch</th>
                                                <td><?= $supplier['Branch'] ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Supplier Details Tables End -->
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
