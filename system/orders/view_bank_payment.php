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
                <h3 class="card-title">Order Bank Payment Details</h3>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col md-6">
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

                                    $sql_pay = "SELECT o.*,c.* FROM orders o INNER JOIN customer_payments c ON c.OrderId=o.OrderId WHERE o.OrderId='$order_id'";
                                    $result_pay = $db->query($sql_pay);
                                    $rowpay = $result_pay->fetch_assoc();
                                    $TotalAmount = $rowpay['TotalAmount'];
                                    
                                    $paidamnt = $rowpay['PaidAmount'];

                                    $PaidAmount = dataClean($PaidAmount);
                                    
                                    $paidamnt+=$PaidAmount;

                                    $sql = "UPDATE customer_payments SET PaidAmount=$paidamnt, DueAmount=$TotalAmount-$paidamnt WHERE OrderId='$order_id'";
                                    $db->query($sql);
                                }
                                ?>

                                <?php
                                extract($_POST);
                                extract($_GET);
                                $db = dbConn();
                                $sql_orders = "SELECT o.*,c.* FROM orders o INNER JOIN customer_payments c ON c.OrderId=o.OrderId WHERE o.OrderId='$order_id'";
                                $result_orders = $db->query($sql_orders);
                                $roworders = $result_orders->fetch_assoc();

                                $order_number = $roworders['OrderNumber'];
                                $total_amount = $roworders['TotalAmount'];
                                $paymentdate = $roworders['PaymentDate'];
                                ?>
                                <!-- form start -->
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                                    <input type='hidden' name='order_id' value='<?= $order_id ?>'>

                                    <div class="form-group">
                                        <label for="orderNumber">Order Number </label>
                                        <input type="text" class="form-control" id="orderNumber" name="orderNumber" value="<?= @$order_number ?>">

                                    </div>

                                    <div class="form-group">
                                        <label for="date">Paid Date </label>
                                        <input type="text" class="form-control" id="paymentdate" name="paymentdate" value="<?= @$paymentdate ?>">

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


                    <div class="col md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Payment History</h3>
                            </div>

                            <div class="card-body">

                                <?php
                                extract($_POST);
                                extract($_GET);
                                $db = dbConn();
                                $sql_orders = "SELECT o.*,c.* FROM orders o INNER JOIN customer_payments c ON c.OrderId=o.OrderId WHERE o.OrderId='$order_id'";
                                $result_orders = $db->query($sql_orders);
                                $roworders = $result_orders->fetch_assoc();
                                $order_number = $roworders['OrderNumber'];
                                $product_total = $roworders['GrandTOTAL'];
                                $discount = $roworders['Discount'];
                                $net_amount = $roworders['NetTotal'];
                                $delivery_charge = $roworders['DeliveryCost'];
                                $total_amount = $roworders['TotalAmount'];
                                $pay_amount = $roworders['PaidAmount'];
                                $due_amount = $roworders['DueAmount'];
                                ?>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
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
                                            <tr>
                                                <th scope="row" style="color: red;">Due Amount</th>
                                                <td style="color: red;">Rs. <?= number_format($due_amount, 2) ?></td>
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