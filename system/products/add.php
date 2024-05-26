<?php
ob_start();
include_once '../init.php';

$link = "Product Management";
$breadcrumb_item = "Product";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $product_name = dataClean($product_name);
    $product_brand = dataClean($product_brand);
    $product_category = dataClean($product_category);
    $supplier = dataClean($supplier);
    $purchase_price = dataClean($purchase_price);
    $selling_price = dataClean($selling_price);
    $description = dataClean($description);
    $warranty_period = dataClean($warranty_period);
    $discount = dataClean($discount);
    $start_date = dataClean($start_date);
    $end_date = dataClean($end_date);

    $message = array();

    //    Required validation

    if (empty($product_name)) {
        $message['product_name'] = "Product Name is required.";
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



    //    Advance validation    
    // File upload handling
    $product_image = '';
    if (isset($_FILES['product_image'])) {
        $uploadDir = '../assets/dist/img/uploads/products/'; 
        $uploadFile = $uploadDir . basename($_FILES['product_image']['name']); 
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
            $product_image = basename($_FILES['product_image']['name']); 
        } 
    } 

    if (empty($message)) {

        $db = dbConn();
        $sql = "INSERT INTO products(ProductName, BrandID, CategoryId, SupplierId, ProductImage, PurchasePrice, SellingPrice, Description, WarrantyPeriod, Discount, DiscountStartDate, DiscountEndDate, Status) "
                . "VALUES ('$product_name','$product_brand','$product_category','$supplier','$product_image','$purchase_price','$selling_price','$description','$warranty_period','$discount','$start_date','$end_date','1')";
        $db->query($sql);
        $ProductID = $db->insert_id;

        header("Location:manage.php");
    }
}
?> 

<div class="row">

    <div class="col-12">

        <!--Card Start-->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Supplier</h3>
            </div>         

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <!--Product Name , Product Brand and Product Category-->

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="product_name" class="form-label fw-bold">Product Name<span style = "color: red"> * </span></label>
                            <input type="text" name="product_name" class="form-control mb-1" id="product_name" value="<?= @$product_name ?>" placeholder="Enter Product Name">
                            <span class="text-danger"><?= @$message['product_name'] ?></span>
                        </div> 

                        <div class="form-group col-md-4">
                            <label for="product_brand">Product Brand<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  brands";
                            $result = $db->query($sql);
                            ?>
                            <select name="product_brand" id="product_brand"  class="form-control mb-1" value="<?= @$product_brand ?>" aria-label="Large select example">
                                <option value="" >Select Product Brand</option>
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

                        <div class="form-group col-md-4">
                            <label for="product_category">Product Category<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  categories";
                            $result = $db->query($sql);
                            ?>
                            <select name="product_category" id="product_category"  class="form-control mb-1" value="<?= @$product_category ?>" aria-label="Large select example">
                                <option value="" >Select Product Category</option>
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

                    </div>

                    <!--Supplier, Purchase Price and Selling Price-->

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="product_category">Supplier<span style = "color : red"> * </span></label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  suppliers";
                            $result = $db->query($sql);
                            ?>
                            <select name="supplier" id="supplier"  class="form-control mb-1" value="<?= @$supplier ?>" aria-label="Large select example">
                                <option value="" >Select Supplier</option>
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
                        <div class="form-group col-md-4">
                            <label for="purchase_price">Purchase Price(LKR)<span style = "color : red"> * </span></label>
                            <input type="text" name="purchase_price" class="form-control mb-1" id="purchase_price" value="<?= @$purchase_price ?>" placeholder="Enter Purchase Price">
                            <span class="text-danger"><?= @$message['purchase_price'] ?></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="selling_price">Selling Price(LKR)<span style = "color : red"> * </span></label>
                            <input type="text" name="selling_price" class="form-control mb-1" id="selling_price" value="<?= @$selling_price ?>" placeholder="Enter Selling Price">
                            <span class="text-danger"><?= @$message['selling_price'] ?></span>
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
                        <div class="form-group col-md-6">
                            <label for="product_image">Product Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="product_image" id="product_image" value="<?= @$product_image ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="warranty_period">Warranty Period</label>
                            <input type="text" name="warranty_period" class="form-control mb-1" id="warranty_period" value="<?= @$warranty_period ?>" placeholder="Enter Warranty Period">

                        </div>

                    </div>

                    <!--Discount Details-->

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="discount" class="form-label fw-bold">Discount(%)</label>
                            <input type="text" name="discount" class="form-control mb-1" id="discount" value="<?= @$discount ?>" placeholder="Enter Discount(%)">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="start_date">Discount Start Date</label>
                            <input type="date" name="start_date" class="form-control mb-1" id="start_date" value="<?= @$start_date ?>">


                        </div>
                        <div class="form-group col-md-4 mt-3 mt-md-0">
                            <label for="end_date">Discount End Date</label>
                            <input type="date" name="end_date" class="form-control mb-1" id="end_date" value="<?= @$end_date ?>">

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


</div>



<?php
$content = ob_get_clean();
include '../layouts.php';
?>