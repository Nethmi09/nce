<?php
ob_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Inventory";
$breadcrumb_item_active = "Manage";
?> 

<?php
// Extracts POST data and updates the status of an inventory if the action is 'update'.
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    extract($_POST);
    $db = dbConn();
    $sql = "UPDATE product_stocks SET Status = '$UpdateStatus' WHERE StockId='$StockId'";

    $result = $db->query($sql);
}
?> 

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/add_stock.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Stock</a>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="date" name="from_date">
            <input type="date" name="to_date">
            <input type="text" name="product_name" placeholder="Enter Item Name">
            <input type="text" name="supplier_name" placeholder="Enter Supplier Name">
            <button type="submit">Filter</button>
        </form>
        <br>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Inventory Details Table</h3>
            </div>
            <div class="card-body">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);

                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " product_stocks.PurchaseDate BETWEEN '$from_date' AND '$to_date' AND";
                    }

                    if (!empty($product_name)) {
                        $where .= " products.ProductName='$product_name' AND";
                    }

                    if (!empty($supplier_name)) {
                        $where .= " suppliers.SupCompanyName='$supplier_name' AND";
                    }

                    if (!empty($where)) {
                        $where = substr($where, 0, -3);
                        $where = " WHERE $where";
                    }
                }

                $db = dbConn();
                $sql = "SELECT "
                        . "product_stocks.StockId, "
                        . "products.ProductName, "
                        . "categories.CategoryName, "
                        . "product_stocks.UnitPrice, "
                        . "product_stocks.Quantity, "
                        . "product_stocks.PurchaseDate, "
                        . "product_stocks.IssuedQuantity, "
                        . "product_stocks.InvoiceNumber, "
                        . "product_stocks.Status, "
                        . "suppliers.SupCompanyName "
                        . "FROM products "
                        . "INNER JOIN product_stocks ON (products.ProductId=product_stocks.ProductId) "
                        . "INNER JOIN categories ON (categories.CategoryId=products.CategoryId) "
                        . "INNER JOIN suppliers ON (suppliers.SupplierId=product_stocks.SupplierId) $where;";
                $result = $db->query($sql);
                ?>
                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>  
                            <th>Category Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Issued Quantity</th>
                            <th>Balance Quantity</th>
                            <th>Reorder Level</th>
                            <th>Supplier Name</th>
                            <th>Invoice Number</th>
                            <th>Purchase Date</th>
                            <th>Status</th> 
                            <th>Set Activation Status</th>
                            <th>Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                $balanceQuantity = $row['Quantity'] - $row['IssuedQuantity'];
                                $rowClass = $balanceQuantity <= 5 ? 'table-danger' : '';
                                ?>
                                <tr class="<?= $rowClass ?>">
                                    <td><?= $i ?></td>
                                    <td><?= $row['ProductName'] ?></td> 
                                    <td><?= $row['CategoryName'] ?></td> 
                                    <td><?= $row['UnitPrice'] ?></td> 
                                    <td><?= $row['Quantity'] ?></td> 
                                    <td><?= $row['IssuedQuantity'] ?></td> 
                                    <td><?= $balanceQuantity ?></td>
                                    <td>5</td> <!-- Reorder Level -->
                                    <td><?= $row['SupCompanyName'] ?></td> 
                                    <td><?= $row['InvoiceNumber'] ?></td> 
                                    <td><?= $row['PurchaseDate'] ?></td> 

                                    <td>
                                        <?php
                                        // Displays the status of an inventory with styled badges (Active/Inactive).
                                        $status = $row['Status'];
                                        if ($status == 1) {
                                            ?>
                                            <h5><span class="badge badge-pill" style="background-color: green; color: white; padding: 10px 20px; border-radius: 25px; display: inline-block; text-align: center;">
                                                    Active
                                                </span></h5>
                                        <?php } elseif ($status == 0) {
                                            ?>
                                            <h5><span class="badge badge-pill" style="background-color: red; color: white; padding: 10px 20px; border-radius: 25px; display: inline-block; text-align: center;">
                                                    Deactive
                                                </span></h5>
                                        <?php }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // Show appropriate button based on the inventory's status (Active/Inactive).
                                        $status = $row['Status'];
                                        if ($status == 1) {
                                            // Status is Active, show the 'Click to Deactivate' button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="StockId" value="<?= $row['StockId'] ?>">
                                                <input type="hidden" name="UpdateStatus" value="0">
                                                <button type="submit" name="action" value="update" class="btn btn-danger" style="width: 200px; height: 50px;">
                                                    Click to Deactivate
                                                </button>
                                            </form>
                                            <?php
                                        } elseif ($status == 0) {
                                            // Status is Inactive, show the 'Click to Activate' button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="StockId" value="<?= $row['StockId'] ?>">
                                                <input type="hidden" name="UpdateStatus" value="1">
                                                <button type="submit" name="action" value="update" class="btn btn-success" style="width: 200px; height: 50px;">
                                                    Click to Activate
                                                </button>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // Show appropriate button based on the balance quantity.
                                        if ($balanceQuantity <= 5) {
                                            ?>
                                             <a href="<?= SYS_URL ?>purchases/quotationRequestAdd.php" class="btn btn-warning"><u>Request Quotation</u></a>
                                            <?php
                                        } else {
                                            ?>
                                             <a href="" style="color: green"><b>Available stock<b></b></a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <?php
                                $i++;
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
