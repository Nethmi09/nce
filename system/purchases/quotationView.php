<?php
ob_start();
include_once '../init.php';

$link = "Quotation Management";
$breadcrumb_item = "Quotation";
$breadcrumb_item_active = "View";
?> 

    <?php
    extract($_GET);
    extract($_POST);

    $db = dbConn();
    $sqlcheck = "SELECT * FROM price_request WHERE Token='$token'";
    $resultcheck = $db->query($sqlcheck);
    $rowcheck = $resultcheck->fetch_assoc();

    $FinalUpdateDate = $rowcheck['FinalUpdateDate'];
    $cur_date = date('Y-m-d');

    if ($cur_date > $FinalUpdateDate) {
        header("Location: expired_priceRequest.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'submit') {
        extract($_POST);
        foreach ($RequestId as $key => $RId) {
            $sql = "UPDATE price_request_item SET UnitPrice='$UnitPrice[$key]', UpdatedDate='$cur_date' WHERE Id='$RId'";
            $db->query($sql);
        }
    }

    $sql = "SELECT pri.*, p.*, r.ProductName, s.SupCompanyName, pri.Id as irid 
            FROM price_request_item pri 
            LEFT JOIN price_request p ON pri.PriceRequestId=p.Id 
            LEFT JOIN products r ON r.ProductId=pri.ItemId 
            LEFT JOIN suppliers s ON s.SupplierId=p.SupplierId 
            WHERE Token='$token'";
    $result = $db->query($sql);
    ?>
    <div class="row">
        <div class="col-12">
            <a href="<?= SYS_URL ?>purchases/quotationRequestAdd.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Back to Quotation Listing Table</a>
            <div class="card mt">
                <div class="card-header">
                    <h3 class="card-title">View Quotation</h3>
                </div>
                <div class="card-body">
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Request Date</th>
                                    <th>Required Date</th>
                                    <th>Your Final Update Date</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['RequestDate']) ?></td>
                                            <td><?= htmlspecialchars($row['DeliverDate']) ?></td>
                                            <td><?= htmlspecialchars($row['FinalUpdateDate']) ?></td>
                                            <td><?= htmlspecialchars($row['ProductName']) ?></td>
                                            <td><?= htmlspecialchars($row['Qty']) ?></td>
                                            <td>
                                                <input type="hidden" name="RequestId[]" value="<?= htmlspecialchars($row['irid']) ?>">
                                                <input type="text" name="UnitPrice[]" class="form-control" placeholder="Enter Unit Price" value="<?= htmlspecialchars($row['UnitPrice']) ?>">
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="7" class="text-center">No records found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                       
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>