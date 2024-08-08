<?php
ob_start();
include_once '../init.php';

$link = "Serial Number Management";
$breadcrumb_item = "Serial Number";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $serialNumber = dataClean($serialNumber);
    $description = dataClean($description);

    $message = array();

    //    Required validation

    if (empty($serialNumber)) {
        $message['serialNumber'] = "Serial Number is required.";
    }


    //    Advance validation

    if (!empty($category_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM serial_numbers WHERE SerialNumber='$serialNumber'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['serialNumber'] = "This Serial Number already exsist!";
        }
    }


    if (empty($message)) {

        $db = dbConn();
        $sql = "INSERT INTO serial_numbers(SerialNumber,DescriptionSN,StatusSN) VALUES ('$serialNumber','$description','1')";
        $db->query($sql);
        $CategoryId = $db->insert_id;

        header("Location:manage.php");
    }
}
?> 

<div class="row">

    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>serialNumber/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Serial Numbers Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Serial Number</h3>
            </div>   

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!--Serial Number-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="serialNumber" class="form-label fw-bold">Serial Number<span style = "color: red"> * </span></label>
                            <input type="text" name="serialNumber" class="form-control mb-1" id="serialNumber" value="<?= @$serialNumber ?>" placeholder="Enter Serial Number" required>
                            <span class="text-danger"><?= @$message['serialNumber'] ?></span>
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
                   <a href="<?= SYS_URL ?>serialNumber/manage.php" class="btn btn-secondary">Cancel</a>
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