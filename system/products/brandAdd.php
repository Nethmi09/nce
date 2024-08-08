<?php
ob_start();
include_once '../init.php';

$link = "Brand Management";
$breadcrumb_item = "Brand";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $brand_name = dataClean($brand_name);
    $description = dataClean($description);
    $main_category = dataClean($main_category);

    $message = array();

    //    Required validation

    if (empty($brand_name)) {
        $message['brand_name'] = "Brand Name is required.";
    }

    if (empty($main_category)) {
        $message['main_category'] = "Main Category Name is required.";
    }

    //    Advance validation

    if (!empty($brand_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM brands WHERE BrandName='$brand_name'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['brand_name'] = "This Brand Name already exsist!";
        }
    }

    // File upload handling
    $brand_image = '';
    if (!empty($_FILES['brand_image']['name'])) {
        $uploadDir = '../assets/dist/img/uploads/brands/';
        $uploadFile = $uploadDir . basename($_FILES['brand_image']['name']);

        // Check if file type is an image
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedExtensions)) {
            $message['brand_image'] = "Sorry, only JPG, JPEG & PNG files are allowed.";
        }

        // Check file size
        if ($_FILES['brand_image']['size'] > 5000000) { // 5 MB (you can adjust this limit)
            $message['brand_image'] = "Sorry, your file is too large.";
        }
        // Check if file was uploaded without errors
        if (move_uploaded_file($_FILES['brand_image']['tmp_name'], $uploadFile)) {
            $brand_image = basename($_FILES['brand_image']['name']);
        }
    }

    if (empty($message)) {
//Insert data into the brands table
        $db = dbConn();
        $sql = "INSERT INTO brands(BrandImage,BrandName,BDescription,MainCategoryId,BStatus) VALUES ('$brand_image', '$brand_name','$description','$main_category','1')";
        $db->query($sql);
        $BrandId = $db->insert_id;

        header("Location:brandManage.php");
    }
}
?> 

<div class="row">

    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>products/brandManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Brands Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Brand</h3>
            </div>         

            <!--Form Start-->
<!-- The form action uses PHP's htmlspecialchars() function to safely output the current script name. -->
<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <!--Brand Name-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="brand_name" class="form-label fw-bold">Brand Name<span style = "color: red"> * </span></label>
                            <input type="text" name="brand_name" class="form-control mb-1" id="brand_name" value="<?= @$brand_name ?>" placeholder="Enter Brand Name">
                            <span class="text-danger"><?= @$message['brand_name'] ?></span>
                        </div>                      
                    </div>

                    <!--Description-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control mb-1" type="text" name="description" id="description" rows="3" value="<?= @$description ?>"  placeholder="Enter Description"></textarea>
                        </div>                      
                    </div>

                    <!--Main Category Name-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  main_categories";
                            $result = $db->query($sql);
                            ?>
                            <label for="main_category">Main Category Name<span style = "color : red;"> * </span></label>
                            <select name="main_category" id="main_category"  class="form-control mb-1" value="<?= @$main_category ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select Main Category Name</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['MainCategoryId'] ?>"><?= $row['MainCategoryName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['main_category'] ?></span>

                        </div>
                    </div>

                    <!--Brand Image-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="brand_image">Brand Logo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="brand_image" id="brand_image" value="<?= @$brand_image ?>" class="form-control">
                                    <span class="text-danger"><?= @$message['brand_image'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="card-footer">
                    <a href="<?= SYS_URL ?>products/brandManage.php" class="btn btn-secondary">Cancel</a>
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