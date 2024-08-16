<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../config.php';
include '../mail.php';

extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'upload') {
    extract($_POST);

    $message = array();

    // Required validation-----------------------------------------------

    if (empty($customer_name)) {
        $message['customer_name'] = "Customer Name is required...!";
    }
    if (empty($order_number)) {
        $message['order_number'] = "Order Number is required...!";
    }
    if (empty($payment_date)) {
        $message['payment_date'] = "Upload Date is required...!";
    }
    $productimage = $_FILES['payment_slip'];
    if ($_FILES['payment_slip']['name'] == "") {
        $message['payment_slip'] = "The Images should not be empty..!";
    }


    if ($_FILES['payment_slip']['name'] != "") {
        $productimage = $_FILES['payment_slip'];
        $filename = $productimage['name'];
        $filetmpname = $productimage['tmp_name'];
        $filesize = $productimage['size'];
        $fileerror = $productimage['error'];
        //take file extension
        $file_ext = explode(".", $filename);
        $file_ext = strtolower(end($file_ext));
        //select allowed file type
        $allowed = array("jpg", "jpeg", "png");
        //check wether the file type is allowed
        if (in_array($file_ext, $allowed)) {
            if ($fileerror === 0) {
                //file size gives in bytes
                if ($filesize <= 6291456) {
                    //giving appropriate file name. Can be duplicate have to validate using function
                    $file_name_new = uniqid('', true) . $customer_name . '.' . $file_ext;
                    //directing file destination
                    $file_path = "../system/assets/dist/img/uploads/payments/" . $file_name_new;
                    //moving binary data into given destination
                    if (move_uploaded_file($filetmpname, $file_path)) {
                        "The file is uploaded successfully";
                    } else {
                        $message['file_error'] = "File is not uploaded";
                    }
                } else {
                    $message['file_error'] = "File size is invalid";
                }
            } else {
                $message['file_error'] = "File has an error";
            }
        } else {
            $message['file_error'] = "Invalid File type";
        }
    }

    if (empty($message)) {
        $db = dbConn();
        $sql1 = "SELECT * FROM orders WHERE OrderId='$order_number'";
        $result1 = $db->query($sql1);
        $row = $result1->fetch_assoc();
        $cusId = $row['CustomerId'];
        $ordId = $row['OrderId'];
        $payMethod = $row['PaymentMethod'];
        $totalAmount = $row['TotalAmount'];

        $sql = "INSERT INTO customer_payments (`CustomerId`, `OrderId`, `TotalAmount`, `PaymentMethod`, `PaidAmount`, `DueAmount`, `UploadedSlip`, `PaymentDate`, `Status`) VALUES ('$cusId','$ordId','$totalAmount','$payMethod',null,null,'$file_name_new','$payment_date','1')";
        $db->query($sql);
        $updatesql1 = "UPDATE orders SET PaymentSlip ='$file_name_new' WHERE OrderId = '$order_number'";
        $db->query($updatesql1);

        header("Location:order_success.php");
    }
}
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Bank Payment</h1>
</div>
<!-- Single Page Header End -->

<!-- Bank Payment content start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">

        <!--Bank Details Card Start-->
        <div class="row">

            <!-- Bank Details Card Start -->
            <div class="col-md-4 mt-4 mb-4">
                <div class="p-3 bg-light rounded">
                    <h4 class="mb-3">Bank Details of NCE</h4>
                    <div class="mb-3">
                        <strong>Account Name:</strong> Namarathna Cellular
                    </div>
                    <div class="mb-3">
                        <strong>Account Number:</strong> 4135420005785011
                    </div>
                    <div class="mb-3">
                        <strong>Bank:</strong> Sampath Bank
                    </div>
                    <div class="mb-3">
                        <strong>Bank Branch:</strong> Radawana
                    </div>
                </div>
            </div>
            <!-- Bank Details Card End -->

            <!-- Customer Payment Card Start -->
            <div class="col-md-8 mt-4 mb-4">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="" novalidate enctype="multipart/form-data">
                    <div class="rounded-border mb-4">
                        <h4>Customer Payment</h4>
                        <p>Kindly pay and upload your payment slip.</p>

                        <div class="mb-3">
                            <label for="customer_name">Customer Name<span style="color: red;"> *</span></label>
                            <?php
                            $customer_name = $_SESSION['FIRSTNAME'] . " " . $_SESSION['LASTNAME'];
                            ?>
                            <input type="text" name="customer_name" class="form-control border border-1 mb-4" id="personal_name" value="<?= @$customer_name ?>" placeholder="Enter Name" required>
                            <span class="text-danger"><?= @$message['customer_name'] ?></span>
                        </div>

                        <div class="mb-3">
                            <?php
                            $db = dbConn();
                            $userid = $_SESSION['USERID'];

// Updated SQL query to filter orders with payment method 'Bank Transfer' (PaymentMethod = 2)
                            $sql = "SELECT OrderId, OrderNumber 
                                    FROM orders 
                                    WHERE CustomerId IN (SELECT CustomerId FROM customers WHERE UserId='$userid')
                                    AND PaymentMethod = '2'";
                            $result = $db->query($sql);
                            ?>
                            <label for="order_number">Order Number<span style="color: red;"> *</span></label>
                            <select name="order_number" id="order_number" class="form-select mb-4 border border-1" required>
                                <option value="">Select Order Number</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['OrderId'] ?>"><?= $row['OrderNumber'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['order_number'] ?></span>
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <label for="payment_date">Upload Date:<span style="color: red;"> *</span></label>
                                <input type="date" name="payment_date" id="payment_date" class="form-control border border-1" value="<?= @$payment_date ?>">
                                <span class="text-danger"><?= @$message['payment_date'] ?></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="mb-3">
                                <label for="payment_slip">Upload Payment Slip:<span style="color: red;"> *</span></label>
                                <input type="file" name="payment_slip" id="payment_slip" class="form-control border border-1" value="<?= @$payment_slip ?>">
                                <span class="text-danger"><?= @$message['payment_slip'] ?></span>
                            </div>
                        </div>
                        <button type="submit" name="action" value="upload" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase">Upload</button>
                    </div>
                </form>
            </div>
            <!-- Customer Payment Card End -->            

        </div>
    </div>
</div>

<!-- Bank Payment content end -->

<?php
include 'footer.php';
ob_end_flush();
?>
