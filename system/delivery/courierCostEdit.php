<?php
ob_start();
include_once '../init.php';

$link = "Courier Cost Management";
$breadcrumb_item = "Courier Cost";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') { //someone try to call as a request methos its a GET

    extract($_GET); // get data to edit.php file using manage.php file edit url. URl eka harahaa get method eken enne request eka
    $db = dbConn();
    $sql = "SELECT * FROM districts where Id=$ccid";

    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $district = $row['Name'];
    $courier_cost = $row['DeliveryCost'];
    $Id = $row['Id'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    
    
    $courier_cost = dataClean($courier_cost);

    $message = array();
    
    if (empty($courier_cost)) {
        $message['courier_cost'] = "Courier Cost is required.";
    }
   
    if (empty($message)) {

        $db = dbConn();
        $sql = "UPDATE districts SET DeliveryCost='$courier_cost' WHERE Id='$Id'";
        $db->query($sql);
        $Id = $db->insert_id;
        header("Location:courierCostManage.php");
    }
}
?>
<div class="row">
    <div class="col-12">

        <a href="<?= SYS_URL ?>delivery/courierCostManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Courier Cost Listing Table</a>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Courier Cost</h3>
            </div>              
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <div class="form-group">
                        <label for="district">District<span style = "color : red"> * </span></label>
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM  districts";
                        $result = $db->query($sql);
                        ?>
                        <select name="district" id="district"  class="form-control select2 mb-1" value="<?= @$district ?>" aria-label="Large select example" disabled>
                            <option value="" disabled selected>Select District</option>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                ?>
                               
                                 <option value="<?= $row['Id'] ?>" <?= @$Id == $row['Id'] ? 'selected' : '' ?>><?= $row['Name'] ?></option> 
                                <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= @$message['district'] ?></span>
                    </div> 
                               
                    <div class="form-group">
                        <label for="courier_cost">Courier Cost(LKR)<span style = "color : red"> * </span></label>
                        <input type="text" name="courier_cost" class="form-control mb-1" id="courier_cost" value="<?= @$courier_cost ?>" placeholder="Enter Purchase Price">
                        <span class="text-danger"><?= @$message['courier_cost'] ?></span>
                    </div>                                                          
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <input type="hidden" name="Id" value="<?= $Id ?>">
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