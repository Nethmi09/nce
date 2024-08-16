<?php
session_start();
include 'header.php';
include '../config.php';
include '../function.php';

$db = dbConn();
$orderid = $_GET['orderid'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    
    if (isset($_POST['accept'])) {
        $updateSql = "UPDATE orders SET OrderStatus = 7 WHERE OrderId = '$orderid'";
        if ($db->query($updateSql)) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Order has been accepted.',
                }).then(function() {
                    window.location.href = 'viewOrder.php?orderid=$orderid';
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
    } elseif (isset($_POST['reject'])) {
        $rejectReason = $_POST['rejectReason'];
        $updateSql = "UPDATE orders SET OrderStatus = 8, RejectReason = '$rejectReason' WHERE OrderId = '$orderid'";
        if ($db->query($updateSql)) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Order has been rejected.',
                }).then(function() {
                    window.location.href = 'viewOrder.php?orderid=$orderid';
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
}

// Fetch order details
$sql = "SELECT o.*, c.FirstName, c.LastName, d.Name AS DistrictName 
        FROM orders o 
        INNER JOIN customers c ON c.CustomerId = o.CustomerId 
        INNER JOIN districts d ON d.Id = o.PersonalDistrictId 
        WHERE o.OrderID = '$orderid'";
$result = $db->query($sql);
$row = $result->fetch_assoc();

$orderStatus = $row['OrderStatus'];
$disabled = ($orderStatus == 7 || $orderStatus == 8) ? 'disabled' : '';

?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Order Details</h1>
</div>
<!-- Single Page Header End -->

<!-- Success Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">

                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Order Status</u></h3>
                                <?php
                                if ($orderStatus == 7) {
                                    echo "<span class='badge bg-success'>Accepted</span>";
                                } elseif ($orderStatus == 8) {
                                    echo "<span class='badge bg-danger'>Rejected</span>";
                                    echo "<p>Reason: {$row['RejectReason']}</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Customer Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Customer Name</strong></td>
                                        <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Order Number</strong></td>
                                        <td><?= $row['OrderNumber'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Order Date</strong></td>
                                        <td><?= $row['OrderDate'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Order Summary</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Total Product/s Quantity</strong></td>
                                        <td><?= $row['Quantity'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Grand Total</strong></td>
                                        <td><?= $row['GrandTOTAL'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Discount</strong></td>
                                        <td><?= $row['Discount'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Net Total after Discount</strong></td>
                                        <td><?= $row['NetTotal'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Courier Charge</strong></td>
                                        <td><?= $row['DeliveryCost'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Amount</strong></td>
                                        <td><?= $row['TotalAmount'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col">
                        <form method="POST" action="">
                            <input type="hidden" name="orderid" value="<?= $orderid ?>">
                            <div class="form-group">
                                <button type="submit" name="accept" class="btn btn-success" <?= $disabled ?>>Accept</button>
                            </div>
                            <div class="form-group mt-2">
                                <button type="button" class="btn btn-danger" <?= $disabled ?> onclick="showRejectModal()">Reject</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejectReason">Reason for Rejection</label>
                        <textarea class="form-control" id="rejectReason" name="rejectReason" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="reject" class="btn btn-danger">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal() {
    $('#rejectModal').modal('show');
}
</script>

<?php
include 'footer.php';
?>
