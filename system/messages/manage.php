<?php
ob_start();
include_once '../init.php';

$link = "Messages Management";
$breadcrumb_item = "Messages";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Messages Details Table</h3>
            </div>

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM contactus_messages ";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>  
                            <th>Submitted Date Time</th>  
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['Id'] ?></td> 
                                    <td><?= $row['Name'] ?></td> 
                                      <td><?= $row['Email'] ?></td> 
                                    <td><?= $row['Message'] ?></td> 
                                      <td><?= $row['SubmittedAt'] ?></td> 
                                    <td>
                                        <a href="<?= SYS_URL ?>messages/view.php?messageid=<?= $row['Id'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>messages/delete.php?messageid=<?= $row['Id'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>

                                <?php
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