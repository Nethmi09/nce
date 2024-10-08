<?php
ob_start();
include_once '../init.php';

$link = "Product Management";
$breadcrumb_item = "Product";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $product_name = dataClean($product_name);
    $purchase_price = dataClean($purchase_price);
    $selling_price = dataClean($selling_price);
    $description = dataClean($description);

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



    //    Advance validation    
    // File upload handling
    $product_image = '';
    if (!empty($_FILES['product_image']['name'])) {
        $uploadDir = '../assets/dist/img/uploads/products/';
        $uploadFile = $uploadDir . basename($_FILES['product_image']['name']);

        // Check if file type is an image
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedExtensions)) {
            $message['product_image'] = "Sorry, only JPG, JPEG & PNG files are allowed.";
        }

        // Check file size
        if ($_FILES['product_image']['size'] > 5000000) { // 5 MB
            $message['product_image'] = "Sorry, your file is too large.";
        }

        // Check if file was uploaded without errors
        if (empty($message['product_image']) && move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
            $product_image = basename($_FILES['product_image']['name']);
        } else {
            $message['product_image'] = "Sorry, there was an error uploading your file.";
        }
    } else {
        $message['product_image'] = "Product Image is required.";
    }

    if (empty($message)) {

        $db = dbConn();
        //check product is available in database
        echo $checksql1 = "SELECT * FROM products WHERE ProductName = '$product_name'";
        $resultCheck = $db->query($checksql1);

        echo '<br>';

        if ($resultCheck->num_rows > 0) {
            $rowCheck = $resultCheck->fetch_assoc();
            $updateid = $rowCheck['ProductId'];

            //if the product is in the database will increase the quantity of it
            echo $updatesql = "UPDATE products SET Quantity = Quantity +1 WHERE ProductId='$updateid'";
            $db->query($updatesql);

            echo '<br>';

            //add the product in to product details table
            echo $serialNumber = "INSERT INTO product_details(ProductId, SerialNumber, BatchNumber, Status) VALUES ('$updateid', '$sereal_number','$batchNumber','1')";
            $db->query($serialNumber);

            echo '<br>';
        } else {
            //add the product in to products  table
            $sql = "INSERT INTO products(ProductName, MainCategoryId , BrandID, CategoryId,ColorId, SupplierId, ProductImage, "
                    . "PurchasePrice, SellingPrice, PDescription,PStatus,Quantity) "
                    . "VALUES ('$product_name','$product_main_category','$product_brand','$product_category',"
                    . "'$color','$supplier','$product_image','$purchase_price','$selling_price','$description','1','1')";
            $db->query($sql);
            $ProductID = $db->insert_id;

            header("Location:productManage.php");
        }
    }
}
?> 

<div class="row">

    <div class="col-12">

        <!--Card Start-->
        <a href="<?= SYS_URL ?>products/productManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Products Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Product</h3>
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
                                    <option value="<?= $row['MainCategoryId'] ?>"><?= $row['MainCategoryName'] ?></option>
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
                                    <option value="<?= $row['CategoryId'] ?>"><?= $row['CategoryName'] ?></option>
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
                                    <option value="<?= $row['BrandId'] ?>"><?= $row['BrandName'] ?></option>
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
                                    <option value="<?= $row['SupplierId'] ?>"><?= $row['SupCompanyName'] ?></option>
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
                                    <option value="<?= $row['ColorId'] ?>"><?= $row['ColorName'] ?></option>
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

                    <!--Product Image-->

                     <div class="row">
                        <div class="form-group col-md-12">
                            <label for="product_image">Product Image<span style = "color : red"> * </span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="product_image" id="product_image" value="<?= @$product_image ?>" class="form-control">
                                    <span class="text-danger"><?= @$message['product_image'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="card-footer">
                    <a href="<?= SYS_URL ?>products/productManage.php" class="btn btn-secondary">Cancel</a>
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