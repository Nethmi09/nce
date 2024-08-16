<?php
ob_start();
include_once '../init.php';

$link = "Brand Management";
$breadcrumb_item = "Brand";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to fetch brand details based on the categoryid from the URL
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT BrandId, BrandImage, BrandName, BDescription, MainCategoryId FROM brands WHERE BrandId='$brandid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // Assign fetched brand details to variables
    $brand_name = $row['BrandName'];
    $description = $row['BDescription'];
    $main_category_id = $row['MainCategoryId'];
    $brand_image = $row['BrandImage'];
    $BrandId = $row['BrandId'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle POST request to update brand details
    extract($_POST);
    // Clean input data
    $brand_name = dataClean($brand_name);
    $description = dataClean($description);

    //Initialize an array to hold error messages
    $message = array();

    //Required Validations
    if (empty($brand_name)) {
        $message['brand_name'] = "Brand Name is required.";
    }

    if (empty($main_category)) {
        $message['main_category'] = "Main Category Name is required.";
    }

    //Advance Validations
    // Check for unique brand name excluding the current category
    if (!empty($brand_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM brands WHERE BrandName='$brand_name'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['brand_name'] = "This Brand Name already exists!";
        }
    }

    $brand_image = '';

    $new_brand_image = $brand_image;
    if (!empty($_FILES['brand_image']['name'])) {
        $uploadDir = '../assets/dist/img/uploads/brands/';
        $uploadFile = $uploadDir . basename($_FILES['brand_image']['name']);

        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedExtensions)) {
            $message['brand_image'] = "Only JPG, JPEG & PNG files are allowed.";
        }if ($_FILES['brand_image']['size'] > 5000000) { // 5 MB
            $message['brand_image'] = "Your file is too large.";
        }
        if (empty($message['brand_image']) && move_uploaded_file($_FILES['brand_image']['tmp_name'], $uploadFile)) {
            $new_brand_image = basename($_FILES['brand_image']['name']);
        }
    } else {
        $new_brand_image = $prv_brand_image;
    }

    if (empty($message)) {
        $db = dbConn();
        $sql = "UPDATE brands SET BrandName='$brand_name', BDescription='$description', MainCategoryId='$main_category', BrandImage='$new_brand_image' WHERE BrandId='$BrandId'";
        $db->query($sql);
        header("Location: brandManage.php");
        exit();
    }
}
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/brandManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Brands Listing Table</a>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Brand</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <!-- Brand Name -->
                    <div class="form-group">
                        <label for="brand_name">Brand Name<span style="color: red;"> * </span></label>
                        <input type="text" class="form-control" id="brand_name" name="brand_name" value="<?= @$brand_name ?>" placeholder="Enter Brand Name" >
                        <span class="text-danger"><?= @$message['brand_name'] ?></span>
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

                    <!-- Brand Image -->
                    <div class="form-group">
                        <label for="brand_image">Brand Logo</label>
                        <div class="input-group">
                            <input type="file" name="brand_image" id="brand_image" class="form-control">
                            <span class="text-danger"><?= @$message['brand_image'] ?></span>
                        </div>
                        <?php if ($brand_image): ?>
                            <img src="../assets/dist/img/uploads/brands/<?= $brand_image ?>" alt="Brand Logo" style="max-width: 100px;">
                        <?php endif; ?>
                        <input type="hidden" name="prv_brand_image" value="<?= @$brand_image ?>">
                    </div>
                </div>

                <div class="card-footer">
                    <input type="hidden" name="BrandId" value="<?= $BrandId ?>">
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
