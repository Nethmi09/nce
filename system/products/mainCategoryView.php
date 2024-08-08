<?php
ob_start();
include_once '../init.php'; // Include initialization script for database connection and other settings

$link = "Main Category Management";
$breadcrumb_item = "Main Category";
$breadcrumb_item_active = "View";

// Extract Main Category Id from the GET request
extract($_GET);

?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>products/mainCategoryManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Main Categories Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Main Category Details</h3>
            </div>

            <div class="card-body">
                <?php
                 // Establish database connection
                $db = dbConn();
                 // Query to retrieve main category details
               $sql = "SELECT * FROM main_categories WHERE main_categories.MainCategoryId='$maincategoryid'";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the main category details
                    $mainCategory = $result->fetch_assoc();
                } else {
                    echo "Main Category not found.";
                    exit;
                }
                ?>

                <!-- Main Category Details Table Start -->
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <th style="width: 400px;">Main Category ID</th>
                            <td><?= $mainCategory['MainCategoryId'] ?></td>
                        </tr>
                        <tr>
                            <th style="width: 400px;">Main Category Name</th>
                            <td><?= $mainCategory['MainCategoryName'] ?></td>
                        </tr>
                         <tr>
                            <th style="width: 400px;">Description</th>
                            <td><?= $mainCategory['Description'] ?></td>
                        </tr>

                    </tbody>
                </table>
                <!-- Main Category Details Table End -->
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
