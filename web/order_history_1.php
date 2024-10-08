<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['USERID'])) {
    header("Location:login.php");
}
include 'header.php';
include '../function.php';
include '../config.php';
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Order History</h1>
</div>
<!-- Single Page Header End -->

<!-- Order History Details Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <!-- Filter Form Start -->
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="date" name="from_date">
                    <input type="date" name="to_date">
                    <input type="text" name="product_name" placeholder="Enter Product Name">
                    <input type="text" name="supplier_name" placeholder="Enter Supplier Name">
                    <input type="text" name="order_number" placeholder="Enter Order Number">
                    <button type="submit">Filter</button>
                </form>
                <br>
                <!-- Filter Form End -->

                <?php
                $db = dbConn();
                $cusOrderId = $_SESSION['USERID'];

                $sqlcus = "SELECT * FROM customers WHERE UserId='$cusOrderId'";
                $result1 = $db->query($sqlcus);
                $row1 = $result1->fetch_assoc();

                $test = $row1['CustomerId'];

                $where = "WHERE o.CustomerId='$test'"; // Initial WHERE condition

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);

                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " AND o.OrderDate BETWEEN '$from_date' AND '$to_date'";
                    }

                    if (!empty($product_name)) {
                        $where .= " AND products.ProductName LIKE '%$product_name%'";
                    }

                    if (!empty($supplier_name)) {
                        $where .= " AND suppliers.SupCompanyName LIKE '%$supplier_name%'";
                    }

                    if (!empty($order_number)) {
                        $where .= " AND o.OrderNumber LIKE '%$order_number%'";
                    }
                }

                $sql = "SELECT o.*, products.ProductName, suppliers.SupCompanyName 
                        FROM orders o 
                        INNER JOIN products ON o.ProductId = products.ProductId
                        INNER JOIN suppliers ON products.SupplierId = suppliers.SupplierId
                        $where";

                $result = $db->query($sql);
                ?>
                
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Number</th>
                            <th>Order Date</th>
                            <th>Total Amount</th>
                            <th>Quantity</th>
                            <th>Customer Name</th>
                            <th>Shipping Address</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Cancellation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_order'])) {
                            $order_id = $_POST['order_id'];

                            // Update the order status to "Cancelled"
                            $cancel_sql = "UPDATE orders SET OrderStatus='6' WHERE OrderId='$order_id'"; // 6 is the status for "Cancelled"
                            $db->query($cancel_sql);

                            // Redirect to the same page to see the updated status
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }

                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                $paymentMethod = "";
                                if ($row['PaymentMethod'] == 1) {
                                    $paymentMethod = "Cash on Delivery";
                                } elseif ($row['PaymentMethod'] == 2) {
                                    $paymentMethod = "Bank Transfer";
                                }

                                $order_status = $row['OrderStatus'];
                                $sql_status = "SELECT * FROM order_statuses WHERE Status=$order_status";
                                $result_status = $db->query($sql_status);
                                $row_status = $result_status->fetch_assoc();
                                $status = $row_status['Status'];

                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['OrderNumber'] ?></td>
                                    <td><?= $row['OrderDate'] ?></td>
                                    <td><?= $row['TotalAmount'] ?></td>
                                    <td><?= $row['Quantity'] ?></td>
                                    <td><?= $row['PersonalName'] ?></td>
                                    <td><?= $row['ShippingAddressLine1'] ?>, <?= $row['ShippingAddressLine2'] ?>, <?= $row['ShippingCity'] ?></td>
                                    <td><?= $paymentMethod ?></td>
                                    <td>
                                        <?php
                                        if ($status == 1) {
                                            echo '<h5><span class="badge bg-light text-dark">Not Processed</span></h5>';
                                        } elseif ($status == 2) {
                                            echo '<h5><span class="badge bg-dark">Processing</span></h5>';
                                        } elseif ($status == 3) {
                                            echo '<h5><span class="badge bg-warning text-dark">Packed</span></h5>';
                                        } elseif ($status == 4) {
                                            echo '<h5><span class="badge bg-info text-dark">Shipping</span></h5>';
                                        } elseif ($status == 5) {
                                            echo '<h5><span class="badge bg-primary">Delivered</span></h5>';
                                        } elseif ($status == 6) {
                                            echo '<h5><span class="badge bg-secondary">Cancelled</span></h5>';
                                        } elseif ($status == 7) {
                                            echo '<h5><span class="badge bg-success">Accepted</span></h5>';
                                        } elseif ($status == 8) {
                                            echo '<h5><span class="badge bg-danger">Rejected</span></h5>';
                                        }
                                        ?>
                                    </td>
                                    <td><a href="viewOrderDetails.php?orderid=<?= $row['OrderId'] ?>" class="btn btn-info">View Details</a></td>
                                    <td>
                                        <?php
                                        if ($row['OrderStatus'] == 1) {
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                                <input type="hidden" name="order_id" value="<?= $row['OrderId'] ?>">
                                                <button name="cancel_order" class="btn btn-outline-danger"><strong>Cancel</strong></button>
                                            </form>
                                            <?php
                                        } elseif ($row['OrderStatus'] == 6) {
                                            echo "You cancelled the order";
                                        } else {
                                            echo "Time Exceeded";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Order History Details End -->
<?php
include 'footer.php';
?>


<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['USERID'])) {
    header("Location:login.php");
}
include 'header.php';
include '../function.php';
include '../config.php';
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Order History</h1>
</div>
<!-- Single Page Header End -->

<!-- Order History Details Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">

                <!-- Filter Form Start -->
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="text" name="order_number" placeholder="Enter Order Number">
                    <select name="payment_method">
                        <option value="">Select Payment Method</option>
                        <option value="1">Cash on Delivery</option>
                        <option value="2">Bank Transfer</option>
                    </select>
                    <button type="submit">Filter</button>
                </form>
                <br>
                <!-- Filter Form End -->
                <?php
                $db = dbConn();
                $cusOrderId = $_SESSION['USERID'];

                $sqlcus = "SELECT * FROM customers WHERE UserId='$cusOrderId'";
                $result1 = $db->query($sqlcus);
                $row1 = $result1->fetch_assoc();

                $test = $row1['CustomerId'];

                $where = "WHERE o.CustomerId='$test'"; // Initial WHERE condition

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);

                    if (!empty($order_number)) {
                        $where .= " AND o.OrderNumber LIKE '%$order_number%'";
                    }

                    if (!empty($payment_method)) {
                        $where .= " AND o.PaymentMethod = '$payment_method'";
                    }
                }

                $sql = "SELECT * FROM orders o $where";
                $result = $db->query($sql);
                ?>
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Number</th>
                            <th>Order Date</th>  
                            <th>Total Amount</th>  
                            <th>Quantity</th> 
                            <th>Customer Name</th>
                            <th>Shipping Address</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Cancellation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_order'])) {
                            $db = dbConn();
                            $order_id = $_POST['order_id'];

                            // Update the order status to "Cancelled"
                            $cancel_sql = "UPDATE orders SET OrderStatus='6' WHERE OrderId='$order_id'"; // 6 is the status for "Cancelled"
                            $db->query($cancel_sql);

                            // Redirect to the same page to see the updated status
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                // Translate payment method value to name
                                $paymentMethod = "";
                                if ($row['PaymentMethod'] == 1) {
                                    $paymentMethod = "Cash on Delivery";
                                } elseif ($row['PaymentMethod'] == 2) {
                                    $paymentMethod = "Bank Transfer";
                                }
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td  ><?= $row['OrderNumber'] ?></td>
                                    <td  ><?= $row['OrderDate'] ?></td>
                                    <td  ><?= $row['TotalAmount'] ?></td>
                                    <td  ><?= $row['Quantity'] ?></td>
                                    <td  ><?= $row['PersonalName'] ?></td>
                                    <td  ><?= $row['ShippingAddressLine1'] ?> , <?= $row['ShippingAddressLine2'] ?> , <?= $row['ShippingCity'] ?></td>
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

                                        if ($status == 1) {
                                            ?>
                                            <h5><span class="badge bg-light text-dark">
                                                    Not Proccessed
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 2) {
                                            ?>
                                            <h5><span class="badge bg-dark">
                                                    Processing
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 3) {
                                            ?>
                                            <h5><span class="badge bg-warning text-dark">
                                                    Packed
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 4) {
                                            ?>
                                            <h5><span class="badge bg-info text-dark">
                                                    Shipping
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 5) {
                                            ?>
                                            <h5><span class="badge bg-primary">
                                                    Delivered
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 6) {
                                            ?>
                                            <h5><span class="badge bg-secondary">
                                                    cancelled
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 7) {
                                            ?>
                                            <h5><span class="badge bg-success">
                                                    Accepted
                                                </span>
                                            </h5>
                                            <?php
                                        } elseif ($status == 8) {
                                            ?>
                                            <h5><span class="badge bg-danger">
                                                    Rejected
                                                </span>
                                            </h5>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td><a href="viewOrderDetails.php?orderid=<?= $row['OrderId'] ?>" class="btn btn-info">View Details</a></td>

                                    <td>
                                        <?php
                                        if ($row['OrderStatus'] == 1) { // Assuming '1' is the status for "Processing"
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                                <input type="hidden" name="order_id" value="<?= $row['OrderId'] ?>">
                                                <button name="cancel_order" class="btn btn-outline-danger"><strong>Cancel</strong></button>
                                            </form>
                                            <?php
                                        } elseif ($row['OrderStatus'] == 6) { // '6' is the status for "Rejected"
                                            echo "You cancelled the order";
                                        } else {
                                            echo "Time Exceeded";
                                        }
                                        ?>
                                    </td>

                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

<!-- Order History Details End -->
<?php
include 'footer.php';
?>

