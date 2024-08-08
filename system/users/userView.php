<?php
ob_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "View";

//Get the url returns id(userid)
extract($_GET);
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>users/userManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Users Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Details</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                //userid mean get retaled data for each customer
                $sql = "SELECT u.UserId, u.FirstName, u.LastName, u.UserName, u.UserType, u.Status, r.Role 
                        FROM users u 
                        LEFT JOIN user_role r ON r.Id = u.UserRoleId WHERE u.UserId='$userid'";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the user details
                    $user = $result->fetch_assoc();
                } else {
                    echo "User not found.";
                    exit;
                }
                ?>

                <!-- User Details Table Start -->
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <th style="width: 400px;">User ID</th>
                            <td><?= $user['UserId'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Employee Name</th>
                            <td><?= $user['FirstName'] . ' ' . $user['LastName'] ?></td>                                
                        </tr>
                        <tr>
                            <th style="width: 400px;">User Name</th>
                            <td><?= $user['UserName'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Role Name</th>
                            <td><?= $user['Role'] ?></td>
                        </tr>
                        
                    </tbody>
                </table>
                <!-- User Details Table End -->
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
