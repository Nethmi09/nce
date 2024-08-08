<?php
ob_start();
include_once '../init.php';

$link = "Batch Number Management";
$breadcrumb_item = "Batch Number";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $batchNumber = dataClean($batchNumber);
    $description = dataClean($description);

    $message = array();

    //    Required validation

    if (empty($batchNumber)) {
        $message['batchNumber'] = "Batch Number is required.";
    }


    //    Advance validation

    if (!empty($batchNumber)) {
        $db = dbConn();
        $sql = "SELECT * FROM batch_numbers WHERE BatchNumber='$batchNumber'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['batchNumber'] = "This Batch Number already exsist!";
        }
    }


    if (empty($message)) {

        $db = dbConn();
        $sql = "INSERT INTO batch_numbers(BatchNumber,DescriptionBN,StatusBN) VALUES ('$batchNumber','$description','1')";
        $db->query($sql);
        $CategoryId = $db->insert_id;

        header("Location:manage.php");
    }
}
?> 

<div class="row">

    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>batchNumber/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Batch Numbers Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Batch Number</h3>
            </div>   

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!--Batch Number-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="batchNumber" class="form-label fw-bold">Batch Number<span style = "color: red"> * </span></label>
                            <input type="text" name="batchNumber" class="form-control mb-1" id="batchNumber" value="<?= @$batchNumber ?>" placeholder="Enter Batch Number" required>
                            <span class="text-danger"><?= @$message['batchNumber'] ?></span>
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
                      <a href="<?= SYS_URL ?>batchNumber/manage.php" class="btn btn-secondary">Cancel</a>
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