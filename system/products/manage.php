<?php
ob_start();
include_once '../init.php';

$link = "Product Management";
$breadcrumb_item = "Product";
$breadcrumb_item_active = "Manage";
?> 

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/add.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Product</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Product Details Table</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT ProductId,ProductImage,ProductName, b.BrandName, c.CategoryName, s.SupCompanyName, PurchasePrice, SellingPrice FROM products p "
                        . "INNER JOIN brands b ON b.BrandID=p.BrandID "
                        . "INNER JOIN categories c ON c.CategoryId=p.CategoryId "
                        . "INNER JOIN suppliers s ON s.SupplierId=p.SupplierId";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Image</th>                                                  
                            <th>Product Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th>Purchase Price(LKR)</th>
                            <th>Selling Price(LKR)</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['ProductId'] ?></td>
                                    <td>
                                        <?php if (!empty($row['ProductImage'])): ?>
                                            <img src="../assets/dist/img/uploads/products/<?= $row['ProductImage'] ?>" class="img-square elevation-2" width="50">
                                        <?php else: ?>
                                            <img src="../assets/dist/img/default-image.png" class="img-square elevation-2" width="50">
                                        <?php endif; ?>
                                    </td> 
                                    <td><?= $row['ProductName'] ?></td> 
                                    <td><?= $row['BrandName'] ?></td> 
                                    <td><?= $row['CategoryName'] ?></td> 
                                    <td><?= $row['SupCompanyName'] ?></td> 
                                    <td><?= $row['PurchasePrice'] ?></td> 
                                    <td><?= $row['SellingPrice'] ?></td> 
                                    <td>
                                        <a href="<?= SYS_URL ?>products/view.php?productid=<?= $row['ProductId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>products/edit.php?productid=<?= $row['ProductId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>products/delete.php?productid=<?= $row['ProductId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
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

</div>

<?php
$content = ob_get_clean();
include '../layouts.php';
?>