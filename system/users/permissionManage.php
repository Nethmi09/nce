<?php
ob_start();
include_once '../init.php';

$link = "Permission Management";
$breadcrumb_item = "Permission";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>users/permissionAdd.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New Permission</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Permissions Listing Table</h3>
            </div>
            <div class="card-body">

                <?php
                $db = dbConn();
                $sql = "SELECT u.Id, d.UserName, r.Role, CONCAT(d.FirstName, ' ', d.LastName) AS EmployeeName,m.Name as ModuleName, `Add`, `View`, `Update`, `Delete` 
                FROM user_modules u 
                INNER JOIN users d ON d.UserId = u.UserId 
                INNER JOIN user_role r ON r.Id = u.RoleId 
                INNER JOIN modules m ON m.Id = u.ModuleId";
                
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>User Name</th>  
                            <th>User Role</th> 
                            <th>Module Name</th>
                            <th>Add </th>
                            <th>View </th>
                            <th>Update </th>
                            <th>Delete </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                              $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['EmployeeName'] ?></td> 
                                    <td><?= $row['UserName'] ?></td> 
                                    <td><?= $row['Role'] ?></td> 
                                    <td><?= $row['ModuleName'] ?></td> 
                                    <td><?= $row['Add'] ?></td> 
                                    <td><?= $row['View'] ?></td> 
                                    <td><?= $row['Update'] ?></td> 
                                    <td><?= $row['Delete'] ?></td> 

                                    <td>
                                        
                                        <a href="<?= SYS_URL ?>users/permissionEdit.php?permissionid=<?= $row['Id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>users/permissionDelete.php?permissionid=<?= $row['Id'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>

                                <?php
                                $i++;
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