<?php
ob_start();
include_once '../init.php';

$link = "Category Management";
$breadcrumb_item = "Category";
$breadcrumb_item_active = "Manage";
?> 

<?php
// Extracts POST data and updates the status of a category if the action is 'update'.
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    extract($_POST);
    $db = dbConn();
    $sql = "UPDATE categories SET Statuss= '$UpdateStatus' where CategoryId='$CategoryId'";

    $result = $db->query($sql);
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/categoryAdd.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Category</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Categories Listing Table</h3>
            </div>


            <div class="card-body">
                <!--Get category data form categories table-->
                <?php
                $db = dbConn();
                $sql = "SELECT CategoryId,CategoryName, m.MainCategoryName,Statuss FROM categories c "
                        . "INNER JOIN main_categories m ON m.MainCategoryId=c.MainCategoryId";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Category ID</th>
                            <th>Category Name</th>  
                            <th>Main Category Name</th>  
                            <th>Status</th> 
                            <th>Set Activation Status</th> 
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['CategoryId'] ?></td>
                                    <td><?= $row['CategoryName'] ?></td> 
                                    <td><?= $row['MainCategoryName'] ?></td> 
                                    <td>
                                        <?php
                                        // Displays the status of a category with styled badges (Active/Deactive).
                                        $status = $row['Statuss'];
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
                                        // Show appropriate button based on the category's status (Active/Inactive).
                                        $status = $row['Statuss'];
                                        if ($status == 1) {
                                            // Status is Active, show the 'Click to Deactivate' button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="CategoryId" value="<?= $row['CategoryId'] ?>">
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
                                                <input type="hidden" name="CategoryId" value="<?= $row['CategoryId'] ?>">
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
                                        <!--Display buttons for viewing, editing, and deleting a category-->
                                        <!-- Link to view,edit,delete the details of a specific category based on its ID -->
                                        <!-- 'categoryid' parameter in the URL is used to specify the unique ID of the category for viewing,editing and deleting its details -->
                                        <a href="<?= SYS_URL ?>products/categoryView.php?categoryid=<?= $row['CategoryId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>products/categoryEdit.php?categoryid=<?= $row['CategoryId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <!-- Calls the confirmDelete() function to confirm the deletion of a category when the button is clicked -->
                                        <a href="<?= SYS_URL ?>products/categoryDelete.php?categoryid=<?= $row['CategoryId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
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
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>