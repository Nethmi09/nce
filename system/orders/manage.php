<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "Manage";

// Check if the form is submitted and the action is "accept"
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'accept') {
    $orderId = $_POST['OrderId'];

    // Update the order status to "Accepted" (ID: 7)
    $db = dbConn();
    $sql = "UPDATE orders SET OrderStatus = 7 WHERE OrderId = ?";
    $result = $db->prepare($sql);
    $result->bind_param('i', $orderId);

    if ($result->execute()) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Order Accepted',
                text: 'The order status has been updated to Accepted.',
                confirmButtonText: 'OK'
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was an error updating the order status.',
                confirmButtonText: 'OK'
            });
        </script>";
    }

    $result->close();
}
?> 

<div class="row">
    <div class="col-8">
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Informations</h3>
            </div>
            <div class="card-body">
                <li>When a customer makes a bank transfer payment, you can click the "View Slip" button to check the uploaded payment slip.</li>
                <li>After reviewing the payment slip, please update the system to inform the user whether the payment has been accepted or rejected.</li>
                <li>When a customer makes a cash on delivery payment, you can click the "Accept" button to inform the user that the order has been accepted.</li>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Order Details Table</h3>
            </div>
            <div class="card-body">
                <?php                
                $db = dbConn();
                $sql = "SELECT o.*, c.FirstName, c.LastName FROM orders o INNER JOIN customers c ON c.CustomerId = o.CustomerId ORDER BY `OrderId` DESC";
                $result = $db->query($sql);
                ?>
                <!--Table Start-->
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Number</th>
                            <th>Customer Name</th>  
                            <th>Order Date</th>
                            <th>Total Amount</th>
                            <th>Payment Method</th>
                            <th>Order Status</th>
                            <th>Payment Processs</th>
                            <th>Invoice</th>
                            <th>View Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['OrderNumber'] ?></td> 
                                    <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td> 
                                    <td><?= $row['OrderDate'] ?></td> 
                                    <td><?= $row['TotalAmount'] ?></td>
                                    <td>
                                        <?php
                                        if ($row['PaymentMethod'] == 1) {
                                            echo "Cash On Delivery";
                                            ?>
                                            <form action="" method="POST" style="display:inline;">
                                                <input type="hidden" name="OrderId" value="<?= $row['OrderId'] ?>">
                                                <!-- Accept Button -->
                                                <button type="submit" name="action" value="accept" class="btn btn-success ml-auto" <?= $row['OrderStatus'] != 1 ? 'disabled' : '' ?>>Accept</button>
                                            </form>
                                            <?php
                                        } else {
                                            echo "Bank Transfer";
                                            ?>
                                            <form action="viewSlip.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="OrderId" value="<?= $row['OrderId'] ?>">
                                                <button class="btn btn-outline-primary btn-sm" type="submit" name="action" value="slipview">View Slip</button>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td> 
                                        <?php
                                        $order_status = $row['OrderStatus'];
                                        $sql_status = "SELECT * FROM order_statuses WHERE Status=$order_status";
                                        $result_status = $db->query($sql_status);
                                        $row_status = $result_status->fetch_assoc();
                                        //echo $row_status['OrderStatusName'];
                                        ?>
                                        <?php
                                        //$status_name = $row_status['status_name'];
                                        $status = $row_status['Status'];

                                        if ($status == 1) {
                                            ?>
                                            <h5><span class="badge badge-pill badge-light">
                                                    Not Proccessed
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 2) {
                                            ?>
                                            <h5><span class="badge badge-pill badge-dark">
                                                    Processing
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 3) {
                                            ?>
                                            <h5><span class="badge badge-pill badge-warning">
                                                    Packed
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 4) {
                                            ?>
                                            <h5><span class="badge badge-pill badge-info">
                                                    Shipping
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 5) {
                                            ?>
                                            <h5><span class="badge badge-pill badge-primary">
                                                    Delivered
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 6) {
                                            ?>
                                            <h5><span class="badge badge-pill badge-secondary">
                                                    cancelled
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 7) {
                                            ?>
                                            <h5><span class="badge badge-pill badge-success">
                                                    Accepted
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 8) {
                                            ?>
                                            <h5><span class="badge badge-pill badge-danger">
                                                    Rejected
                                                </span>
                                            </h5>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['PaymentMethod'] == 1) {
                                            ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="OrderId" value="<?= $row['OrderId'] ?>">

                                                <a href="<?= SYS_URL ?>orders/view_cash_payment.php?order_id=<?= $row['OrderId'] ?>" class="btn btn-info">Cash Payment</a>
                                            </form>
                                            <?php
                                        } else {
                                            ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="OrderId" value="<?= $row['OrderId'] ?>">
                                                <a href="<?= SYS_URL ?>orders/view_bank_payment.php?order_id=<?= $row['OrderId'] ?>" class="btn btn-info">Bank Payment</a>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?= SYS_URL ?>invoices/invoice.php?order_id=<?= $row['OrderId'] ?>"><i class="fas fa-file-invoice"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?= SYS_URL ?>orders/view_order_products.php?order_id=<?= $row['OrderId'] ?>"><u>View Order</u></a>
                                    </td>

                                </tr>
                                <?php
                                $i++;
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
