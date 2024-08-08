<?php
ob_start();
include_once '../init.php';

$link = "Customer Management";
$breadcrumb_item = "Customer";
$breadcrumb_item_active = "View";

//Get the url returns id(customerid)
extract($_GET);
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>customers/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Customers List</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Details</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                //customerid mean get retaled data for each customer
                $sql = "SELECT CustomerId, FirstName, LastName, AddressLine1, AddressLine2, City, ContactMobile, AlternateMobile, Email, RegNo, d.Name FROM customers c INNER JOIN districts d ON d.Id=c.DistrictId WHERE c.CustomerId='$customerid'";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the customer details
                    $customer = $result->fetch_assoc();
                } else {
                    echo "User not found.";
                    exit;
                }
                ?>

                <!-- Customer Details Table Start -->
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <th style="width: 400px;">Customer ID</th>
                            <td><?= $customer['CustomerId'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">First Name</th>
                            <td><?= $customer['FirstName'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Last Name</th>
                            <td><?= $customer['LastName'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Address Line 1</th>
                            <td><?= $customer['AddressLine1'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Address Line 2</th>
                            <td><?= $customer['AddressLine2'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">City</th>
                            <td><?= $customer['City'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">District</th>
                            <td><?= $customer['Name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Contact Mobile</th>
                            <td><?= $customer['ContactMobile'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Alternate Mobile</th>
                            <td><?= $customer['AlternateMobile'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Email</th>
                            <td><?= $customer['Email'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Registration Number</th>
                            <td><?= $customer['RegNo'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <!-- Customer Details Table End -->
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
