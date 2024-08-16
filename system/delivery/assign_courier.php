<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "View";
?>



<?php
extract($_GET);
extract($_POST);
$db = dbConn();

// Fetch order details
$sql = "SELECT o.*, c.FirstName, c.LastName, d.Name FROM orders o "
        . "INNER JOIN customers c ON c.CustomerId = o.CustomerId "
        . "INNER JOIN districts d ON d.Id = o.PersonalDistrictId "
        . "WHERE o.OrderID = '$order_id'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$order_status = $row['OrderStatus'];
$order_number = $row['OrderNumber'];
$customer_name = $row['FirstName'] . ' ' . $row['LastName'];

// Fetch assigned courier details
$courier_sql = "SELECT CourierServiceId FROM orders WHERE OrderID = '$order_id'";
$courier_result = $db->query($courier_sql);
$courier_row = $courier_result->fetch_assoc();
$assigned_courier = $courier_row['CourierServiceId'];
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);

    // Validate required fields
    if (!empty($cou_name)) {

        // Insert data into order_assigned_courier
        $sql = "INSERT INTO order_assigned_courier(OrderId, OrderNumber, CustomerName, CourierServiceId, Status) 
                VALUES('$order_id', '$order_number', '$customer_name','$cou_name','4')";
        $db->query($sql);

        // Update order status
        $update_sql = "UPDATE orders SET OrderStatus = '4',CourierServiceId = '$cou_name' WHERE OrderID = '$order_id'";
        $db->query($update_sql);

        // Redirect to manageDeliveryOrders.php
        header("Location: " . SYS_URL . "delivery/manageAssignedCourierOrders.php");
        exit;
    }
}
?>


<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>delivery/manageReadytoDeliveryOrders.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Ready to Delivery Orders Listing Table</a>

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Order Products Details</h3>
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

                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="cou_name">Courier Company<span style="color: red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM courier_service";
                            $result = $db->query($sql);
                            ?>
                            <select name="cou_name" id="cou_name" class="form-control select2 mb-1" aria-label="Large select example" <?= $order_status == '4' ? 'disabled' : 'required' ?>>
                                <option value="" disabled <?= $order_status == '4' ? '' : 'selected' ?>>Select Courier Company</option>
                                <?php
                                while ($courier = $result->fetch_assoc()) {
                                    $selected = ($assigned_courier == $courier['CourierServiceId']) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $courier['CourierServiceId'] ?>" <?= $selected ?>><?= $courier['CouCompanyName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['cou_name'] ?></span>
                        </div>
                    </div>
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
                    <?php if ($order_status != '4'): ?>
                        <button type="submit" value="courier" name="action" class="btn btn-primary">Handed to Courier</button>
                    <?php else: ?>
                        <button type="button" class="btn btn-secondary" disabled>Handed to Courier</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>