<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);
    $total = $_SESSION['TOTALAMOUNT'];
    $deliveryyy = $_SESSION['DELIVERYCOST'];

    $message = array();

    // Required validation-----------------------------------------------

    if (empty($payment_method)) {
        $message['payment_method'] = "Payment Method is required...!";
    }

    if (empty($message)) {
        $db = dbConn();
        $processCheckout = $_SESSION['lastInsertId'];

        $OrderId = $_SESSION['lastInsertId'];

        // Update the order table
        $updatesql = "UPDATE orders SET DeliveryCost = '$deliveryyy', TotalAmount = '$total' , PaymentMethod = '$payment_method' WHERE OrderId = '$OrderId'";
        $db->query($updatesql);

        unset($_SESSION['cart']);

        // Redirect based on payment method
        if ($payment_method == '1') {
            header("Location:order_success.php");
        } elseif ($payment_method == '2') {
            header("Location:bankDetails.php");
        } else {
            header("Location:processCheckoutPayment.php");
        }
    }
}
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Payment Details</h1>
</div>
<!-- Single Page Header End -->

<!-- Checkout page content start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <?php
        $total = 0;
        $noproducts = 0;
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            foreach ($cart as $key => $value) {
                $total += $value['Quantity'] * $value['UnitPrice'];
                $noproducts += $value['Quantity'];
            }
        }
        ?>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate>  <!--Submit to the same page (htmlspecialchars)-->

            <!-- Order Summary Card Start -->
            <div class="col-md-12 mt-4 mb-4">
                <div class="p-5 bg-light rounded ">
                    <h1 class="display-6 mb-4">Order <span class="fw-normal">Summary</span></h1>
                    <div class="">             

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $all_products_total_amount = 0;
                                $disCount = $_SESSION['Discount'];
                                $netTOtal = $_SESSION['netTotal'];
                                foreach ($cart as $key => $value) {
                                    ?>

                                    <tr>
                                        <td><?= $value['ProductName'] ?></td>
                                        <td>Rs. <?= $value['UnitPrice'] ?></td>
                                        <td><?= $value['Quantity'] ?></td>
                                        <td>
                                            <?php
                                            $product_line_total = $value['UnitPrice'] * $value['Quantity'];
                                            $all_products_total_amount += $product_line_total;
                                            echo number_format($product_line_total, 2);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                $discount = 0;
                                $net_total = $all_products_total_amount - $discount;
                                ?>
                            </tbody>

                        </table>

                        <div class="d-flex justify-content-between mb-4 mt-4">
                            <h5 class="mb-0 me-4">Products Total</h5>
                            <div class="">
                                <p class="mb-0">Rs. <?= number_format($all_products_total_amount, 2) ?></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Discount</h5>
                            <div class="">
                                <p class="mb-0">Rs. <?= number_format($disCount, 2) ?></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Net Total</h5>
                            <div class="">
                                <p class="mb-0"> Rs. <?= number_format($netTOtal, 2) ?></p>
                            </div>
                        </div>
                        <div class="rounded-border mb-4">
                            <h4 class="mt-2">Delivery</h4>

                            <p>The courier charge will vary by shipping district.</p>
                            <?php
                            extract($_GET);
                            $db = dbConn();
                            //$shipdistrict = $_SESSION['ShippingDISTRICT'];
                            ?>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Courier Charge</h5>
<!--<p class="mb-0"><?= $shipdistrict ?></p>-->
                                <?php
                                extract($_GET);
                                $db = dbConn();
                                $OrderId = $_SESSION['lastInsertId'];
                                $sql = "SELECT d.DeliveryCost,d.Name FROM districts d inner join orders o ON o.ShippingDistrictId=d.Id WHERE o.OrderId='$OrderId'";
                                $result1 = $db->query($sql);
                                $row_district = $result1->fetch_assoc();
                                //$district = $row_district['Name'];
                                //$_SESSION['ShippingDISTRICT'] = $row_district['Name'];
                                $delivery_cost = $row_district['DeliveryCost'];
                                $_SESSION['DELIVERYCOST'] = @$delivery_cost;
                                ?>
                                <div class="">

                                    <p class="mb-0" id="courier_cost">Rs. <?= number_format($delivery_cost, 2) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4 rounded-border bg-info text-white p-3">
                            <h5 class="mb-0 me-4">Total Payment</h5>
                            <?php
                            extract($_GET);
                            $db = dbConn();
                            // Calculate the total payment
                            $netTotal = $_SESSION['netTotal'];  // Assuming this includes all discounts
                            $total_payment = $netTotal + $delivery_cost;

                            $_SESSION['TOTALAMOUNT'] = @$total_payment;
                            ?>
                            <div class="">
                                <p class="mb-0" id="total_payment">Rs. <?= number_format($total_payment, 2) ?></p>
                            </div>
                        </div>


                        <div>
                            <label for="payment_method">Payment Method<span style = "color : red;"> * </span></label>
                            <select name="payment_method" id=""  class="form-select mb-4 border border-1" value="<?= @$payment_method ?>" aria-label="Large select example">
                                <option value="" >Select Payment Method</option>
                                <option value="1" >Cash on Delivery</option>
                                <option value="2" >Bank Transfer</option>

                            </select>
                        </div>

                        <!-- Place Order Button Start -->
                        <div class="text-center mt-4">
                            <button class="btn btn-primary form-control border-secondary py-3 bg-white text-primary" type="submit">Place Order</button>
                        </div>
                        <!-- Place Order Button End -->


                    </div>
                </div>
            </div>
            <!-- Order Summary Card End -->            

    </div>
    <!--Bank Details and Order Summary Cards Start-->

</form>

</div>
</div>

<!-- Checkout page content end -->


<?php
include 'footer.php';
?>
