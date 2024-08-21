<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "Manage";

// Check if the form is submitted and the action is "processing"
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'processing') {
    $orderId = $_POST['OrderId'];

    // Update the order status to "Processing" (ID: 2)
    $db = dbConn();
    $sql = "UPDATE orders SET OrderStatus = 2 WHERE OrderId = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('i', $orderId);

    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Order Processing',
                text: 'The order status has been updated to processing.',
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

    $stmt->close();
}
?> 
<div class="row">
    <div class="col-8">
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Informations</h3>
            </div>
            <div class="card-body">
                 <li>When you start processing the customer's order, click the "Processing" button to inform the user that their order is now being processed.</li>
        
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
                 // Only select orders with status 3, 4, or 5
                $sql = "SELECT o.*, c.FirstName, c.LastName
                        FROM orders o 
                        INNER JOIN customers c ON c.CustomerId = o.CustomerId
                        WHERE o.OrderStatus IN (2,3,7) ORDER BY `OrderId` DESC";
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
                            <th>Change Status</th>
                            <th>View Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                // Translate payment method value to name
                                $paymentMethod = ($row['PaymentMethod'] == 1) ? "Cash On Delivery" : "Bank Transfer";
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['OrderNumber'] ?></td> 
                                    <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td> 
                                    <td><?= $row['OrderDate'] ?></td> 
                                    <td><?= $row['TotalAmount'] ?></td>
                                    <td><?= $paymentMethod ?></td>
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

                                        if ($status == 2) {
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
                                        } elseif ($status == 7) {
                                            ?>
                                            <h5><span class="badge badge-pill badge-success">
                                                    Accepted
                                                </span>
                                            </h5>
                                        
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" style="display:inline;">
                                            <input type="hidden" name="OrderId" value="<?= $row['OrderId'] ?>">
                                            <button type="submit" name="action" value="processing" class="btn btn-info ml-2" <?= in_array($row['OrderStatus'], [2, 3]) ? 'disabled' : '' ?>>Processing</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="<?= SYS_URL ?>orderIssue/view_order_products.php?order_id=<?= $row['OrderId'] ?>"><u>View Order</u></a>
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
