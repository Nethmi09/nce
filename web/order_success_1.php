<?php
session_start();
include 'header.php';
include '../config.php';
?>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your order has been sent.",
        showConfirmButton: false,
        timer: 1500
    });
</script>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Order Success</h1>
</div>
<!-- Single Page Header End -->

<!-- Success Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-center">Thank you for your order! <br> 
                            Here are your order details</h1>

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

                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate>

                            <div class="col-md-12 mt-4 mb-4">
                                <div class="p-5 bg-light rounded ">
                                   
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
                                            <h5 class="mb-0 me-4">Total Payment</h5>
                                            <div class="">
                                                <p class="mb-0">Rs. <?= number_format($net_total_after_coupon, 2) ?></p>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>  
                        </form>

                        <h2>Please click here to track your order status.</h2>
                    <a href="track_order.php" class="btn btn-dark mb-4"></i> Track Order</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php
include 'footer.php';
?>