<?php
ob_start();
include_once '../init.php';

$link = "Permission Management";
$breadcrumb_item = "Permission";
$breadcrumb_item_active = "Add";
?>

<div class="row">
    <div class="col-12">

        <a href="<?= SYS_URL ?>users/permissionManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Permissions Listing Table</a>

        <!--Card Start-->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Permission</h3>
            </div>   

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                extract($_POST);
               
                //$role_name = dataClean($role_name);

                $message = array();

//    Required validation
                if (empty($role_name)) {
                    $message['role_name'] = "Role Name is required...!";
                }
                if (empty($module_id)) {
                    $message['module_id'] = "Module Name is required...!";
                }
                if (empty($add)) {
                    $message['add'] = "Add Permission is required...!";
                }
                if (empty($add)) {
                    $message['view'] = "View Permission is required...!";
                }
                if (empty($add)) {
                    $message['update'] = "Update Permission is required...!";
                }
                if (empty($add)) {
                    $message['delete'] = "Delete Permission is required...!";
                }
                
                if (empty($message)) {

                    $db = dbConn();
                    

                    header("Location:permissionManage.php");
                }
            }
            ?>

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!--Role Name-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  user_role";
                            $result = $db->query($sql);
                            ?>
                            <label for="role_name">Role Name<span style = "color : red;"> * </span></label>
                            <select name="role_name" id="role_name"  class="form-control mb-1" value="<?= @$role_name ?>" aria-label="Large select example">
                                <option value="" disabled selected >Select Role Name</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['Role'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['role_name'] ?></span>

                        </div>
                    </div>

                    <table  class="table table-bordered table-striped" id="modules">
                        <thead>
                            <tr>
                                <th>Module Name</th>
                                <th>Sub Module Name</th>
                                <th>Add</th>                                                  
                                <th>View</th> 
                                <th>Update</th> 
                                <th>Delete</th> 
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="module-row">
                                <td>
                                    <select name="module_id[]" id="module_id" onchange="loadSubModules()" value="<?= @$module_id ?>"class="form-control" >
                                        <option value="" disabled selected>Select Module</option>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT Id, Name FROM modules";
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>  
                                    <span class="text-danger"><?= @$message['module_id'] ?></span>
                                </td>
                                <td id="submodule">
                                    <select name="sub_module_id[]" id="sub_module_id" value="<?= @$sub_module_id ?>"class="form-control" >
                                        <option value="" disabled selected>Select Sub Module</option>                                       
                                    </select>  
                                    <span class="text-danger"><?= @$message['sub_module_id'] ?></span>
                                    
                                </td>
                                <td>
                                    <select name="add[]" id="add" class="form-control mb-1">
                                        <option value="" disabled selected>Select Permission</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span class="text-danger"><?= @$message['add'] ?></span>
                                </td>
                                <td>
                                    <select name="view[]" id="view" class="form-control mb-1">
                                        <option value="" disabled selected>Select Permission</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                      <span class="text-danger"><?= @$message['view'] ?></span>
                                </td>
                                <td>
                                    <select name="update[]" id="update" class="form-control mb-1">
                                        <option value="" disabled selected>Select Permission</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span class="text-danger"><?= @$message['update'] ?></span>
                                </td>
                                <td>
                                    <select name="delete[]" id="delete" class="form-control mb-1">
                                        <option value="" disabled selected>Select Permission</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <span class="text-danger"><?= @$message['delete'] ?></span>
                                </td>
                                <td>
                                    <button class="removeBtn" type="button" class="btn btn-primary">Remove</button>                                    
                                </td>

                            </tr>
                        </tbody>
                    </table>

                    <br>

                    <button type="button" id="addBtn" class="btn btn-info">Add More...</button>

                </div>

                <div class="card-footer">
                    <a href="<?= SYS_URL ?>users/permissionManage.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn submit">Submit</button>
                </div>

            </form>

            <!--Form End-->

        </div>
        <!--Card End-->
    </div>

</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>

<script>

//when document is ready ($ mean - load document with jquery)
    $(document).ready(function () {
        function addModules() {
            var tableBody = $('#modules tbody');
            var newRow = tableBody.find('.module-row').first().clone(true);

            // Clear input values in the cloned row
            newRow.find('input').val('');

            // Append the cloned row to the table body
            tableBody.append(newRow);
        }
        function removeModules(button) {
            var row = $(button).closest('tr');
            row.remove();
        }
        $('#addBtn').click(addModules);
        $('#modules').on('click', '.removeBtn', function () {
            removeModules(this);
        });
    });
    
    
    
    
    
    
    
    $(document).ready(function () {
        loadSubModules('<?= @$sub_module_id ?>');
    });


    function loadSubModules(submodule) {
        var ModuleId = $('#module_id').val();

        if (ModuleId) {

            $.ajax({
                url: 'get_sub_modules.php?ModuleId=' + ModuleId + '&selsubmodule=' + submodule,
                type: 'GET',
                success: function (data) {
                    $("#submodule").html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }


    }

</script>