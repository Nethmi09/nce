<?php
ob_start();
include_once '../init.php';

$link = "Color Management";
$breadcrumb_item = "Color";
$breadcrumb_item_active = "Manage";
?> 

<?php
// Extracts POST data and updates the status of a color if the action is 'update'.
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    extract($_POST);
    $db = dbConn();
    $sql = "UPDATE colors SET Status= '$UpdateStatus' WHERE ColorId='$ColorId'";

    $result = $db->query($sql);
}
?>

<div class="row">
    <div class="col-12">
         <a href="<?= SYS_URL ?>products/productManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Products Listing Table</a>
         <br>
        <a href="<?= SYS_URL ?>colors/add.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Color</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Colors Listing Table</h3>
            </div>

            <div class="card-body">
                <!-- Get color data from colors table -->
                <?php
                $db = dbConn();
                $sql = "SELECT ColorId, ColorName, ColorCode, Status FROM colors";
                $result = $db->query($sql);
                ?>

                <!-- Table Start -->
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Color ID</th>
                            <th>Color Name</th>
                            <th>Color Code</th>
                            <th>Status</th>
                            <th>Set Activation Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['ColorId'] ?></td>
                                    <td><?= $row['ColorName'] ?></td>
                                    <td>
                                        <!-- Display the color code as a colored box and its hex code -->
                                        <div style="background-color: <?= $row['ColorCode'] ?>; width: 50px; height: 20px; border: 1px solid #000;"></div>
                                        <?= $row['ColorCode'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        // Displays the status of a color with styled badges (Active/Deactive).
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
                                        // Show appropriate button based on the color's status (Active/Inactive).
                                              $status = $row['Status'];
                                        if ($status == 1) {
                                            // Status is Active, show the 'Click to Deactivate' button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="ColorId" value="<?= $row['ColorId'] ?>">
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
                                                <input type="hidden" name="ColorId" value="<?= $row['ColorId'] ?>">
                                                <input type="hidden" name="UpdateStatus" value="1">
                                                <button type="submit" name="action" value="update" class="btn btn-success" style="width: 200px; height: 50px;">
                                                    Click to Activate
                                                </button>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Table End -->

            </div>

        </div>

    </div>
</div>
<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
