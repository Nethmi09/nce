<?php
ob_start();

include_once '../init.php'; //init.php file->Get sys url

$link = "Courier Cost Management";
$breadcrumb_item = "Courier Cost";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Courier Cost Listing Table</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM districts";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>District Name</th>
                            <th>Courier Cost</th>  
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['Id'] ?></td> 
                                    <td><?= $row['Name'] ?></td> 
                                    <td><?= $row['DeliveryCost'] ?></td> 
                                    <td>  
                                        <!-- Edit specific record   -->
                                        <a href="<?= SYS_URL ?>delivery/courierCostEdit.php?ccid=<?= $row['Id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
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