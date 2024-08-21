<?php
ob_start();
include_once '../init.php';

$link = "Role Management";
$breadcrumb_item = "Role";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to fetch role details based on the roleid from the URL
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT * FROM user_role WHERE Id='$roleid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // Assign fetched role details to variables
    $role_name = $row['Role'];
    $description = $row['Description'];
    $Id = $row['Id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle POST request to update role details
    extract($_POST);
    // Clean input data
      $role_name = dataClean($role_name);
    $description = dataClean($description);

    //Initialize an array to hold error messages
    $message = array();

    //Required Validations
    if (empty($role_name)) {
        $message['role_name'] = "Role Name is required.";
    }

    
//Advance Validations
    // Check for unique role name excluding the current role
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
        $sql = "UPDATE user_role SET Role='$role_name', Description='$description' WHERE Id='$Id'";
        $db->query($sql);
        header("Location: roleManage.php");
        exit();
    }
}
?>

<div class="row">
   
    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>users/roleManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Roles Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Role</h3>
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
                         <textarea class="form-control mb-1" name="description" id="description" rows="3" placeholder="Enter Description"><?= @$description ?></textarea>


                        </div>                      
                    </div>


                </div>


                <div class="card-footer">
                     <!-- Hidden input field to pass the CategoryId with the form submission -->
                    <input type="hidden" name="Id" value="<?= $Id ?>">
                    <button type="submit" class="btn btn-primary">Update</button>
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
