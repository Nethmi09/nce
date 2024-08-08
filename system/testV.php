<!--Deactivate admin user-->

<td>
    <?php
    $status = $row['Status'];
    $isAdmin = $row['UserType'] == 'admin'; // Check if the user is an admin

    if ($status == 1) {
        // Status is active, so show deactivate button
        if ($isAdmin) {
            // If admin, show disabled button and message
            ?>
            <button type="button" class="btn btn-danger" style="width: 200px; height: 50px; cursor: not-allowed;" disabled>
                Click to Deactivate
            </button>
            <div><small class="text-muted">Cannot deactivate admin user</small></div>
            <?php
        } else {
            // If not admin, show active/deactivate button
            ?>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <input type="hidden" name="UserId" value="<?= htmlspecialchars($row['UserId']) ?>">
                <input type="hidden" name="UpdateStatus" value="0">
                <button type="submit" name="action" value="update" class="btn btn-danger" style="width: 200px; height: 50px;">
                    Click to Deactivate
                </button>
            </form>
            <?php
        }
    } elseif ($status == 0) {
        // Status is inactive, so show activate button
        ?>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="hidden" name="UserId" value="<?= htmlspecialchars($row['UserId']) ?>">
            <input type="hidden" name="UpdateStatus" value="1">
            <button type="submit" name="action" value="update" class="btn btn-success" style="width: 200px; height: 50px;">
                Click to Activate
            </button>
        </form>
        <?php
    }
    ?>
</td>
<!--End Deactivate admin user-->

<?php
$userid = $_SESSION['USERID'];

$db = dbConn();
$sql = "SELECT * FROM  user_modules um INNER JOIN modules m ON m.Id=um.ModuleId WHERE um.UserId='$userid' AND m.Status='1' ORDER BY Idx ASC";
$result = $db->query($sql);
$current_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url_without_file = preg_replace('/\/[^\/]*$/', '', $current_url);
?>
