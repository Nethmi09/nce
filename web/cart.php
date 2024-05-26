<?php
ob_start();
session_start();
include 'header.php';
include '../mail.php';
include '../config.php';
extract($_GET);
if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'del') {
    $cart = $_SESSION['cart'];
    unset($cart[$StockId]);
    $_SESSION['cart'] = $cart;
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'empty') {
    $_SESSION['cart'] = array();
}
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Cart</h1>
</div>
<!-- Single Page Header End -->

<!-- Cart Page Content-->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <a href="cart.php?action=empty">Empty Cart</a>
        <div class="p-5 bg-light rounded">
            <div class="table-responsive">             

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $key => $value) {
                            ?>
                            <tr>
                                <td>
                                    <img src="<?= SYS_URL ?>assets/dist/img/uploads/products/<?= $value['ProductImage'] ?>" style="width: 60px; height: 60px;">
                                </td>
                                <td><?= $value['ProductName'] ?></td>
                                <td><?= $value['UnitPrice'] ?></td>
                                <td>
                                    <div class="input-group quantity" style="width: 100px; display: flex; justify-content: center; align-items: center;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border" style="margin-right: 5px;">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div> 

                                        <input type="text" class="form-control form-control-sm text-center border-0" value="<?= $value['Quantity'] ?>" name="Quantity" >

                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border" style="margin-left: 5px;" >
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $product_total = $value['UnitPrice'] * $value['Quantity'];
                                    $total += $product_total;
                                    echo number_format($product_total, 2);
                                    ?>
                                </td>
                                <td>
                                    <a href="cart.php?StockId=<?= $key ?>&action=del">Remove</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                

            </div>
        </div>


        <!-- Cart Total Card -->
        <div class="row justify-content-end mt-4">
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Grand Total</h5>
                            <div class="">
                                <p class="mb-0">LKR <?= number_format($total, 2) ?></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Discount (3%)</h5>
                            <div class="">
                                <p class="mb-0">LKR <?= number_format($total * 0.03, 2) ?></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Net Total</h5>
                            <div class="">
                                <p class="mb-0"> LKR <?= number_format(($total - $total * 0.03), 2) ?></p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="couponCode" class="form-label coupon-label">Enter Coupon</label>
                            <div class="d-flex align-items-center mb-4">
                                <input type="text" id="couponCode" class="border-0 border-bottom rounded me-3 py-2" placeholder="Coupon Code">
                                  <button type="button" class="apply-coupon-btn">Apply Coupon</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Net Total After Coupon</h5>
                            <div class="">
                                <p class="mb-0"> LKR <?= number_format(($total - $total * 0.03), 2) ?></p>
                            </div>
                        </div>

                    </div>

                    <a class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" href="checkout.php">Proceed to Checkout</a>
                </div>
            </div>
        </div>
        <!--Cart Total Card End -->
    </div>
</div>
<!--Cart Page Content End -->


<?php
include 'footer.php';
ob_end_flush();
?> 
