<?php
ob_start();
include_once '../init.php';

$link = "Brand Management";
$breadcrumb_item = "Brand";
$breadcrumb_item_active = "Manage";
?> 
<?php
// Extracts POST data and updates the status of a brand if the action is 'update'.
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    extract($_POST);
    $db = dbConn();
    $sql = "UPDATE brands SET BStatus= '$UpdateStatus' where BrandId='$BrandId'";

    $result = $db->query($sql);
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/brandAdd.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Brand</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Brands Listing Table</h3>
            </div>

            <div class="card-body">
                <!--Get brands data form brands table-->
                <?php
                $db = dbConn();
                $sql = "SELECT BrandId,BrandImage,BrandName, m.MainCategoryName,BStatus FROM brands b INNER JOIN main_categories m ON m.MainCategoryId=b.MainCategoryId";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Brand Image</th>
                            <th>Brand Name</th>  
                            <th>Main Category Name</th> 
                             <th>Status</th> 
                            <th>Set Activation Status</th> 
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                                $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                  <td><?= $i ?></td>
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
                                        <?php
                                        // Displays the status of a brand with styled badges (Active/Deactive).
                                        $status = $row['BStatus'];
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
                                        $status = $row['BStatus'];
                                        if ($status == 1) {
                                            // Status is Active, show the 'Click to Deactivate' button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="BrandId" value="<?= $row['BrandId'] ?>">
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
                                                <input type="hidden" name="BrandId" value="<?= $row['BrandId'] ?>">
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
                                        <!--Display buttons for viewing, editing, and deleting a brand-->
                                        <!-- Link to view,edit,delete the details of a specific brand based on its ID -->
                                        <!-- 'brandid' parameter in the URL is used to specify the unique ID of the brand for viewing,editing and deleting its details -->
                                        <a href="<?= SYS_URL ?>products/brandView.php?brandid=<?= $row['BrandId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>products/brandEdit.php?brandid=<?= $row['BrandId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                         <!-- Calls the confirmDelete() function to confirm the deletion of a brand when the button is clicked -->
<!--                                        <a href="<?= SYS_URL ?>products/brandDelete.php?brandid=<?= $row['BrandId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>-->
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