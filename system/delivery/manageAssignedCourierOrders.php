<?php
ob_start();
include_once '../init.php';

$link = " Delivery Assign Management";
$breadcrumb_item = "Delivery Assign";
$breadcrumb_item_active = "Manage";

// Check if the form is submitted and the action is "processing"
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'delivered') {
    $orderId = $_POST['OrderId'];

    // Update the order status to "Delivered" (ID: 2)
    $db = dbConn();
    $sql = "UPDATE orders SET OrderStatus = 5 WHERE OrderId = ?";
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
    <div class="col-12">
         <a href="<?= SYS_URL ?>delivery/manageReadytoDeliveryOrders.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Ready to Delivery Orders Listing Table</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Delivery Assigned Listing Table</h3>
            </div>

            <div class="card-body">
                <!--Get brands data form brands table-->
                <?php
                
                $db = dbConn();
                // Only select orders with status 3, 4, or 5
                $sql = "SELECT o.*, c.FirstName, c.LastName ,s.CouCompanyName,s.ContPersonName,s.ContactMobile
                        FROM orders o 
                        INNER JOIN customers c ON c.CustomerId = o.CustomerId 
                        INNER JOIN courier_service s ON s.CourierServiceId = o.CourierServiceId 
                        WHERE o.OrderStatus IN (4, 5)";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Number</th>
                            <th>Customer Name</th>
                            <th>Courier Company</th> 
                            <th>Contact Person Name</th>
                            <th>Contact Number</th> 
                            <th>Status</th> 
                            <th>Change Status</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                // Translate payment method value to name
                                $paymentMethod = $row['PaymentMethod'] == 1 ? "Cash on Delivery" : "Bank Transfer";
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['OrderNumber'] ?></td> 
                                    <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td> 
                                    <td><?= $row['CouCompanyName'] ?></td> 
                                    <td><?= $row['ContPersonName'] ?></td>
                                    <td><?= $row['ContactMobile'] ?></td>
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

                                        if ($status == 4) {
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
                                        }
                                        ?>
                                    </td>
                                     <td>
                                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                            <input type="hidden" name="OrderId" value="<?= $row['OrderId'] ?>">
                                            <button type="submit" name="action" value="delivered" class="btn btn-info ml-2" <?= in_array($row['OrderStatus'], [5]) ? 'disabled' : '' ?>>Complete Delivery</button>
                                        </form>
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
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>