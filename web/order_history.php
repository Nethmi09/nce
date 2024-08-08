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
                <?php
                $db = dbConn();
                $cusOrderId = $_SESSION['USERID'];

                $sqlcus = "SELECT * FROM customers WHERE UserId='$cusOrderId'";
                $result1 = $db->query($sqlcus);
                $row1 = $result1->fetch_assoc();

                $test = $row1['CustomerId'];

                $sql = "SELECT * FROM orders o WHERE o.CustomerId='$test' ";

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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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
                                    <td  ><?= $row['OrderStatus'] ?></td>
                                    <td><a href="viewOrderDetails.php?orderid=<?= $row['OrderId'] ?>" class="btn btn-info">View Details</a></td>

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