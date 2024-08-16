<?php
ob_start();
include_once '../init.php';

$link = "Courier Service Management";
$breadcrumb_item = "Courier Service";
$breadcrumb_item_active = "Manage";
?> 

<?php
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    extract($_POST);
    $db = dbConn();
    $sql = "UPDATE courier_service SET Status= '$UpdateStatus' where CourierServiceId='$CourierServiceId'";

    $result = $db->query($sql);
}
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>delivery/courierProfileAdd.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Courier Service</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Courier Services Listing Table</h3>
            </div>


            <div class="card-body">

                <?php
                $db = dbConn();
                $sql = "SELECT * FROM courier_service";
                $result = $db->query($sql);
                ?>
                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Courier Service ID</th>
                            <th>Courier Service Company Name</th> 
                            <th>Email</th> 
                            <th>Contact Person Name</th>  
                            <th>Contact Mobile</th> 
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
                                    <td><?= $row['CourierServiceId'] ?></td>
                                    <td><?= $row['CouCompanyName'] ?></td> 
                                     <td><?= $row['Email'] ?></td> 
                                      <td><?= $row['ContPersonName'] ?></td> 
                                       <td><?= $row['ContactMobile'] ?></td> 
                                       <td>
                                        <?php
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
                                        $status = $row['Status'];
                                        if ($status == 1) {
                                            // Status is active, so show deactivate button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="CourierServiceId" value="<?= $row['CourierServiceId'] ?>">
                                                <input type="hidden" name="UpdateStatus" value="0">
                                                <button type="submit" name="action" value="update" class="btn btn-danger" style="width: 200px; height: 50px;">
                                                    Click to Deactivate
                                                </button>
                                            </form>
                                            <?php
                                        } elseif ($status == 0) {
                                            // Status is inactive, so show activate button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="CourierServiceId" value="<?= $row['CourierServiceId'] ?>">
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
                                        <a href="<?= SYS_URL ?>delivery/courierProfileView.php?courierProfileId=<?= $row['CourierServiceId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>delivery/courierProfileEdit.php?courierProfileId=<?= $row['CourierServiceId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
<!--                                        <a href="<?= SYS_URL ?>delivery/courierProfileDelete.php?courierProfileId=<?= $row['CourierServiceId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>-->
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