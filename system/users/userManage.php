<?php
ob_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Manage";

extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'update') {
    $db = dbConn();

    // Check if the user trying to deactivate is an admin (UserRoleId = 1)
    $sql = "SELECT UserRoleId FROM users WHERE UserId='$UserId'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    if ($row['UserRoleId'] != 1) {
        // Proceed with the update if the user is not an admin
        $sql = "UPDATE users SET Status= '$UpdateStatus' WHERE UserId='$UserId'";
        $db->query($sql);
    } else {
        // Admin user, do not deactivate
        echo "<script>alert('Admin user cannot be deactivated.');</script>";
    }
}
?>

<div class="row">
    <div class="col-12">
        <?php
        $privilege = checkprivilege(1);
        ?>
        <a href="<?= SYS_URL ?>users/userAdd.php" class="btn btn-dark mb-4 <?= $privilege['Add'] == '0' ? 'disabled' : '' ?>">
            <i class="fas fa-plus-circle"></i> Add New User
        </a>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">User Details Table</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT u.UserId, u.FirstName, u.LastName, u.UserName, u.UserRoleId, u.UserType, u.Status, r.Role 
                        FROM users u 
                        LEFT JOIN user_role r ON r.Id = u.UserRoleId 
                        WHERE u.UserRoleId IN (1, 2, 3, 4)";
                $result = $db->query($sql);
                ?>
                <!--Table Start--> 
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>User Name</th>
                            <th>Role Name</th>
                            <th>Status</th>
                            <th>Set Activation Status</th>
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
                                    <td><?= htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']) ?></td>
                                    <td><?= htmlspecialchars($row['UserName']) ?></td>
                                    <td><?= htmlspecialchars($row['Role']) ?></td>
                                    <td>
                                        <?php
                                        $status = $row['Status'];
                                        if ($status == 1) {
                                            ?>
                                            <h5><span class="badge badge-pill" style="background-color: green; color: white; padding: 10px 20px; border-radius: 25px; display: inline-block; text-align: center;">
                                                    Active
                                                </span></h5>
                                        <?php } elseif ($status == 0) { ?>
                                            <h5><span class="badge badge-pill" style="background-color: red; color: white; padding: 10px 20px; border-radius: 25px; display: inline-block; text-align: center;">
                                                    Deactive
                                                </span></h5>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php
                                        $status = $row['Status'];
                                        if ($status == 1) {
                                            if ($row['UserRoleId'] == 1) {
                                                // If the user is an admin (UserRoleId = 1), disable the deactivate button
                                                ?>
                                                <button type="button" class="btn btn-danger" style="width: 200px; height: 50px;" disabled>
                                                    Click to Deactivate
                                                </button>
                                                <?php
                                            } else {
                                                // For non-admin users, display the deactivate button
                                                ?>
                                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                    <input type="hidden" name="UserId" value="<?= $row['UserId'] ?>">
                                                    <input type="hidden" name="UpdateStatus" value="0">
                                                    <button type="submit" name="action" value="update" class="btn btn-danger" style="width: 200px; height: 50px;">
                                                        Click to Deactivate
                                                    </button>
                                                </form>
                                                <?php
                                            }
                                        } elseif ($status == 0) {
                                            // Status is inactive, show the activate button
                                            ?>
                                            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                                <input type="hidden" name="UserId" value="<?= $row['UserId'] ?>">
                                                <input type="hidden" name="UpdateStatus" value="1">
                                                <button type="submit" name="action" value="update" class="btn btn-success" style="width: 200px; height: 50px;">
                                                    Click to Activate
                                                </button>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <a href="<?= SYS_URL ?>users/userView.php?userid=<?= htmlspecialchars($row['UserId']) ?>" class="btn btn-info <?= $privilege['View'] == '0' ? 'disabled' : '' ?>"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>users/userEdit.php?userid=<?= htmlspecialchars($row['UserId']) ?>" class="btn btn-warning <?= $privilege['Update'] == '0' ? 'disabled' : '' ?>"><i class="fas fa-edit"></i></a>
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
