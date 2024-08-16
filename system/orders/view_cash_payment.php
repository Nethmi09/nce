<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Payment";
$breadcrumb_item_active = "Manage";
?>

<div class="row">
    <div class="col-12">

        <a href="<?= SYS_URL ?>orders/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to orders Listing Table</a>

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Order Cash Payment Details</h3>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Payment Details</h3>
                            </div>

                            <div class="card-body">

                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    extract($_POST);
                                    extract($_GET);
                                    //$orderid=$_SESSION['ORDERID'];
                                    $db = dbConn();

                                    $sql_pay = "SELECT o.* FROM orders o WHERE o.OrderId='$order_id'";
                                    $result_pay = $db->query($sql_pay);
                                    $rowpay = $result_pay->fetch_assoc();
                                    $TotalAmount = $rowpay['TotalAmount'];
                                    $PaidAmount = dataClean($PaidAmount);
                                    $cusId = $rowpay['CustomerId'];
                                    $ordId = $rowpay['OrderId'];
                                    $payMethod = $rowpay['PaymentMethod'];

                                    $sql = "INSERT INTO customer_payments (`CustomerId`, `OrderId`, `TotalAmount`, `PaymentMethod`, `PaidAmount`, `DueAmount`, `UploadedSlip`, `PaymentDate`, `Status`) VALUES ('$cusId','$ordId','$TotalAmount','$payMethod','$PaidAmount',null,null,'$paiddate','1')";
                                    $db->query($sql);
                                }
                                ?>


                                <?php
                                extract($_POST);
                                extract($_GET);
                                $db = dbConn();
                                $sql_orders = "SELECT o.* FROM orders o WHERE o.OrderId='$order_id'";
                                $result_orders = $db->query($sql_orders);
                                $roworders = $result_orders->fetch_assoc();

                                $order_number = $roworders['OrderNumber'];
                                $product_total = $roworders['GrandTOTAL'];
                                $discount = $roworders['Discount'];
                                $net_amount = $roworders['NetTotal'];
                                $delivery_charge = $roworders['DeliveryCost'];
                                $total_amount = $roworders['TotalAmount'];
                                ?>
                                <!-- form start -->
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                                    <input type='hidden' name='order_id' value='<?= $order_id ?>'>

                                    <div class="form-group">
                                        <label for="orderNumber">Order Number </label>
                                        <input type="text" class="form-control" id="orderNumber" name="orderNumber" value="<?= @$order_number ?>">

                                    </div>

                                    <div class="form-group">
                                        <label for="paiddate">Paid Date </label>
                                        <input type="date" class="form-control" id="paiddate" name="paiddate">

                                    </div>

                                    <div class="form-group">
                                        <label for="netamount">Total Amount</label>
                                        <input type="text" class="form-control" id="netamount" name="netamount" value="<?= @$total_amount ?>">

                                    </div>

                                    <div class="form-group">
                                        <label for="payamount">Paid Amount </label>
                                        <input type="text" class="form-control" id="PaidAmount" name="PaidAmount" value="<?= @$PaidAmount ?>">

                                    </div>


                                    <input type="submit" action="submit" value="Submit Payment" class="btn btn-info">
                                </form>


                            </div>
                        </div>
                        <!-- /.card -->
                    </div>


                </div>
            </div>

        </div>
    </div>

</div>

<div class="card-body">

    <div class="row">
        <div class="col md-12">
            <div class="card card-info">
                <input type="button" value="View Payment History" class="btn btn-info" data-toggle="modal" data-target="#paymentHistoryModal">

                <!-- Modal Structure -->
                <div class="modal fade" id="paymentHistoryModal" tabindex="-1" role="dialog" aria-labelledby="paymentHistoryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentHistoryModalLabel">Payment History</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    <?php
                                    extract($_POST);
                                    extract($_GET);
                                    $db = dbConn();
                                    $sql_customer_payment = "SELECT * FROM customer_payments WHERE OrderId='$order_id'";
                                    $result_customer_payment = $db->query($sql_customer_payment);
                                    $row_customer_payment = $result_customer_payment->fetch_assoc();

                                    $pay_amount = $row_customer_payment['PaidAmount'];
                                    ?>

                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Order Number</th>
                                                <td><?= $order_number ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Products Total</th>
                                                <td>Rs. <?= number_format($product_total, 2) ?></td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Discount</th>
                                                <td>Rs. <?= number_format($discount, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Net Amount</th>
                                                <td>Rs. <?= number_format($net_amount, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Delivery Charge</th>
                                                <td>Rs. <?= number_format($delivery_charge, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Total Amount</th>
                                                <td>Rs. <?= number_format($total_amount, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Paid Amount</th>
                                                <td>Rs. <?= number_format($pay_amount, 2) ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <input type="submit" action="submit" value="Confirm Payment" class="btn btn-success">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


</div>







<?php
$content = ob_get_clean();
include '../layouts.php';
?>