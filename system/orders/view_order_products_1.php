<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "View";

extract($_GET);

$db = dbConn();
$sql = "SELECT o.*,c.FirstName,c.LastName,d.Name FROM orders o INNER JOIN customers c ON c.CustomerId=o.CustomerId INNER JOIN districts d ON d.Id=o.PersonalDistrictId WHERE o.OrderID='$orderid'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$order_status = $row['OrderStatus'];
?> 
<div class="row">
    <div class="col-12">

        <a href="<?= SYS_URL ?>orders/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to order List</a>

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Order Details</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Customer Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Customer Name</strong></td>
                                        <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Order Number</strong></td>
                                        <td><?= $row['OrderNumber'] ?></td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Billing Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Billing Name</strong></td>
                                        <td><?= ($row['PersonalName']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td><?= ($row['PersonalEmail']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Mobile</strong></td>
                                        <td><?= ($row['PersonalContactMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alternate Mobile</strong></td>
                                        <td><?= ($row['PersonalAlternateMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 1</strong></td>
                                        <td><?= ($row['PersonalAddressLine1']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 2</strong></td>
                                        <td><?= ($row['PersonalAddressLine2']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>City</strong></td>
                                        <td><?= ($row['PersonalCity']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>District</strong></td>
                                        <td><?= ($row['Name']) ?></td>
                                    </tr>
                                </table> 

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Shipping Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Shipping Name</strong></td>
                                        <td><?= ($row['ShippingName']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td><?= ($row['ShippingEmail']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Mobile</strong></td>
                                        <td><?= ($row['ShippingContactMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alternate Mobile</strong></td>
                                        <td><?= ($row['ShippingAlternateMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 1</strong></td>
                                        <td><?= ($row['ShippingAddressLine1']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 2</strong></td>
                                        <td><?= ($row['ShippingAddressLine2']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>City</strong></td>
                                        <td><?= ($row['ShippingCity']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>District</strong></td>
                                        <td><?= ($row['Name']) ?></td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $db = dbConn();
                $sql = "SELECT o.*, p.ProductName FROM order_products o INNER JOIN products p ON p.ProductId=o.ProductId WHERE o.OrderId='$orderid'";
                
                $result = $db->query($sql);
                ?>
                <h3>Order Products</h3>
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit Price</th>  
                            <th>Quantity</th>                 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['ProductName'] ?></td>
                                    <td><?= $row['UnitPrice'] ?></td> 
                                    <td><?= $row['Quantity'] ?></td>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <!--Table End-->

            </div>

        </div>

    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>