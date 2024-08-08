<?php
ob_start();
include_once '../init.php';

$link = "Main Category Management";
$breadcrumb_item = "Main Category";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to fetch category details based on the categoryid from the URL
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT * FROM main_categories WHERE MainCategoryId='$maincategoryid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // Assign fetched category details to variables
    $main_category_name = $row['MainCategoryName'];
            $description = $row['Description'];
            $MainCategoryId = $row['MainCategoryId'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle POST request to update main category details
    extract($_POST);
    // Clean input data
    $main_category_name = dataClean($main_category_name);
    $description = dataClean($description);

    //Initialize an array to hold error messages
    $message = array();

    // Required Validations
    if (empty($main_category_name)) {
        $message['main_category_name'] = "Main Category Name is required.";
    }

    // Advance Validations
    if (!empty($main_category_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM main_categories WHERE MainCategoryName='$main_category_name'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['main_category_name'] = "This Main Category Name already exists!";
        }
    }

    if (empty($message)) {
        $db = dbConn();
        $sql = "UPDATE main_categories SET MainCategoryName='$main_category_name', Description='$description' WHERE MainCategoryId='$MainCategoryId'";
        $db->query($sql);
        header("Location: mainCategoryManage.php");
        exit();
    }
}
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/mainCategoryManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Main Categories Listing Table</a>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Main Category</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <!-- Main Category Name -->
                    <div class="form-group">
                        <label for="main_category_name">Main Category Name<span style="color: red;"> * </span></label>
                        <input type="text" class="form-control" id="main_category_name" name="main_category_name" value="<?= @$main_category_name ?>" placeholder="Enter Main Category Name">
                        <span class="text-danger"><?= @$message['main_category_name'] ?></span>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description"><?= @$description ?></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <input type="hidden" name="MainCategoryId" value="<?= $MainCategoryId ?>">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
