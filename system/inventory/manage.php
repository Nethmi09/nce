<?php
ob_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Inventory";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/add_stock.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Stock</a>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="date" name="from_date">
            <input type="date" name="to_date">
            <input type="text" name="product_name" placeholder="Enter Item Name">
            <input type="text" name="supplier_name" placeholder="Enter Suplier Name">
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
                        . "suppliers.SupCompanyName "
                        . "FROM products "
                        . "INNER JOIN product_stocks ON (products.ProductId=product_stocks.ProductId) "
                        . "INNER JOIN categories ON (categories.CategoryId=products.CategoryId) "
                        . "INNER JOIN suppliers ON (suppliers.SupplierId=product_stocks.SupplierId) $where;";
                $result = $db->query($sql);
                ?>
                <!--Table Start-->

                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>  
                            <th>Category Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Purchase Date</th>
                            <th>Supplier Name</th>

  <!--<th>Status</th>-->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['StockId'] ?></td>
                                    <td><?= $row['ProductName'] ?></td> 
                                    <td><?= $row['CategoryName'] ?></td> 
                                    <td><?= $row['UnitPrice'] ?></td> 
                                    <td><?= $row['Quantity'] ?></td> 
                                    <td><?= $row['PurchaseDate'] ?></td> 
                                    <td><?= $row['SupCompanyName'] ?></td> 

                                    <td>
                                        <a href="<?= SYS_URL ?>inventory/view.php?stockid=<?= $row['StockId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>inventory/edit.php?stockid=<?= $row['StockId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>inventory/delete.php?stockid=<?= $row['StockId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
                                    </td>
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
$content = ob_get_clean();
include '../layouts.php';
?>