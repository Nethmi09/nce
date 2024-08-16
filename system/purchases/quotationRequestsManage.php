<?php
ob_start();
include_once '../init.php';

$link = "Quotation Request Management";
$breadcrumb_item = "Quotation Request";
$breadcrumb_item_active = "Manage";
?> 

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = dbConn();
    $sql = "SELECT * FROM price_request";
    $result = $db->query($sql);

    $sql = "INSERT INTO price_request_item(PriceRequestId, ItemId, Qty, UnitPrice, UpdatedDate) VALUES ('$PriceRequestId','$Item','$Qty',null,null)";
    $db->query($sql);
}
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>purchases/quotationRequestAdd.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Create New Quotation Request</a>

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Quotation Requests Details Table</h3>
            </div>
            <div class="card-body">
                <?php
                ?>
                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <?php
                    $db = dbConn();
                    $sql = "SELECT pri.*,p.*,r.ProductName,s.SupCompanyName,s.Email FROM price_request_item pri "
                            . "LEFT JOIN price_request p ON pri.PriceRequestId=p.Id "
                            . "LEFT JOIN products r ON r.ProductId=pri.ItemId "
                            . "LEFT JOIN suppliers s ON s.SupplierId=P.SupplierId";
                    $result = $db->query($sql);
                    ?>
                    <thead>
                        <tr>
                           
                            <th>Supplier Name</th> 
                            <th>Supplier Email</th>
                            <th>Request Date</th>
                            <th>Required Date</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['SupCompanyName'] ?></td>
                                    <td><?= $row['Email'] ?></td>
                                    <td><?= $row['RequestDate'] ?></td>
                                    <td><?= $row['DeliverDate'] ?></td>
                                    <td><?= $row['ProductName'] ?></td>
                                    <td><?= $row['Qty'] ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>

                <!--Table End-->

            </div>

        </div>

    </div>
</div>
<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>