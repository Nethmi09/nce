<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Orders";
$breadcrumb_item_active = "View Bank Payment Slip";

$db = dbConn();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    
    if (isset($_POST['reject'])) {
        $rejectReason = $_POST['rejectReason'];
        
        // Update order status to rejected (status id 8)
        $updateSql = "UPDATE orders SET OrderStatus = 8 WHERE OrderId = '$OrderId'";
        if ($db->query($updateSql)) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Order has been rejected.',
                }).then(function() {
                    window.location.href = '" . SYS_URL . "orders/manage.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update order status. Please try again.',
                });
            </script>";
        }
    } elseif (isset($_POST['accept'])) {
        // Update order status to accepted (status id 7)
        $updateSql = "UPDATE orders SET OrderStatus = 7 WHERE OrderId = '$OrderId'";
        if ($db->query($updateSql)) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Order has been accepted.',
                }).then(function() {
                    window.location.href = '" . SYS_URL . "orders/manage.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update order status. Please try again.',
                });
            </script>";
        }
    }

    // Re-fetch the order details after updating status
    $sql = "SELECT * FROM orders WHERE OrderId='$OrderId'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $paymentSlip = $row['PaymentSlip'] ?? null;
    $order_number = $row['OrderNumber'];
    $total_amount = $row['TotalAmount'];
    $orderStatus = $row['OrderStatus'];
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);

    // Query to get the payment slip for the given order ID
    $sql = "SELECT * FROM orders WHERE OrderId='$OrderId'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $paymentSlip = $row['PaymentSlip'] ?? null;
    $order_number = $row['OrderNumber'];
    $total_amount = $row['TotalAmount'];
    $orderStatus = $row['OrderStatus'];
}
?> 

<div class="row">
    <div class="col-8">
        <a href="<?= SYS_URL ?>orders/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Orders Listing Table</a>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">View Bank Payment Slip</h3>
            </div>         
            <div class="card-body">
                <?php if ($paymentSlip): ?>
                    <div class="text-center">
                        <h2><u>Uploaded Payment Slip</u></h2>
                        <h5>Order Number:  <?= @$order_number ?></h5>
                        <h5 style='color: blue'>Total Amount:  <?= $total_amount ?></h5>
                        <img src="../assets/dist/img/uploads/payments/<?= $paymentSlip ?>" alt="Bank Payment Slip" class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                <?php else: ?>
                    <div class="alert alert-light text-center">
                        No bank payment slip has been uploaded for this order.
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <form id="orderForm" method="post" action="">
                    <input type="hidden" name="OrderId" value="<?= $OrderId ?>">
                    <input type="hidden" name="rejectReason" id="rejectReason" value="">

                    <div class="row">
                        <div class="col-6">
                            <button type="submit" name="reject" id="rejectButton" class="btn btn-danger" <?= ($orderStatus == 7 || $orderStatus == 8) ? 'disabled' : '' ?>>Reject</button>
                        </div>
                        <div class="col-6 text-right">
                            <button type="submit" name="accept" id="acceptButton" class="btn btn-success ml-auto" <?= ($orderStatus == 7 || $orderStatus == 8) ? 'disabled' : '' ?>>Accept</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6">
    </div>  
</div>

<?php
$content = ob_get_clean();
include '../layouts.php';
?>
