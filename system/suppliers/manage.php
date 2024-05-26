<?php
ob_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Supplier";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>suppliers/add.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Supplier</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Supplier Details Table</h3>
            </div>


            <div class="card-body">

                <?php
                $db = dbConn();
                $sql = "SELECT * FROM suppliers";
                $result = $db->query($sql);
                ?>
                <!--Table Start-->

                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Supplier ID</th>
                            <th>Supplier Company Name</th> 
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
                                    <td><?= $row['SupplierId'] ?></td>
                                    <td><?= $row['SupCompanyName'] ?></td> 
                                     <td><?= $row['Email'] ?></td> 
                                      <td><?= $row['ContPersonName'] ?></td> 
                                       <td><?= $row['ContactMobile'] ?></td> 
                                    <td>
                                        <a href="<?= SYS_URL ?>suppliers/view.php?brandid=<?= $row['SupplierId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>suppliers/edit.php?brandid=<?= $row['SupplierId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>suppliers/delete.php?brandid=<?= $row['SupplierId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
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