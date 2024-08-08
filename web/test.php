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
    header('Location:cart.php');
}

// Decrement the cart quantity
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'decrement') {
    extract($_POST);
    $sqlstock1 = "SELECT * FROM product_stocks WHERE ProductId='$id'";
    $db = dbConn();
    $result1 = $db->query($sqlstock1);
    $row = $result1->fetch_assoc();
    $sqlstock2 = "SELECT * FROM products WHERE ProductId='$id'";
    $db = dbConn();
    $result2 = $db->query($sqlstock2);
    $row2 = $result2->fetch_assoc();

    $current_qty = $_SESSION['cart'][$id]['Quantity'];
    if ($current_qty == 1) {
        ?>
        <script>
            Swal.fire({
                position: "top-end",
                icon: "warning",
                title: "Minimum Quantity Reached",
                text: "Quantity cannot be less than 1.",
                showConfirmButton: false,
                timer: 2500
            });
        </script>

        <?php
    } else {
        $current_qty = $_SESSION['cart'][$id]['Quantity'] - 1;
        $_SESSION['cart'][$id] = array(
            'StockId' => $row['StockId'],
            'ProductId' => $row['ProductId'],
            'ProductName' => $row2['ProductName'],
            'ProductImage' => $row2['ProductImage'],
            'UnitPrice' => $row['UnitPrice'],
            'Quantity' => $current_qty,
            'Profit' => 10);
        echo 'decrement';
    }
}

// Increment the cart quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'increment') {
    extract($_POST);
    $sqlstock1 = "SELECT * FROM product_stocks WHERE ProductId='$id'";
    $db = dbConn();
    $result1 = $db->query($sqlstock1);
    $row = $result1->fetch_assoc();
    $stockss = $row['Quantity'];
    $sqlstock2 = "SELECT * FROM products WHERE ProductId='$id'";
    $db = dbConn();
    $result2 = $db->query($sqlstock2);
    $row2 = $result2->fetch_assoc();
    $current_qty = $_SESSION['cart'][$id]['Quantity'];
    if ($current_qty > $stockss) {
        ?>
        <script>
            Swal.fire({
                position: "top-end",
                icon: "warning",
                title: "Available Quantity Reached",
                showConfirmButton: false,
                timer: 2500
            });
        </script>

        <?php
    } else {
        $current_qty = $_SESSION['cart'][$id]['Quantity'] + 1;
        $_SESSION['cart'][$id] = array(
            'StockId' => $row['StockId'],
            'ProductId' => $row['ProductId'],
            'ProductName' => $row2['ProductName'],
            'ProductImage' => $row2['ProductImage'],
            'UnitPrice' => $row['UnitPrice'],
            'Quantity' => $current_qty,
            'Profit' => 10);
        echo 'increment';
    }
}

extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'checkout') {
    extract($_POST);
    $message = array();
    $quantityUpdated = $_SESSION['cart'][$id]['ProductId'];
    $sqlstock = "SELECT * FROM product_stocks WHERE ProductId='$quantityUpdated'";
    $db = dbConn();
    $result = $db->query($sqlstock);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currntQuantity = $row['Quantity'];
    }

    echo("databaseQuantity" . $currntQuantity);
    echo("requetQuantity" . $current_qty);

    if ($currntQuantity < $Quantity) {
        $message['test'] = "ttttt is required.";

        echo '<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your order has been sent.",
        showConfirmButton: false,
        timer: 1500
    });
</script>';
    }
    print_r($message);
    if (empty($message)) {
        echo 'emptymessage';

        //header("Location:home.php");
    } else {
        echo 'notemptymessage';
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
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
                                        <input type="hidden" name="id" value="<?= $key ?>" > 
                                        <input type="hidden" name="action" value="update_qty" >                         
                                        <div class="d-flex">
                                            <button type="submit" name="action" value="decrement" class="btn btn-sm btn-minus rounded-circle bg-light border" style="margin-right: 5px;"> 
                                                <i class="fa fa-minus"></i> 
                                            </button> 
                                            <input type="text" class="form-control form-control-sm text-center border-0"   
                                                   style="width: 40px; display: flex; justify-content: center; align-items: center;" 
                                                   value="<?= $value['Quantity'] ?>" name="Quantity" >
                                            <button type="submit" name="action" value="increment" class="btn btn-sm btn-plus rounded-circle bg-light border" style="margin-left: 5px;" > 
                                                <i class="fa fa-plus"></i> 
                                            </button> 
                                        </div>
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
                            <h5 class="mb-0 me-4">Discount (3%)</h5>
                            <div class="">
                                <p class="mb-0">LKR 
                                    <?php
                                    echo $discountt = number_format($total * 0.03, 2);
                                    $_SESSION['discount'] = $total * 0.03;
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Net Total</h5>
                            <div class="">
                                <p class="mb-0"> LKR 
                                    <?= number_format(($total - $total * 0.03), 2) ?>
                                </p>
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
                    <?php if (isset($_SESSION['error']) && $_SESSION['error'] === 'true') { ?>
                        <!--                        <a class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">Checkout</a>   -->
                    <?php } else {
                        ?>
                        <!--                        <a class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" href="checkout.php">Checkout</a>-->
                        <?php
                    }
                    ?>
                    <button name="action" value="checkout" type="submit">Checkout</button>
                    </form>
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
