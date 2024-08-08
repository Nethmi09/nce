<?php
ob_start();
include_once '../init.php';

$link = "Warranty Management";
$breadcrumb_item = "Warranty";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>warranty/add.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Warranty</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Warranty Listing Table</h3>
            </div>


            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM warranty";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Warranty ID</th>
                            <th>Warranty</th> 
                            <th>Description</th> 
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['WarrantyId'] ?></td>
                                    <td><?= $row['Warranty'] ?></td> 
                                        <td><?= $row['WDescription'] ?></td> 
                                    <td>
                                        <a href="<?= SYS_URL ?>warranty/edit.php?warrantyid=<?= $row['WarrantyId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>warranty/delete.php?warrantyid=<?= $row['WarrantyId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
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