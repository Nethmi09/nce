<?php
ob_start();
include_once '../init.php';

$link = "Courier Service Management";
$breadcrumb_item = "Courier Service";
$breadcrumb_item_active = "Manage";
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
                                        <a href="<?= SYS_URL ?>delivery/courierProfileView.php?courierProfileId=<?= $row['CourierServiceId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>delivery/courierProfileEdit.php?courierProfileId=<?= $row['CourierServiceId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>delivery/courierProfileDelete.php?courierProfileId=<?= $row['CourierServiceId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
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