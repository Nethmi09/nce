<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);

    $message = array();

    // Required validation-----------------------------------------------
    if (empty($courier_district)) {
        $message['courier_district'] = "Courier District is required...!";
    }
    if (empty($payment_method)) {
        $message['payment_method'] = "Payment Method is required...!";
    }

    if (empty($message)) {
        $db = dbConn();
        $processCheckout = $_SESSION['lastInsertId'];
        $checksql11 = "SELECT * FROM districts WHERE Id = '$courier_district'";
        $resultCheck = $db->query($checksql11);

        $rowCheck = $resultCheck->fetch_assoc();
        $courier_cost = $rowCheck['DeliveryCost'];

        $OrderId = $_SESSION['lastInsertId'];

        // Calculate the total payment again in PHP
        $cart = $_SESSION['cart'];
        $all_products_total_amount = 0;
        foreach ($cart as $key => $value) {
            $product_line_total = $value['UnitPrice'] * $value['Quantity'];
            $all_products_total_amount += $product_line_total;
        }
        $discount = $all_products_total_amount * 0.03; // Assuming a 3% discount
        $net_total = $all_products_total_amount - $discount;
        $coupon_discount = $net_total * 0.05; // Assuming a 5% coupon discount
        $net_total_after_coupon = $net_total - $coupon_discount;
        $total_payment = $net_total_after_coupon + $courier_cost;

        // Update the order table with courier district, courier cost, payment method, and total amount using session id
        $updatesql = "UPDATE orders SET DistrictId = '$courier_district', DeliveryCost = '$courier_cost', PaymentMethod = '$payment_method', TotalAmount = '$total_payment' WHERE OrderId = '$OrderId'";
        $db->query($updatesql);

        // Check payment method with user redirection pages
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
                                $discount = 0;
                                $net_total = 0;
                                $coupon_discount = 0;
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
                                $discount = $all_products_total_amount * 0.03; // Assuming a 3% discount
                                $net_total = $all_products_total_amount - $discount;
                                $coupon_discount = $net_total * 0.05; // Assuming a 5% coupon discount
                                $net_total_after_coupon = $net_total - $coupon_discount;
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
                            <h5 class="mb-0 me-4">Discount (3%)</h5>
                            <div class="">
                                <p class="mb-0">Rs. <?= number_format($discount, 2) ?></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Net Total</h5>
                            <div class="">
                                <p class="mb-0"> Rs. <?= number_format($net_total, 2) ?></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Coupon Discount (5%)</h5>
                            <div class="">
                                <p class="mb-0">Rs. <?= number_format($coupon_discount, 2) ?></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Net Total After Coupon Discount</h5>
                            <div class="">
                                <p class="mb-0">Rs. <?= number_format($net_total_after_coupon, 2) ?></p>
                            </div>
                        </div>

                        <div class="rounded-border mb-4">
                            <h4 class="mt-2">Delivery</h4>

                            <p>The courier charge will vary by district. Please select your district to view the courier charge.</p>

                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM districts";
                            $result = $db->query($sql);
                            ?>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="courier_district">Courier District<span style="color: red;"> *</span></label>
                                    <?php
                                    $courier_district = $_SESSION['DISTRICT'];
                                    ?>
                                    <select name="courier_district" id="courier_district" class="form-select border border-1" value="<?= @$courier_district ?>" aria-label="Courier District" onchange="updateDeliveryCost()">
                                        <option value="">Select District</option>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value="<?= $row['Id'] ?>" data-cost="<?= $row['DeliveryCost'] ?>" <?= $row['Id'] == $courier_district ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?= @$message['courier_district'] ?></span>
                                </div>

                            </div>

                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Courier Charge</h5>
                                <div class="">
                                    <p class="mb-0" id="courier_cost">Rs. 0.00</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4 rounded-border bg-info text-white p-3">
                            <h5 class="mb-0 me-4">Total Payment</h5>
                            <div class="">
                                <p class="mb-0" id="total_payment"></p>
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

                        <!-- Place Holder Button Start -->
                        <div class="text-center mt-4">
                            <button class="btn btn-primary form-control border-secondary py-3 bg-white text-primary" type="submit">Place Order</button>
                        </div>
                        <!-- Place Holder Button End -->


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

<script>
    function updateDeliveryCost() {
        const selectElement = document.getElementById('courier_district');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const deliveryCost = parseFloat(selectedOption.getAttribute('data-cost'));
        const courierCostElement = document.getElementById('courier_cost');
        const totalPaymentElement = document.getElementById('total_payment');

        courierCostElement.textContent = `Rs. ${deliveryCost.toFixed(2)}`;

        const netTotalAfterCoupon = <?= $net_total_after_coupon ?>;
        const totalPayment = netTotalAfterCoupon + deliveryCost;
        totalPaymentElement.textContent = `Rs. ${totalPayment.toFixed(2)}`;
        
        // Update hidden input for total payment
        document.getElementById('hidden_total_payment').value = totalPayment;
    }

    // Call the function once to initialize the values if a district is already selected
    updateDeliveryCost();
</script>

<input type="hidden" id="hidden_total_payment" name="total_payment" value="">

<?php
include 'footer.php';
ob_end_flush();
?>
