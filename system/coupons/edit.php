<?php
ob_start();
include_once '../init.php';

$link = "Coupon Management";
$breadcrumb_item = "Coupon";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to fetch coupon details based on the roleid from the URL
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT * FROM coupons WHERE CouponId='$couponid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // Assign fetched coupon details to variables
    $couponNumber = $row['CouponNumber'];
    $discount = $row['Discount'];
    $orderCount = $row['order_count'];
    $CouponId = $row['CouponId'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle POST request to update coupon details
    extract($_POST);
    // Clean input data
   $couponNumber = dataClean($couponNumber);
    $discount = dataClean($discount);

    //Initialize an array to hold error messages
    $message = array();


 // Required validation
     if (empty($couponNumber)) {
        $message['couponNumber'] = "Coupon Number is required.";
    }

    if (empty($discount)) {
        $message['discount'] = "Discount is required.";
    } elseif (!is_numeric($discount) || $discount <= 0) {
        $message['discount'] = "Discount must be a positive number.";
    }


    // Advance validation
    if (!empty($couponNumber)) {
        $db = dbConn();
        $sql = "SELECT * FROM coupons WHERE CouponNumber='$couponNumber'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['couponNumber'] = "This Coupon Number already exists!";
        }
    }



    if (empty($message)) {
        $db = dbConn();
        $sql = "UPDATE coupons SET CouponNumber='$couponNumber', Discount='$discount', order_count='$orderCount' WHERE CouponId='$CouponId'";
        $db->query($sql);
        header("Location: manage.php");
        exit();
    }
}
?>

<div class="row">

    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>coupons/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Coupons Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Coupon</h3>
            </div>   

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!--Coupon Number-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="couponNumber" class="form-label fw-bold">Coupon Number<span style="color: red"> * </span></label>
                            <input type="text" name="couponNumber" class="form-control mb-1" id="couponNumber" value="<?= @$couponNumber ?>" placeholder="Enter Coupon Number" >
                            <span class="text-danger"><?= @$message['couponNumber'] ?></span>
                        </div>                      
                    </div>

                    <!--Discount-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="discount" class="form-label fw-bold">Discount<span style="color: red"> * </span></label>
                            <input type="text" name="discount" class="form-control mb-1" id="discount" value="<?= @$discount ?>" placeholder="Enter Discount Amount" >
                            <span class="text-danger"><?= @$message['discount'] ?></span>
                        </div>                      
                    </div>

                    <!--Order count-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="orderCount" class="form-label fw-bold">Order Count<span style="color: red"> * </span></label>
                            <input type="number" min="1" name="orderCount" class="form-control mb-1" id="orderCount" value="<?= @$orderCount ?>" >
                            <span class="text-danger"><?= @$message['orderCount'] ?></span>
                        </div>                      
                    </div>

                    

                </div>

                 <div class="card-footer">
                     <!-- Hidden input field to pass the CouponId with the form submission -->
                    <input type="hidden" name="CouponId" value="<?= $CouponId ?>">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>

            <!--Form End-->

        </div>
        <!--Card End-->
    </div>

</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
