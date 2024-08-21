<?php
ob_start();
include_once '../init.php';

$link = "Coupon Management";
$breadcrumb_item = "Coupon";
$breadcrumb_item_active = "Manage";
?>

<?php
// Extracts POST data and updates the status of a coupon if the action is 'update'.
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    extract($_POST);
    $db = dbConn();
    $sql = "UPDATE coupons SET Status = '$UpdateStatus' WHERE CouponId='$CouponId'";

    $result = $db->query($sql);
}
?>

<div class="row">
    <div class="col-12">
         <a href="<?= SYS_URL ?>products/productManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Products Listing Table</a>
         <br>
        <a href="<?= SYS_URL ?>coupons/add.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Coupon</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Coupons Listing Table</h3>
            </div>

            <div class="card-body">
                <!--Get coupon data from coupons table-->
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM coupons";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Coupon ID</th>
                            <th>Coupon Number</th>  
                            <th>Discount</th>  
                            <th>Order Count</th>                           
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
                                    <td><?= $row['CouponId'] ?></td>
                                    <td><?= $row['CouponNumber'] ?></td> 
                                    <td><?= $row['Discount'] ?></td>
                                    <td><?= $row['order_count'] ?></td>
                                    <td>
                                        <?php
                                        // Displays the status of a coupon with styled badges (Active/Inactive).
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
                                        // Show appropriate button based on the coupon's status (Active/Inactive).
                                        $status = $row['Status'];
                                        if ($status == 1) {
                                            // Status is Active, show the 'Click to Deactivate' button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="CouponId" value="<?= $row['CouponId'] ?>">
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
                                                <input type="hidden" name="CouponId" value="<?= $row['CouponId'] ?>">
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
                                        <!--Display buttons for viewing, editing, and deleting a coupon-->
                                        <!-- Link to view, edit, delete the details of a specific coupon based on its ID -->
                                        <!-- 'CouponId' parameter in the URL is used to specify the unique ID of the coupon for editing, and deleting its details -->
                                       
                                        <a href="<?= SYS_URL ?>coupons/edit.php?couponid=<?= $row['CouponId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <!-- Calls the confirmDelete() function to confirm the deletion of a coupon when the button is clicked -->
<!--                                        <a href="<?= SYS_URL ?>coupons/delete.php?couponid=<?= $row['CouponId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>-->
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
