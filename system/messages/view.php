<?php
ob_start();
include_once '../init.php';

$link = "Messages Management";
$breadcrumb_item = "Messages";
$breadcrumb_item_active = "View";

extract($_GET);

?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>messages/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Messages List</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Messages Details</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM contactus_messages WHERE contactus_messages.Id='$messageid'";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the message details
                    $message = $result->fetch_assoc();
                } else {
                    echo "Message not found.";
                    exit;
                }
                ?>

                <!-- Message Details Table Start -->
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <th style="width: 400px;">ID</th>
                            <td><?= $message['Id'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Name</th>
                            <td><?= $message['Name'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Email</th>
                            <td><?= $message['Email'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Message</th>
                            <td><?= $message['Message'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Submitted Date Time</th>
                            <td><?= $message['SubmittedAt'] ?></td>
                        </tr>

                    </tbody>
                </table>
                <!-- Message Details Table End -->
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
