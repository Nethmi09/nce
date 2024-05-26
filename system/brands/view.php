<?php
ob_start();
include_once '../init.php';

$link = "Brand Management";
$breadcrumb_item = "Brand";
$breadcrumb_item_active = "View";
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>brands/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Brand List</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Brand Details</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT BrandId,BrandImage,BrandName,Description, m.MainCategoryName FROM brands b INNER JOIN main_categories m ON m.MainCategoryId=b.MainCategoryId";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the brand details
                    $brand = $result->fetch_assoc();
                } else {
                    echo "Brand not found.";
                    exit;
                }
                ?>

                <!-- Brand Details Table Start -->
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <th style="width: 400px;">Brand ID</th>
                            <td><?= $brand['BrandId'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Brand Image</th>
                            <td>
                                <?php if (!empty($brand['BrandImage'])): ?>
                                    <img src="../assets/dist/img/uploads/brands/<?= $brand['BrandImage'] ?>" class="img-square elevation-2" width="100">
                                <?php else: ?>
                                    <img src="../assets/dist/img/default-image.png" class="img-square elevation-2" width="100">
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Brand Name</th>
                            <td><?= $brand['BrandName'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Description</th>
                            <td><?= $brand['Description'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Main Category Name</th>
                            <td><?= $brand['MainCategoryName'] ?></td>
                        </tr>

                    </tbody>
                </table>
                <!-- Brand Details Table End -->
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../layouts.php';
?>
