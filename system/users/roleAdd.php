<?php
ob_start();
include_once '../init.php';

$link = "Role Management";
$breadcrumb_item = "Role";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $role_name = dataClean($role_name);
    $description = dataClean($description);

    $message = array();

    //    Required validation

    if (empty($role_name)) {
        $message['role_name'] = "Role Name is required.";
    }


    //    Advance validation

    if (!empty($role_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM user_role WHERE Role='$role_name'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['role_name'] = "This Role Name already exsist!";
        }
    }


    if (empty($message)) {

        $db = dbConn();
        $sql = "INSERT INTO user_role(Role,Description,Status) VALUES ('$role_name','$description','1')";
        $db->query($sql);
        $BrandId = $db->insert_id;

        header("Location:roleManage.php");
        
    }
}
?> 

<div class="row">
   
    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>users/roleManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Roles Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Role</h3>
            </div>         

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <!--Role Name-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="role_name" class="form-label fw-bold">Role Name<span style = "color: red"> * </span></label>
                            <input type="text" name="role_name" class="form-control mb-1" id="role_name" value="<?= @$role_name ?>" placeholder="Enter Role Name">
                            <span class="text-danger"><?= @$message['role_name'] ?></span>
                        </div>                      
                    </div>

                    <!--Description-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control mb-1" type="text" name="description" id="description" rows="3" value="<?= @$description ?>"  placeholder="Enter Description"></textarea>
                        </div>                      
                    </div>


                </div>


                <div class="card-footer">
                  <a href="<?= SYS_URL ?>users/roleManage.php" class="btn btn-secondary">Cancel</a>
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