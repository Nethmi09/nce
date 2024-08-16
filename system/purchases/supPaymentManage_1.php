<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Purchase Management";
$breadcrumb_item = "Purchase Inventory";
$breadcrumb_item_active = "Manage";
?>
<div class="row">
    <div class="col-12">

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="date" name="from_date">
            <input type="date" name="to_date">
            <input type="text" name="material" placeholder="Enter Item Name">
            <input type="text" name="FirstName" placeholder="Enter Suplier Name">
            <button type="submit">Search</button>
        </form>
        <br>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Stock Details</h3>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <?php
            $where = null;
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                extract($_POST);
                if (!empty($from_date) && !empty($to_date)) {
                    $where .= " material_stock.purchase_date BETWEEN '$from_date' AND '$to_date' AND";
                }

                if (!empty($material)) {
                    $where .= " materials.material='$material' AND";
                }

                if (!empty($FirstName)) {
                    $where .= " supplier.FirstName='$FirstName' AND";
                }

                if (!empty($where)) {
                    $where = substr($where, 0, -3);
                    $where = " WHERE $where";
                }
            }

            $db = dbConn();
            $sql = "SELECT s.*, p.* , i.* , (i.Qty* i.UnitPrice) AS total , suppliers.SupCompanyName FROM price_request_item i
                INNER JOIN product_stocks s
                    ON (s.ProductId = i.itemId)
                INNER JOIN suppliers 
                    ON (suppliers.SupplierId = s.SupplierId)
                     INNER JOIN price_request p 
                    ON (p.Id = i.PriceRequestId)
               $where;";
            $result = $db->query($sql);
            ?>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Price Request ID</th>
                        <th>Invoice Number</th>
                        <th>Total Amount</th>
                        <th>Token</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $total = $row['total'];
                            $_SESSION['TOTAL'] = $total;
                            $_SESSION['INVOICE'] = $row['InvoiceNumber'];
                            ?>
                            <tr>
                                <td><?= $row['SupCompanyName'] ?></td>
                                <td><?= $row['PriceRequestId'] ?></td>
                                <td><?= $row['InvoiceNumber'] ?></td>
                                <td><?= $row['total'] ?></td>
                                <td><?= $row['Token'] ?></td>

                                <td><a href="<?= SYS_URL ?>payment_mail.php?token=<?= $row['Token'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>