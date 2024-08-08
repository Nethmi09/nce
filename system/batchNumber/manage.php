<?php
ob_start();
include_once '../init.php';

$link = "Batch Number Management";
$breadcrumb_item = "Batch Number";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>batchNumber/add.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Batch Number</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Batch Numbers Listing Table</h3>
            </div>


            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM batch_numbers";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Batch Number ID</th>
                            <th>Batch Number</th> 
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
                                    <td><?= $row['BatchNumberId'] ?></td>
                                    <td><?= $row['BatchNumber'] ?></td> 
                                        <td><?= $row['DescriptionBN'] ?></td> 
                                    <td>
                                        <a href="<?= SYS_URL ?>batchNumber/edit.php?batchnumberid=<?= $row['BatchNumberId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>batchNumber/delete.php?batchnumberid=<?= $row['BatchNumberId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
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