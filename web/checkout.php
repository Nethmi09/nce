<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';

if (!isset($_SESSION['USERID'])) {
    header("Location:login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    extract($_POST);
    //Clean the form submitted data
    $personal_name = dataClean($personal_name);
    $personal_email = dataClean($personal_email);
    $personal_contact_mobile = dataClean($personal_contact_mobile);
    $personal_alt_mobile = dataClean($personal_alt_mobile);
    $personal_address_line_1 = dataClean($personal_address_line_1);
    $personal_address_line_2 = dataClean($personal_address_line_2);
    $personal_city = dataClean($personal_city);
    $personal_district = dataClean($personal_district);

    $shipping_name = dataClean($shipping_name);
    $shipping_email = dataClean($shipping_email);
    $shipping_contact_mobile = dataClean($shipping_contact_mobile);
    $shipping_alt_mobile = dataClean($shipping_alt_mobile);
    $shipping_address_line_1 = dataClean($shipping_address_line_1);
    $shipping_address_line_2 = dataClean($shipping_address_line_2);
    $shipping_city = dataClean($shipping_city);
    $shipping_district = dataClean($shipping_district);

    $message = array();
    // Required validation-----------------------------------------------
    if (empty($personal_name)) {
        $message['personal_name'] = "Name is required...!";
    }
    if (empty($personal_email)) {
        $message['personal_email'] = "Email is required...!";
    }
    if (empty($personal_contact_mobile)) {
        $message['personal_contact_mobile'] = "Contact Mobile is required...!";
    }
    if (!isset($personal_alt_mobile)) {
        $message['personal_alt_mobile'] = "Alternate Mobile is required...!";
    }
    if (empty($personal_address_line_1)) {
        $message['personal_address_line_1'] = "Address Line 1 is required...!";
    }
    if (empty($personal_city)) {
        $message['personal_city'] = "City is required...!";
    }
    if (empty($personal_district)) {
        $message['personal_district'] = "Billing District is required...!";
    }

    if (empty($shipping_name)) {
        $message['shipping_name'] = "Name is required...!";
    }
    if (empty($shipping_email)) {
        $message['shipping_email'] = "Email is required...!";
    }
    if (empty($shipping_contact_mobile)) {
        $message['shipping_contact_mobile'] = "Contact Mobile is required...!";
    }
    if (!isset($shipping_alt_mobile)) {
        $message['shipping_alt_mobile'] = "Alternate Mobile is required...!";
    }
    if (empty($shipping_address_line_1)) {
        $message['shipping_address_line_1'] = "Address Line 1 is required...!";
    }
    if (empty($shipping_city)) {
        $message['shipping_city'] = "City is required...!";
    }
    if (empty($shipping_district)) {
        $message['shipping_district'] = "Shipping District is required...!";
    }
   

    if (empty($message)) {
        $db = dbConn();
        $userid = $_SESSION['USERID'];
        //This is the query which used to build to find the relevent customer id using the user id
        $sql = "SELECT CustomerId FROM customers WHERE UserId='$userid'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $customerid = $row['CustomerId'];
        $order_date = date('Y-m-d');
        $order_number = date('Y') . date('m') . date('d') . $customerid;

        $sql = "INSERT INTO orders(OrderNumber, OrderDate, CustomerId, PersonalName, PersonalEmail, PersonalContactMobile, PersonalAlternateMobile, PersonalAddressLine1, PersonalAddressLine2, PersonalCity, PersonalDistrictId, ShippingName, ShippingEmail, ShippingContactMobile, ShippingAlternateMobile, ShippingAddressLine1, ShippingAddressLine2, ShippingCity, ShippingDistrictId) "
                . "VALUES ('$order_number','$order_date','$customerid','$personal_name','$personal_email','$personal_contact_mobile','$personal_alt_mobile','$personal_address_line_1','$personal_address_line_2','$personal_city','$personal_district','$shipping_name','$shipping_email','$shipping_contact_mobile','$shipping_alt_mobile','$shipping_address_line_1','$shipping_address_line_2','$shipping_city','$shipping_district')";
        $db->query($sql);

        $OrderId = $db->insert_id;

        $cart = $_SESSION['cart'];

        foreach ($cart as $key => $value) {
            $StockId = $value['StockId'];
            $ProductID = $value['ProductId'];
            $UnitPrice = $value['UnitPrice'];
            $Quantity = $value['Quantity'];
            $sql = "INSERT INTO order_products(OrderId, ProductId, StockId, UnitPrice, Quantity) VALUES ('$OrderId','$ProductID','$StockId','$UnitPrice','$Quantity')";
            $db->query($sql);
        }
        header("Location:order_success.php");
    }
}
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Checkout</h1>
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
        echo "<a href='cart.php'>" . $total . "[" . $noproducts . "]" . "</a>";
        ?>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate>  <!--Submit to the same page (htmlspecialchars)-->
            <div class="row g-4">
                <!-- Billing Details Card Start -->
                <div class="col-md-6">
                    <div class="p-5 bg-light rounded shadow-sm h-100 d-flex flex-column">
                        <h3 class="mb-4">Billing Details</h3>                   
                        <div class="mb-3">
                            <label for="personal_name">Name<span style="color: red;"> *</span></label>
                            <input type="text" name="personal_name" class="form-control border border-1 mb-4" id="personal_name" value="<?= @$personal_name ?>" placeholder="Enter Name" required>
                            <span class="text-danger"><?= @$message['personal_name'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="personal_email">Email<span style="color: red;"> *</span></label>
                            <input type="email" name="personal_email" class="form-control border border-1 mb-4" id="personal_email" value="<?= @$personal_email ?>" placeholder="Enter Email" required>
                            <span class="text-danger"><?= @$message['personal_email'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="personal_contact_mobile">Contact Mobile<span style="color: red;"> *</span></label>
                            <input type="text" name="personal_contact_mobile" class="form-control border border-1 mb-4" id="personal_contact_mobile" value="<?= @$personal_contact_mobile ?>" placeholder="Enter Contact Mobile" required>
                            <span class="text-danger"><?= @$message['personal_contact_mobile'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="personal_alt_mobile">Alternate Mobile</label>
                            <input type="text" name="personal_alt_mobile" class="form-control border border-1 mb-4" id="personal_alt_mobile" value="<?= @$personal_alt_mobile ?>" placeholder="Enter Alternate Mobile">
                            <span class="text-danger"><?= @$message['personal_alt_mobile'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="personal_address_line_1">Address Line 1<span style="color: red;"> *</span></label>
                            <input type="text" name="personal_address_line_1" class="form-control border border-1 mb-4" id="personal_address_line_1" value="<?= @$personal_address_line_1 ?>" placeholder="Enter Address Line 1" required>
                            <span class="text-danger"><?= @$message['personal_address_line_1'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="personal_address_line_2">Address Line 2</label>
                            <input type="text" name="personal_address_line_2" class="form-control border border-1 mb-4" id="personal_address_line_2" value="<?= @$personal_address_line_2 ?>" placeholder="Enter Address Line 2">
                            <span class="text-danger"><?= @$message['personal_address_line_2'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="personal_city">City<span style="color: red;"> *</span></label>
                            <input type="text" name="personal_city" class="form-control border border-1 mb-4" id="personal_city" value="<?= @$personal_city ?>" placeholder="Enter City" required>
                            <span class="text-danger"><?= @$message['personal_city'] ?></span>
                        </div>
                        <div class="mb-3">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  districts";
                            $result = $db->query($sql);
                            ?>
                            <label for="personal_district">Billing District<span style = "color : red;"> * </span></label>
                            <select name="personal_district" id="personal_district"  class="form-select mb-4 border border-1" value="<?= @$personal_district ?>" aria-label="Large select example">
                                <option value="" >Select District</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['personal_district'] ?></span>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="same_as_personal" name="same_as_personal">
                            <label class="form-check-label fw-bold text-primary" for="same_as_personal">Shipping details are the same as billing details</label>
                        </div>
                    </div>
                </div>
                <!-- Billing Details Card End -->

                <!-- Shipping Details Card Start -->
                <div class="col-md-6">
                    <div class="p-5 bg-light rounded shadow-sm h-100 d-flex flex-column">
                        <h3 class="mb-4">Shipping Details</h3>
                        <div class="mb-3">
                            <label for="shipping_name">Name<span style="color: red;"> *</span></label>
                            <input type="text" name="shipping_name" class="form-control border border-1 mb-4" id="shipping_name" value="<?= @$shipping_name ?>" placeholder="Enter Name" required>
                            <span class="text-danger"><?= @$message['shipping_name'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_email">Email<span style="color: red;"> *</span></label>
                            <input type="email" name="shipping_email" class="form-control border border-1 mb-4" id="shipping_email" value="<?= @$shipping_email ?>" placeholder="Enter Email" required>
                            <span class="text-danger"><?= @$message['shipping_email'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_contact_mobile">Contact Mobile<span style="color: red;"> *</span></label>
                            <input type="text" name="shipping_contact_mobile" class="form-control border border-1 mb-4" id="shipping_contact_mobile" value="<?= @$shipping_contact_mobile ?>" placeholder="Enter Contact Mobile" required>
                            <span class="text-danger"><?= @$message['shipping_contact_mobile'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_alt_mobile">Alternate Mobile</label>
                            <input type="text" name="shipping_alt_mobile" class="form-control border border-1 mb-4" id="shipping_alt_mobile" value="<?= @$shipping_alt_mobile ?>" placeholder="Enter Alternate Mobile">
                            <span class="text-danger"><?= @$message['shipping_alt_mobile'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_address_line_1">Address Line 1<span style="color: red;"> *</span></label>
                            <input type="text" name="shipping_address_line_1" class="form-control border border-1 mb-4" id="shipping_address_line_1" value="<?= @$shipping_address_line_1 ?>" placeholder="Enter Address Line 1" required>
                            <span class="text-danger"><?= @$message['shipping_address_line_1'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_address_line_2">Address Line 2</label>
                            <input type="text" name="shipping_address_line_2" class="form-control border border-1 mb-4" id="shipping_address_line_2" value="<?= @$shipping_address_line_2 ?>" placeholder="Enter Address Line 2">
                            <span class="text-danger"><?= @$message['shipping_address_line_2'] ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_city">City<span style="color: red;"> *</span></label>
                            <input type="text" name="shipping_city" class="form-control border border-1 mb-4" id="shipping_city" value="<?= @$shipping_city ?>" placeholder="Enter City" required>
                            <span class="text-danger"><?= @$message['shipping_city'] ?></span>
                        </div>
                        <div class="mb-3">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  districts";
                            $result = $db->query($sql);
                            ?>
                            <label for="shipping_district">Shipping District<span style = "color : red;"> * </span></label>
                            <select name="shipping_district" id="shipping_district"  class="form-select mb-4 border border-1" value="<?= @$shipping_district ?>" aria-label="Large select example">
                                <option value="" >Select District</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['shipping_district'] ?></span>
                        </div>
                    </div>
                </div>
                <!-- Shipping Details Card End -->
            </div>
            <!-- Place Holder Button Start -->
            <div class="text-center mt-4">
                <button class="btn btn-primary form-control border-secondary py-3 bg-white text-primary" type="submit">Place Order</button>
            </div>
            <!-- Place Holder Button End -->
        </form>

    </div>
</div>


<!-- Checkout page content end -->

<script>
    document.getElementById('same_as_personal').addEventListener('change', function () {
        if (this.checked) {
            document.getElementById('shipping_name').value = document.getElementById('personal_name').value;
            document.getElementById('shipping_email').value = document.getElementById('personal_email').value;
            document.getElementById('shipping_contact_mobile').value = document.getElementById('personal_contact_mobile').value;
            document.getElementById('shipping_alt_mobile').value = document.getElementById('personal_alt_mobile').value;
            document.getElementById('shipping_address_line_1').value = document.getElementById('personal_address_line_1').value;
            document.getElementById('shipping_address_line_2').value = document.getElementById('personal_address_line_2').value;
            document.getElementById('shipping_city').value = document.getElementById('personal_city').value;
            document.getElementById('shipping_district').value = document.getElementById('personal_district').value;
        } else {
            document.getElementById('shipping_name').value = '';
            document.getElementById('shipping_email').value = '';
            document.getElementById('shipping_contact_mobile').value = '';
            document.getElementById('shipping_alt_mobile').value = '';
            document.getElementById('shipping_address_line_1').value = '';
            document.getElementById('shipping_address_line_2').value = '';
            document.getElementById('shipping_city').value = '';
            document.getElementById('shipping_district').value = '';
        }
    });

</script>
<?php
include 'footer.php';
ob_end_flush();
?>

