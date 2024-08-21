<?php
ob_start();
include_once '../init.php';

$link = "Product Management";
$breadcrumb_item = "Product";
$breadcrumb_item_active = "Manage";
?> 
<?php
// Extracts POST data and updates the status of a brand if the action is 'update'.
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    extract($_POST);
    $db = dbConn();
    $sql = "UPDATE products SET PStatus= '$UpdateStatus' where ProductId='$ProductId'";

    $result = $db->query($sql);
}
?>
 <div class="col text-right">
    <div class="btn-group" role="group">       
<!--        <a href="<?= SYS_URL ?>batchNumber/manage.php" class="btn btn-primary mr-2">Manage Batch Numbers</a>-->
<!--        <a href="<?= SYS_URL ?>serialNumber/manage.php" class="btn btn-secondary mr-2">Manage Serial Numbers</a>-->
         <a href="<?= SYS_URL ?>colors/manage.php" class="btn btn-success mr-2">Manage Colors</a>
        <a href="<?= SYS_URL ?>coupons/manage.php" class="btn btn-info mr-2">Manage Coupon Codes</a>
<!--        <a href="<?= SYS_URL ?>warranty/manage.php" class="btn btn-dark">Manage Warranty Periods</a>-->
    </div>
</div>


<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/productAdd.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Product</a>
        
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Products Listing  Table</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT ProductId,ProductImage,ProductName, m.MainCategoryName, b.BrandName, c.CategoryName, s.SupCompanyName, PurchasePrice, SellingPrice, Quantity, PStatus FROM products p "
                         . "INNER JOIN main_categories m ON m.MainCategoryId=p.MainCategoryId "
                        . "INNER JOIN brands b ON b.BrandID=p.BrandID "
                        . "INNER JOIN categories c ON c.CategoryId=p.CategoryId "
                        . "INNER JOIN suppliers s ON s.SupplierId=p.SupplierId";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          
                            <th>Product Image</th>                                                  
                            <th>Product Name</th>
                             <th>Main Category</th>
                              <th>Category</th>
                            <th>Brand</th>
                            <th>Supplier</th>
                            <th>Purchase Price(LKR)</th>
                            <th>Selling Price(LKR)</th>
                             <th>Status</th> 
                            <th>Set Activation Status</th> 
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                  
                                    <td>
                                        <?php if (!empty($row['ProductImage'])): ?>
                                            <img src="../assets/dist/img/uploads/products/<?= $row['ProductImage'] ?>" class="img-square elevation-2" width="50">
                                        <?php else: ?>
                                            <img src="../assets/dist/img/default-image.png" class="img-square elevation-2" width="50">
                                        <?php endif; ?>
                                    </td> 
                                    <td><?= $row['ProductName'] ?></td> 
                                     <td><?= $row['MainCategoryName'] ?></td>
                                    <td><?= $row['CategoryName'] ?></td> 
                                     <td><?= $row['BrandName'] ?></td> 
                                    <td><?= $row['SupCompanyName'] ?></td> 
                                    <td><?= $row['PurchasePrice'] ?></td> 
                                    <td><?= $row['SellingPrice'] ?></td>
                                    <td>
                                        <?php
                                        // Displays the status of a brand with styled badges (Active/Deactive).
                                        $status = $row['PStatus'];
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
                                        // Show appropriate button based on the brand's status (Active/Inactive).
                                        $status = $row['PStatus'];
                                        if ($status == 1) {
                                            // Status is Active, show the 'Click to Deactivate' button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="ProductId" value="<?= $row['ProductId'] ?>">
                                                <input type="hidden" name="UpdateStatus" value="0">
                                                <button type="submit" name="action" value="update" class="btn btn-danger" style="width: 200px; height: 50px;">
                                                    Click to Deactivate
                                                </button>
                                            </form>
                                            <?php
                                        } elseif ($status == 0) {
                                            // Status is Deactive, show the 'Click to Activate' button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="ProductId" value="<?= $row['ProductId'] ?>">
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
                                        <a href="<?= SYS_URL ?>products/productView.php?productid=<?= $row['ProductId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>products/productEdit.php?productid=<?= $row['ProductId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
<!--                                        <a href="<?= SYS_URL ?>products/productDelete.php?productid=<?= $row['ProductId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>-->
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
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>

