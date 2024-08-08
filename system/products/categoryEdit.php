<?php
ob_start();
include_once '../init.php';

$link = "Category Management";
$breadcrumb_item = "Category";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to fetch category details based on the categoryid from the URL
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT * FROM categories WHERE CategoryId='$categoryid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // Assign fetched category details to variables
    $category_name = $row['CategoryName'];
    $description = $row['CDescription'];
    $main_category_id = $row['MainCategoryId'];
    $CategoryId = $row['CategoryId'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle POST request to update category details
    extract($_POST);
    // Clean input data
    $category_name = dataClean($category_name);
    $description = dataClean($description);

    //Initialize an array to hold error messages
    $message = array();

    //Required Validations
    if (empty($category_name)) {
        $message['category_name'] = "Category Name is required.";
    }

    if (empty($main_category)) {
        $message['main_category'] = "Main Category Name is required.";
    }
//Advance Validations
    // Check for unique category name excluding the current category
    if (!empty($category_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM categories WHERE CategoryName='$category_name'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['category_name'] = "This Category Name already exists!";
        }
    }

    
    if (empty($message)) {
        $db = dbConn();
        $sql = "UPDATE categories SET CategoryName='$category_name', CDescription='$description', MainCategoryId='$main_category' WHERE CategoryId='$CategoryId'";
        $db->query($sql);
        header("Location: categoryManage.php");
        exit();
    }
}
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/categoryManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Categories Listing Table</a>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Category</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="category_name">Category Name<span style="color: red;"> * </span></label>
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?= @$category_name ?>" placeholder="Enter Category Name" >
                        <span class="text-danger"><?= @$message['category_name'] ?></span>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description"><?= @$description ?></textarea>
                    </div>

                    <!-- Main Category Name -->
                    <div class="form-group">
                        <label for="main_category">Main Category Name<span style="color: red;"> * </span></label>
                        <select name="main_category" id="main_category" class="form-control">
                            <option value="" disabled selected>Select Main Category Name</option>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM main_categories";
                            $result = $db->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <option value="<?= $row['MainCategoryId'] ?>" <?= @$main_category_id == $row['MainCategoryId'] ? 'selected' : '' ?>><?= $row['MainCategoryName'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= @$message['main_category'] ?></span>
                    </div>

                </div>

                <div class="card-footer">
                     <!-- Hidden input field to pass the CategoryId with the form submission -->
                    <input type="hidden" name="CategoryId" value="<?= $CategoryId ?>">
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
