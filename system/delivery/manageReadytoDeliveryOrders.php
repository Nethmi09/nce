<?php
ob_start();
include_once '../init.php';

$link = "Delivery Management";
$breadcrumb_item = "Delivery";
$breadcrumb_item_active = "Manage";
?> 

<div class="col text-right">
    <div class="btn-group" role="group">       
        <a href="<?= SYS_URL ?>delivery/manageAssignedCourierOrders.php" class="btn btn-primary mr-2">Manage Orders with Assigned Couriers</a>
    </div>
</div>
<br>

<div class="row">
    <div class="col-12">

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Ready to Delivery Orders Details Table</h3>
            </div>
            <div class="card-body">
                <?php
                $db = dbConn();
                // Only select orders with status 3, 4, or 5
                $sql = "SELECT o.*, c.FirstName, c.LastName 
                        FROM orders o 
                        INNER JOIN customers c ON c.CustomerId = o.CustomerId 
                        WHERE o.OrderStatus IN (3, 4, 5)";
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
                            <th>View Order</th>
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

                                        if ($status == 3) {
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
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?= SYS_URL ?>delivery/assign_courier.php?order_id=<?= $row['OrderId'] ?>" ><u>Assign courier</u></a>
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
