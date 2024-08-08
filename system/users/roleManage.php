<?php
ob_start();
include_once '../init.php';

$link = "Role Management";
$breadcrumb_item = "Role";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>users/roleAdd.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Role</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Role Details Table</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM user_role";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Role ID</th>
                            <th>Role Name</th> 
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
                                    <td><?= $row['Id'] ?></td> 
                                    <td><?= $row['Role'] ?></td> 
                                      <td><?= $row['Description'] ?></td> 
                                    <td>
                                         <a href="<?= SYS_URL ?>users/roleEdit.php?roleid=<?= $row['Id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>users/roleDelete.php?roleid=<?= $row['Id'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
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