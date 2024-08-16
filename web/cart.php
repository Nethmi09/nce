<?php
ob_start();
session_start();
include 'header.php';
include '../mail.php';
include '../config.php';
include '../function.php';

extract($_GET);

// Delete cart row 
if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'del') {
    $cart = $_SESSION['cart'];
    unset($cart[$StockId]);
    $_SESSION['cart'] = $cart;
}

// Clear cart 
if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'empty') {
    $_SESSION['cart'] = array();
}

// Update Quantity
if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'update_qty') {
    if (isset($Quantity) && is_numeric($Quantity) && $Quantity > 0) {
        $productId = $id;
        $current_qty = (int) $Quantity;

        // Query to get available stock
        $db = dbConn();
        $stock_query = "SELECT Quantity FROM product_stocks WHERE ProductId = '$productId'";
        $stock_result = $db->query($stock_query);
        $stock_row = $stock_result->fetch_assoc();
        $available_stock = $stock_row['Quantity'];

        if ($current_qty > $available_stock) {
            echo "<script>
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: 'Requested Quantity Exceeds Available Stock',
                        text: 'Available quantity is $available_stock units.',
                        showConfirmButton: false,
                        timer: 4000
                    });
                  </script>";
        } else {
            $_SESSION['cart'][$productId]['Quantity'] = $current_qty;
            echo "<script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Quantity Updated',
                        text: 'Quantity updated successfully.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Invalid Quantity',
                    text: 'Quantity must be a positive integer.',
                    showConfirmButton: false,
                    timer: 3000
                });
              </script>";
    }
}
?>  

<!--Coupon scenario-->

<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == "coupon") {
    $db = dbConn();
// Check coupan validation(status=1 valid coupon)
    $sql_coupon = "SELECT * FROM coupons WHERE CouponNumber='$couponCode' and Status='1'";
    $result_coupon = $db->query($sql_coupon);

    if ($result_coupon->num_rows > 0) {
        $row_coupon = $result_coupon->fetch_assoc();
        $userid = $_SESSION['USERID'];
        
        // get order count
        $sql_count = "SELECT COUNT(OrderId) AS order_count FROM orders o "
                . "INNER JOIN customers c ON c.CustomerId=o.CustomerId "
                . "INNER join users u ON u.UserId=c.UserId where o.UserId='$userid'";
        $result_count = $db->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $order_count = $row_count['order_count'];
        // check order count and coupon 
        $sql_coupon_count = "SELECT * FROM coupons WHERE order_count <= $order_count ORDER BY order_count DESC LIMIT 1";
        $result_coupon_count = $db->query($sql_coupon_count);
        $row_coupon_count = $result_coupon_count->fetch_assoc();
        $coupon_number = $row_coupon_count ['CouponNumber'];
        $_SESSION['COUPONID'] = $row_coupon_count ['CouponId'];
        // get discount
        if ($coupon_number == $couponCode) {
            $discount_order = $row_coupon_count ['Discount'];
            $_SESSION['COUPONDISCOUNT'] = $discount_order;
        }
    }
}
?>


<!-- Single Page Header start --> 
<div class="container-fluid page-header py-5"> 
    <h1 class="text-center text-white display-6">Cart</h1> 
</div> 
<!-- Single Page Header End --> 

<!-- Cart Page Content Start--> 
<div class="container-fluid contact py-5"> 
    <div class="container py-5"> 
        <a href="cart.php?action=empty">Clear Cart</a> 
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
                        $profit = 0;
                        $noproducts = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $key => $value) {
                                ?> 
                                <tr> 
                                    <td> 
                                        <img src="<?= SYS_URL ?>assets/dist/img/uploads/products/<?= $value['ProductImage'] ?>" style="width: 60px; height: 60px;"> 
                                    </td> 
                                    <td><?= $value['ProductName'] ?></td> 
                                    <td><?= $value['UnitPrice'] ?></td> 
                                    <td> 
                                        <form method="get" action="cart.php"> 
                                            <input type="hidden" name="id" value="<?= $key ?>" > 
                                            <input type="hidden" name="action" value="update_qty" >                         
                                            <input type="text" class="form-control form-control-sm text-center border-0"  
                                                   style="width: 100px; display: flex; justify-content: center; align-items: center;" 
                                                   onchange="form.submit()" value="<?= $value['Quantity'] ?>" name="Quantity" >                                           
                                        </form> 
                                    </td> 

                                    <td> 
                                        <?php
                                        $product_total = $value['UnitPrice'] * $value['Quantity'];
                                        $total += $product_total;
                                        $profit += $value['Profit'];
                                        $noproducts += $value['Quantity'];
                                        echo number_format($product_total, 2);
                                        ?>
                                    </td> 
                                    <td> 
                                        <a href="cart.php?StockId=<?= $key ?>&action=del">Remove</a> 
                                    </td> 
                                </tr> 
                                <?php
                            }
                        }
                        ?> 
                    </tbody> 
                </table> 
            </div> 
        </div> 


        <form method="POST" action="cart.php">
            <div class="mt-5">
                <input type="hidden" name="action" value="update_coupan">
                <input type="text" name="couponCode" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
                <button name="action" class="btn border-secondary rounded-pill px-4 py-3 text-primary" value="coupon" type="submit">Apply Coupon</button>
            </div>
        </form>

        <!-- Cart Total Card --> 
        <div class="row justify-content-end mt-4"> 
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4"> 
                <div class="bg-light rounded"> 
                    <div class="p-4"> 
                        <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1> 
                        <div class="d-flex justify-content-between mb-4"> 
                            <h5 class="mb-0 me-4">Grand Total</h5> 
                            <div class=""> 
                                <p class="mb-0">LKR  
                                    <?php
                                    echo $grndtotal = number_format($total, 2);
                                    $_SESSION['grand_total'] = $total;
                                    ?> 
                                </p> 
                            </div> 
                        </div> 

                        <div class="d-flex justify-content-between mb-4"> 
                            <h5 class="mb-0 me-4">Coupon Discount</h5> 
                            <div class=""> 
                                <p class="mb-0">LKR  
                                    <?php
                                    echo $discountt = number_format($total * @$discount_order / 100, 2);
                                    $_SESSION['Discount'] = $total * @$discount_order / 100;
                                    ?> 
                                </p> 
                            </div> 
                        </div> 

                        <div class="d-flex justify-content-between mb-4"> 
                            <h5 class="mb-0 me-4">Net Total</h5> 
                            <div class=""> 
                                <p class="mb-0"> LKR  
                                    <?php
                                    echo $nettTotal = number_format(($total - $total * @$discount_order / 100), 2);
                                    $_SESSION['netTotal'] = $total - $total * @$discount_order / 100;
                                    ?> 
                                </p> 
                            </div> 
                        </div> 

                        <?php
                        // Calculate and store profit and quantity in session
                        $_SESSION['profit'] = $profit;
                        $_SESSION['quantity'] = $noproducts;
                        ?>



                    </div> 

                    <a class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" href="checkout.php">Checkout</a> 
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