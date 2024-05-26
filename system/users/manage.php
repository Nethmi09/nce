<?php
ob_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>users/add.php" class="btn btn-dark mb-4"><i class="fas fa-plus-circle"></i> Add New User</a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">User Details Table</h3>
            </div>

            <div class="card-body">
                
                <!--Table Start--> 
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee Name</th>
                            <th>User Name</th>
                            <th>Designation</th>                       
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       
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