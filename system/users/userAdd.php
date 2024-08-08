<?php
ob_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $user_name = dataClean($user_name);
     $role_name = dataClean($role_name);

    $message = array();

    //Required validations-----------------------------------------------

    if (empty($employee_id)) {
        $message['employee_id'] = "Employee Name is required.";
    }

    if (empty($user_name)) {
        $message['user_name'] = "User Name is required.";
    }

    if (empty($role_name)) {
        $message['role_name'] = "Role Name is required.";
    }

    if (empty($Password)) {
        $message['Password'] = "Password is required.";
    }

    if (empty($confirm_password)) {
        $message['confirm_password'] = "Confirm Password is required...!";
    }

    //Advance validations------------------------------------------------
    // User Name validation(User name already exist or not)-------------

    if (!empty($user_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM users WHERE UserName='$user_name'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['user_name'] = "This User Name already exsist!";
        }
    }

    //Password Validation(password stength)------------------------------------------------

    if (!empty($Password)) {
        $uppercase = preg_match('@[A-Z]@', $Password);
        $lowercase = preg_match('@[a-z]@', $Password);
        $number = preg_match('@[0-9]@', $Password);
        $specialChars = preg_match('@[^\w]@', $Password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($Password) < 8) {
            $message['Password'] = 'Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.';
        }
    }

    //Confirm Password Validation(confirm password stength)--------------------------------

    if (!empty($confirm_password)) {
        $uppercase = preg_match('@[A-Z]@', $confirm_password);
        $lowercase = preg_match('@[a-z]@', $confirm_password);
        $number = preg_match('@[0-9]@', $confirm_password);
        $specialChars = preg_match('@[^\w]@', $confirm_password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($confirm_password) < 8) {
            $message['confirm_password'] = 'Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.';
        }
    }


    if (empty($message)) {
        // Fetch employee details
        $db = dbConn();
        $sql = "SELECT FirstName, LastName FROM employees WHERE EmployeeId='$employee_id'";
        $result = $db->query($sql);
        $employee = $result->fetch_assoc();
        $first_name = $employee['FirstName'];
        $last_name = $employee['LastName'];

        // Use bcrypt hashing algorithm
        $pw = password_hash($Password, PASSWORD_DEFAULT);
        $conpw = password_hash($confirm_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (FirstName, LastName, UserName, UserRoleId,Password, ConfirmPassword, UserType, Status) "
                . "VALUES ('$first_name', '$last_name', '$user_name','$role_name', '$pw','$conpw', 'employee', '1')";
        $db->query($sql);
        $UserId = $db->insert_id;

        header("Location: userManage.php");
    }
}
?> 

<div class="row">

    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>users/userManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Users Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New User</h3>
            </div>   

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!--Employee Name-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  employees WHERE EmployeeStatusId='1'";
                            $result = $db->query($sql);
                            ?>
                            <label for="employee_id">Employee Name<span style = "color : red;"> * </span></label>
                            <select name="employee_id" id="employee_id"  class="form-control select2 mb-1" value="<?= @$employee_id ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select Employee Name</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['EmployeeId'] ?>"><?= $row['FirstName'] . ' ' . $row['LastName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['employee_id'] ?></span>

                        </div>
                    </div>

                    <!--User Name-->

                    <div class="form-group">
                        <label for="user_name">User Name<span style = "color : red;"> * </span></label>
                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?= @$user_name ?>" placeholder="Enter User Name">
                        <span class="text-danger"><?= @$message['user_name'] ?></span>
                    </div>

                    <!--User Role-->

                     <div class="row">
                        <div class="form-group col-md-12">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  user_role";
                            $result = $db->query($sql);
                            ?>
                            <label for="role_name">Role Name<span style = "color : red;"> * </span></label>
                            <select name="role_name" id="role_name"  class="form-control mb-1" value="<?= @$role_name ?>" aria-label="Large select example" required>
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


                    <div class="form-group">
                        <label for="Password">Password<span style = "color : red;"> * </span></label>
                        <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
                        <span class="text-danger"><?= @$message['Password'] ?></span>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password<span style = "color : red;"> * </span></label>
                        <input type="password" name="confirm_password" class="form-control border border-1 mb-4" id="confirm_password" value="<?= @$confirm_password ?>" placeholder="Enter Confirm Password" required>
                        <span class="text-danger"><?= @$message['confirm_password'] ?></span>
                    </div>

                </div>


                <div class="card-footer">
                    <a href="<?= SYS_URL ?>users/userManage.php" class="btn btn-secondary">Cancel</a>
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