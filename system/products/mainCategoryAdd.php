<?php
ob_start();
include_once '../init.php';

$link = "Main Category Management";
$breadcrumb_item = "Main Category";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $main_category_name = dataClean($main_category_name);
    $description = dataClean($description);

    $message = array();

    //    Required validation

    if (empty($main_category_name)) {
        $message['main_category_name'] = "Main Category Name is required.";
    }


    //    Advance validation

    if (!empty($category_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM main_categories WHERE MainCategoryName='$main_category_name'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['main_category_name'] = "This Main Category Name already exsist!";
        }
    }


    if (empty($message)) {
//Insert data into the main_categories table
        $db = dbConn();
        $sql = "INSERT INTO main_categories(MainCategoryName,Description,Status) VALUES ('$main_category_name','$description','1')";
        $db->query($sql);
        $CategoryId = $db->insert_id;

        header("Location:mainCategoryManage.php");
    }
}
?> 

<div class="row">

    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>products/mainCategoryManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Main Categories Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Main Category</h3>
            </div>   

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!--Main Category Name-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="main_category_name" class="form-label fw-bold">Main Category Name<span style = "color: red"> * </span></label>
                            <input type="text" name="main_category_name" class="form-control mb-1" id="main_category_name" value="<?= @$main_category_name ?>" placeholder="Enter Main Category Name" required>
                            <span class="text-danger"><?= @$message['main_category_name'] ?></span>
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
                   <a href="<?= SYS_URL ?>products/mainCategoryManage.php" class="btn btn-secondary">Cancel</a>
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