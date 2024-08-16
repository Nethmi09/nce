<?php
ob_start();
include_once '../init.php'; // Include initialization script for database connection and other settings

$link = "Product Management";
$breadcrumb_item = "Product";
$breadcrumb_item_active = "View";

// Extract Product ID from the GET request
extract($_GET);

?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/productManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Products Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Products Details</h3>
            </div>

            <div class="card-body">
                <?php
                 // Establish database connection
                $db = dbConn();
                 // Query to retrieve product details including main category name
                   $sql = "SELECT ProductId,ProductImage,ProductName, m.MainCategoryName, b.BrandName, c.CategoryName, s.SupCompanyName, PurchasePrice, SellingPrice,PDescription, Quantity FROM products p "
                         . "INNER JOIN main_categories m ON m.MainCategoryId=p.MainCategoryId "
                        . "INNER JOIN brands b ON b.BrandID=p.BrandID "
                        . "INNER JOIN categories c ON c.CategoryId=p.CategoryId "
                        . "INNER JOIN suppliers s ON s.SupplierId=p.SupplierId WHERE p.ProductId='$productid'";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the product details
                    $product = $result->fetch_assoc();
                } else {
                    echo "Product not found.";
                    exit;
                }
                ?>

                <!-- Product Details Table Start -->
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <th style="width: 400px;">Product ID</th>
                            <td><?= $product['ProductId'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Product Image</th>
                            <td>
                                <?php if (!empty($product['ProductImage'])): ?>
                                    <img src="../assets/dist/img/uploads/products/<?= $product['ProductImage'] ?>" class="img-square elevation-2" width="100">
                                <?php else: ?>
                                    <img src="../assets/dist/img/default-image.png" class="img-square elevation-2" width="100">
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Product Name</th>
                            <td><?= $product['ProductName'] ?></td>
                        </tr>
                        
                        <tr>
                            <th style="width: 400px;">Main Category Name</th>
                            <td><?= $product['MainCategoryName'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Category Name</th>
                            <td><?= $product['CategoryName'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Brand Name</th>
                            <td><?= $product['BrandName'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Supplier Name</th>
                            <td><?= $product['SupCompanyName'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Purchase Price</th>
                            <td><?= $product['PurchasePrice'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Selling Price</th>
                            <td><?= $product['SellingPrice'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Description</th>
                            <td><?= $product['PDescription'] ?></td>
                        </tr>
                        </tr>

                    </tbody>
                </table>
                <!-- Product Details Table End -->
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
