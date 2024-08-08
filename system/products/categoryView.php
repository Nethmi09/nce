<?php
ob_start();
include_once '../init.php'; // Include initialization script for database connection and other settings

$link = "Category Management";
$breadcrumb_item = "Category";
$breadcrumb_item_active = "View";

// Extract Category ID from the GET request
extract($_GET);
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/categoryManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i>Back to Categories Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Category Details</h3>
            </div>

            <div class="card-body">
                <?php
                // Establish database connection
                $db = dbConn();
                // Query to fetch the category details along with the main category name
                $sql = "SELECT CategoryId,CategoryName,CDescription, m.MainCategoryName FROM categories c INNER JOIN main_categories m ON m.MainCategoryId=c.MainCategoryId WHERE c.CategoryId='$categoryid'";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the category details
                    $category = $result->fetch_assoc();
                } else {
                    // Display a message and exit if the category is not found
                    echo "Category not found.";
                    exit;
                }
                ?>

                <!-- Category Details Table Start -->
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <th style="width: 400px;">Category ID</th>
                            <td><?= $category['CategoryId'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Category Name</th>
                            <td><?= $category['CategoryName'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Description</th>
                            <td><?= $category['CDescription'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Main Category Name</th>
                            <td><?= $category['MainCategoryName'] ?></td>
                        </tr>

                    </tbody>
                </table>
                <!-- Category Details Table End -->
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
