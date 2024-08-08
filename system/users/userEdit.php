<?php
ob_start();
include_once '../init.php';
$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') { // someone tries to call as a request method it's a GET

    // get data to edit.php file using manage.php file edit URL
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT u.UserId, u.FirstName, u.LastName, u.UserName, r.Role, u.UserRoleId FROM users u 
            LEFT JOIN user_role r ON r.Id = u.UserRoleId WHERE u.UserId='$userid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $employee_id = $row['FirstName'] . ' ' . $row['LastName'];
    $user_name = $row['UserName'];
    $role_name = $row['Role'];
    $UserId = $row['UserId'];
    $UserRoleId = $row['UserRoleId'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $role_name = dataClean($role_name);
    $message = array();

    if (empty($role_name)) {
        $message['role_name'] = "Role Name is required.";
    }
    if (empty($message)) {
        $db = dbConn();
        $sql = "UPDATE users SET UserRoleId='$role_name' WHERE UserId='$UserId'";
        $db->query($sql);
        header("Location: userManage.php");
        exit();
    }
}
?>

<div class="row">
    <div class="col-12">

        <a href="<?= SYS_URL ?>users/userManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Users Listing Table</a>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update User</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!-- Employee Name -->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM employees";
                            $result = $db->query($sql);
                            ?>
                            <label for="employee_id">Employee Name<span style="color: red;"> * </span></label>
                            <select name="employee_id" id="employee_id" class="form-control select2 mb-1" aria-label="Large select example" disabled>
                                <option value="" disabled selected>Select Employee Name</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['EmployeeId'] ?>" <?= @$employee_id == $row['FirstName'] . ' ' . $row['LastName'] ? 'selected' : '' ?>><?= $row['FirstName'] . ' ' . $row['LastName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['employee_id'] ?></span>
                        </div>
                    </div>

                    <!-- User Name -->
                    <div class="form-group">
                        <label for="user_name">User Name<span style="color: red;"> * </span></label>
                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?= @$user_name ?>" placeholder="Enter User Name" disabled>
                        <span class="text-danger"><?= @$message['user_name'] ?></span>
                    </div>

                    <!-- User Role -->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM user_role";
                            $result = $db->query($sql);
                            ?>
                            <label for="role_name">Role Name<span style="color: red;"> * </span></label>
                            <select name="role_name" id="role_name" class="form-control mb-1" aria-label="Large select example" required>
                                <option value="" disabled selected>Select Role Name</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>" <?= @$UserRoleId == $row['Id'] ? 'selected' : '' ?>><?= $row['Role'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['role_name'] ?></span>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <input type="hidden" name="UserId" value="<?= $UserId ?>">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
        <!-- /.card -->
    </div>
</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
