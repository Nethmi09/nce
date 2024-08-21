<?php
ob_start();
include_once '../init.php';

$link = "Product Management";
$breadcrumb_item = "Product";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Handle GET request to fetch product details based on the ProductId from the URL
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT * FROM products WHERE ProductId='$productid'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // Assign fetched product details to variables
    $product_name = $row['ProductName'];
    $product_main_category = $row['MainCategoryId'];
    $product_brand = $row['BrandID'];
    $product_category = $row['CategoryId'];
    $color = $row['ColorId'];
    $supplier = $row['SupplierId'];
    $product_image = $row['ProductImage'];
    $purchase_price = $row['PurchasePrice'];
    $selling_price = $row['SellingPrice'];
    $description = $row['PDescription'];
    $ProductId = $row['ProductId'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle POST request to update product details
    extract($_POST);
    // Clean input data
    $product_name = dataClean($product_name);
    $description = dataClean($description);

    //Initialize an array to hold error messages
    $message = array();

    //    Required validation

    if (empty($product_name)) {
        $message['product_name'] = "Product Name is required.";
    }
    if (empty($product_main_category)) {
        $message['product_main_category'] = "Product Main Category is required.";
    }
    if (empty($product_brand)) {
        $message['product_brand'] = "Product Brand is required.";
    }

    if (empty($product_category)) {
        $message['product_category'] = "Product Category is required.";
    }

    if (empty($supplier)) {
        $message['supplier'] = "Supplier is required.";
    }

    if (empty($purchase_price)) {
        $message['purchase_price'] = "Purchase Price is required.";
    }

    if (empty($selling_price)) {
        $message['selling_price'] = "Selling Price is required.";
    }

    

    if (empty($color)) {
        $message['color'] = "Color is required.";
    }


    $product_image = '';

    $new_product_image = $product_image;
    if (!empty($_FILES['product_image']['name'])) {
        $uploadDir = '../assets/dist/img/uploads/products/';
        $uploadFile = $uploadDir . basename($_FILES['product_image']['name']);

        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedExtensions)) {
            $message['product_image'] = "Only JPG, JPEG & PNG files are allowed.";
        }if ($_FILES['product_image']['size'] > 5000000) { // 5 MB
            $message['product_image'] = "Your file is too large.";
        }
        if (empty($message['product_image']) && move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
            $new_product_image = basename($_FILES['product_image']['name']);
        }
    } else {
        $new_product_image = $prv_product_image;
    }

    if (empty($message)) {
        $db = dbConn();
      $sql = "UPDATE `products` SET `ProductName`='$product_name', `MainCategoryId`='$product_main_category', "
     . "`BrandID`='$product_brand', `CategoryId`='$product_category', `ColorId`='$color', "
     . "`SupplierId`='$supplier', `ProductImage`='$new_product_image', `PurchasePrice`='$purchase_price', "
     . "`SellingPrice`='$selling_price', `PDescription`='$description' WHERE ProductId='$ProductId'";

        $db->query($sql);
        header("Location: productManage.php");
        exit();
    }
}
?>

<div class="row">

    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>products/productManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Products Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Product</h3>
            </div>         

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <!--Product Name , Product Brand and Product Category-->

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="product_name" class="form-label fw-bold">Product Name<span style = "color: red"> * </span></label>
                            <input type="text" name="product_name" class="form-control mb-1" id="product_name" value="<?= @$product_name ?>" placeholder="Enter Product Name">
                            <span class="text-danger"><?= @$message['product_name'] ?></span>
                        </div> 

                        <div class="form-group col-md-3">
                            <label for="product_main_category">Product Main Category<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  main_categories WHERE Status=1";
                            $result = $db->query($sql);
                            ?>
                            <select name="product_main_category" id="product_main_category"  class="form-control select2 mb-1" value="<?= @$product_main_category ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select Product Main Category</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['MainCategoryId'] ?>" <?= @$product_main_category == $row['MainCategoryId'] ? 'selected' : '' ?>><?= $row['MainCategoryName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['product_main_category'] ?></span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="product_category">Product Category<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  categories WHERE Statuss=1";
                            $result = $db->query($sql);
                            ?>
                            <select name="product_category" id="product_category"  class="form-control select2 mb-1" value="<?= @$product_category ?>" aria-label="Large select example">
                                <option value="" disabled selected >Select Product Category</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                   
                                      <option value="<?= $row['CategoryId'] ?>" <?= @$product_category == $row['CategoryId'] ? 'selected' : '' ?>><?= $row['CategoryName'] ?></option>
                                    
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['product_category'] ?></span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="product_brand">Product Brand<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  brands WHERE BStatus=1";
                            $result = $db->query($sql);
                            ?>
                            <select name="product_brand" id="product_brand"  class="form-control select2 mb-1" value="<?= @$product_brand ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select Product Brand</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                   
                                      <option value="<?= $row['BrandId'] ?>" <?= @$product_brand == $row['BrandId'] ? 'selected' : '' ?>><?= $row['BrandName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['product_brand'] ?></span>
                        </div>



                    </div>

                    <!--Supplier, Purchase Price , Selling Price and color-->

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="product_category">Supplier<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  suppliers WHERE Status=1";
                            $result = $db->query($sql);
                            ?>
                            <select name="supplier" id="supplier"  class="form-control select2 mb-1" value="<?= @$supplier ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select Supplier</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                  
                                      <option value="<?= $row['SupplierId'] ?>" <?= @$supplier == $row['SupplierId'] ? 'selected' : '' ?>><?= $row['SupCompanyName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['supplier'] ?></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="purchase_price">Purchase Price(LKR)<span style = "color : red"> * </span></label>
                            <input type="text" name="purchase_price" class="form-control mb-1" id="purchase_price" value="<?= @$purchase_price ?>" placeholder="Enter Purchase Price">
                            <span class="text-danger"><?= @$message['purchase_price'] ?></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="selling_price">Selling Price(LKR)<span style = "color : red"> * </span></label>
                            <input type="text" name="selling_price" class="form-control mb-1" id="selling_price" value="<?= @$selling_price ?>" placeholder="Enter Selling Price">
                            <span class="text-danger"><?= @$message['selling_price'] ?></span>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="color">Color<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  colors WHERE Status=1";
                            $result = $db->query($sql);
                            ?>
                            <select name="color" id="color"  class="form-control select2 mb-1" value="<?= @$color ?>" aria-label="Large select example">
                                <option value="" disabled selected>Select Color</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    
                                      <option value="<?= $row['ColorId'] ?>" <?= @$color== $row['ColorId'] ? 'selected' : '' ?>><?= $row['ColorName'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['supplier'] ?></span>
                        </div>


                    </div>

                    <!--Description-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control mb-1" type="text" name="description" id="description" rows="4" value="<?= @$description ?>"  placeholder="Enter Description"></textarea>
                        </div>                      
                    </div>

                    <!--Product Image and Warranty Period-->

                    <div class="row">
                        <div class="form-group">
                            <label for="product_image">Product Image</label>
                            <div class="input-group">
                                <input type="file" name="product_image" id="product_image" class="form-control">
                                <span class="text-danger"><?= @$message['product_image'] ?></span>
                            </div>
                            <?php if ($product_image): ?>
                                <img src="../assets/dist/img/uploads/products/<?= $product_image ?>" alt="Product Image" style="max-width: 100px;">
                            <?php endif; ?>
                            <input type="hidden" name="prv_product_image" value="<?= @$product_image ?>">
                        </div>


                    </div>


                </div>

                <div class="card-footer">
                    <input type="hidden" name="ProductId" value="<?= $ProductId ?>">
                    <button type="submit" class="btn btn-primary">Update</button>
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
