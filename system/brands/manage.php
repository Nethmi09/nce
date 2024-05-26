<?php
ob_start();
include_once '../init.php';

$link = "Brand Management";
$breadcrumb_item = "Brand";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>brands/add.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Brand</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Brand Details Table</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT BrandId,BrandImage,BrandName, m.MainCategoryName FROM brands b INNER JOIN main_categories m ON m.MainCategoryId=b.MainCategoryId";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Brand ID</th>
                            <th>Brand Image</th>
                            <th>Brand Name</th>  
                            <th>Main Category Name</th>  
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['BrandId'] ?></td>
                                    <td>
                                        <?php if (!empty($row['BrandImage'])): ?>
                                            <img src="../assets/dist/img/uploads/brands/<?= $row['BrandImage'] ?>" class="img-square elevation-2" width="50">
                                        <?php else: ?>
                                            <img src="../assets/dist/img/default-image.png" class="img-square elevation-2" width="50">
                                        <?php endif; ?>
                                    </td> 
                                    <td><?= $row['BrandName'] ?></td> 
                                    <td><?= $row['MainCategoryName'] ?></td> 
                                    <td>
                                        <a href="<?= SYS_URL ?>brands/view.php?brandid=<?= $row['BrandId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>brands/edit.php?brandid=<?= $row['BrandId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>brands/delete.php?brandid=<?= $row['BrandId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
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