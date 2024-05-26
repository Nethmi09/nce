<?php
ob_start();
include_once '../init.php';

$link = "Category Management";
$breadcrumb_item = "Category";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $category_name = dataClean($category_name);
    $description = dataClean($description);
    $main_category = dataClean($main_category);

    $message = array();

    //    Required validation

    if (empty($category_name)) {
        $message['category_name'] = "Category Name is required.";
    }

    if (empty($main_category)) {
        $message['main_category'] = "Main Category Name is required.";
    }

    //    Advance validation

    if (!empty($category_name)) {
        $db = dbConn();
        $sql = "SELECT * FROM categories WHERE CategoryName='$category_name'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['category_name'] = "This Category Name already exsist!";
        }
    }

    
    if (empty($message)) {

        $db = dbConn();
        $sql = "INSERT INTO categories(CategoryName,Description,MainCategoryId,Status) VALUES ('$category_name','$description','$main_category','1')";
        $db->query($sql);
        $CategoryId = $db->insert_id;

        header("Location:manage.php");
    }
}
?> 

<div class="row">
    <div class="col-3">
    </div>

    <div class="col-6">

        <!--Card Start-->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Category</h3>
            </div>   

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!--Category Name-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="category_name" class="form-label fw-bold">Category Name<span style = "color: red"> * </span></label>
                            <input type="text" name="category_name" class="form-control mb-1" id="category_name" value="<?= @$category_name ?>" placeholder="Enter Category Name" required>
                            <span class="text-danger"><?= @$message['category_name'] ?></span>
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
                            <select name="main_category" id="main_category"  class="form-control mb-1" value="<?= @$main_category ?>" aria-label="Large select example" required>
                                <option value="" >Select Main Category Name</option>
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

                </div>


                <div class="card-footer">
                    <button type="submit" class="btn cancel">Cancel</button>
                    <button type="submit" class="btn submit">Submit</button>
                </div>

            </form>

            <!--Form End-->

        </div>
        <!--Card End-->
    </div>

    <div class="col-3">
    </div>

</div>

<?php
$content = ob_get_clean();
include '../layouts.php';
?>