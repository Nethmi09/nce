<?php
ob_start();
include_once '../init.php';

$link = "Color Management";
$breadcrumb_item = "Color";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $color_name = dataClean($color_name);
    $color_code = dataClean($color_code);

    $message = array();

    // Required validation
    if (empty($color_name)) {
        $message['color_name'] = "Color Name is required.";
    }

    if (empty($color_code)) {
        $message['color_code'] = "Color Code is required.";
    }

    // Advanced validation
    if (!empty($color_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM colors WHERE ColorName='$color_name'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['color_name'] = "This Color Name already exists!";
        }
    }

    if (empty($message)) {
        // Insert data into the colors table
        $db = dbConn();
        $sql = "INSERT INTO colors (ColorName, ColorCode, Status) VALUES ('$color_name', '$color_code', '1')";
        $db->query($sql);
        $ColorId = $db->insert_id;

        header("Location: manage.php");
    }
}
?> 

<div class="row">
    <div class="col-12">
        <!-- Card Start -->
        <a href="<?= SYS_URL ?>colors/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Colors Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Color</h3>
            </div>

            <!-- Form Start -->
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                    <!-- Color Name -->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="color_name" class="form-label fw-bold">Color Name<span style="color: red"> * </span></label>
                            <input type="text" name="color_name" class="form-control mb-1" id="color_name" value="<?= @$color_name ?>" placeholder="Enter Color Name">
                            <span class="text-danger"><?= @$message['color_name'] ?></span>
                        </div>
                    </div>

                    <!-- Color Picker and Code -->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="colorPicker" class="form-label fw-bold">Choose a Color<span style="color: red"> * </span></label>
                            <p>Please click on the color area to select a color. A color picker will appear, allowing you to choose your desired color. After selecting a color, the color code will be displayed in the 'Color Code' input field. The default color is black.</p>
                            <input type="color" id="colorPicker" name="colorPicker" class="form-control mb-1" style="width: 60px; padding: 0;" value="<?= @$color_code ?>" onchange="updateColorCode(this.value)">
                            <label for="color_code" class="form-label fw-bold">Color Code<span style="color: red"> * </span></label>
                            <input type="text" name="color_code" class="form-control mb-1" id="color_code" value="<?= @$color_code ?>" readonly>
                            <span class="text-danger"><?= @$message['color_code'] ?></span>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="<?= SYS_URL ?>colors/manage.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn submit">Submit</button>
                </div>
            </form>
            <!-- Form End -->

        </div>
        <!-- Card End -->
    </div>
</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>

<script>
    function updateColorCode(color) {
        document.getElementById('color_code').value = color;
    }
</script>
