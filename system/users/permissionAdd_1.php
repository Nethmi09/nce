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

                $message = array();

                // Required validation
                if (empty($user_name)) {
                    $message['user_name'] = "User Name is required...!";
                }
                if (empty($module)) {
                    $message['module'] = "Module Name is required...!";
                }

                if (empty($message)) {

                    $db = dbConn();
                    // Handle the sub_module; if it's empty, set it to NULL
                    $sub_module_value = empty($sub_module) ? "NULL" : "'$sub_module'";

                    // Corrected SQL query
                    $sql = "INSERT INTO user_modules (UserId, ModuleId, SubModuleId, `Add`, `View`, `Update`, `Delete`) 
                            VALUES ('$user_name', '$module', $sub_module_value, '$add', '$view', '$update', '$delete')";

                    if ($db->query($sql) === FALSE) {
                        echo "Error: " . $db->error;
                    } else {
                        $Id = $db->insert_id;
                        header("Location:permissionManage.php");
                        exit(); // Ensure script exits after redirection
                    }
                }
            }
            ?>

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!--User Name-->

                    <div class="row">
                        <div class="form-group col-md-8">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM users";
                            $result = $db->query($sql);
                            ?>
                            <label for="user_name">User Name<span style="color: red;"> * </span></label>
                            
                            <select name="user_name" id="user_name" class="form-control mb-1" aria-label="Large select example">
                                <option value="" disabled selected>Select User Name</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['UserId'] ?>"><?= $row['UserName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['user_name'] ?></span>

                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="module">Module</label>
                            <select name="module" id="module" onchange="loadSubModules()" class="form-control">
                                <option value="" disabled selected>Select Module</option>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT Id, Name FROM modules";
                                $result = $db->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['Id'] ?>" <?= @$module == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>  
                            <span class="text-danger"><?= @$message['module'] ?></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="sub_module">Sub Module</label>
                            <div id="submodule">
                                <select name="sub_module" id="sub_module" class="form-control">
                                    <option value="" disabled selected>Select Sub Module</option>                                       
                                </select> 
                            </div>
                            <span class="text-danger"><?= @$message['sub_module'] ?></span>  

                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="add">Add Permission</label>
                            <input type="hidden" name="add" value="0">
                            <input type="checkbox" id="add" name="add" value="1" <?= @$add == 1 ? 'checked' : '' ?>>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="view">View Permission</label>
                            <input type="hidden" name="view" value="0">
                            <input type="checkbox" id="view" name="view" value="1" <?= @$view == 1 ? 'checked' : '' ?>>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="update">Update Permission</label>
                            <input type="hidden" name="update" value="0">
                            <input type="checkbox" id="update" name="update" value="1" <?= @$update == 1 ? 'checked' : '' ?>>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="delete">Delete Permission</label>
                            <input type="hidden" name="delete" value="0">
                            <input type="checkbox" id="delete" name="delete" value="1" <?= @$delete == 1 ? 'checked' : '' ?>>
                        </div>
                    </div>

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
    $(document).ready(function () {
        loadSubModules('<?= @$sub_module ?>');
    });

    function loadSubModules(submodule) {
        var ModuleId = $('#module').val();
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
