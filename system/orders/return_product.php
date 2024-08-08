<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "View";

extract($_GET);
extract($_POST);

$db = dbConn();
$sql = "SELECT o.*,c.FirstName,c.LastName,d.Name FROM orders o INNER JOIN customers c ON c.CustomerId=o.CustomerId INNER JOIN districts d ON d.Id=o.PersonalDistrictId WHERE o.OrderID='$product_id'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$order_status = $row['OrderStatus'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "SELECT * FROM order_products_issue WHERE OrderId='$order_id' AND ProductId='$product_id'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $stock_id = $row['StockId']; //Order issued - stockid
    $unit_price = $row['UnitPrice'];
    //If the return type is not damaged
    if ($return_type <> "damaged") {
        //Updated the order product issue table(Issued Quantity-Return Quantity)
        $sql = "UPDATE order_products_issue SET IssuedQuantity = COALESCE(IssuedQuantity, 0) - $quantity_return WHERE StockId = '$stock_id' AND OrderId='$order_id' AND ProductId='$product_id'";
        $db->query($sql);
        //Updated the order products table(Issued Quantity-Return Quantity)
        $sql = "UPDATE order_products SET IssuedQuantity = COALESCE(IssuedQuantity, 0) - $quantity_return WHERE StockId = '$stock_id' AND OrderId='$order_id' AND ProductId='$product_id'";
        $db->query($sql);
        //Updated the product stock table.(When not damaged items return should update the product stock again. Issued Quantity-Return Quantity) Don't add it quantity 
        $sql = "UPDATE product_stocks SET IssuedQuantity = COALESCE(IssuedQuantity, 0) - $quantity_return WHERE StockId = '$stock_id'";
        $db->query($sql);
    }
    //When product is damaged or any return type should insert details to order returns products table.
    $sql = "INSERT INTO order_returns_products(OrderId, ProductId, StockId, UnitPrice, Quantity, ReturnDate,ReturnType,ReturnReason) 
                    VALUES ('$order_id', '$product_id', '$stock_id', '$unit_price', '$quantity_return', '$return_date','$return_type','$return_reason')";
    $db->query($sql);
}
?> 
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Handle Product Returns</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">


                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="hidden" name="product_id" class="form-control mb-1" id="product_id" value="<?= @$product_id ?>">
                            <span class="text-danger"><?= @$message['product_id'] ?></span>
                        </div> 

                        <div class="form-group col-md-6">

                            <input type="hidden" name="order_id" class="form-control mb-1" id="order_id" value="<?= @$order_id ?>">
                            <span class="text-danger"><?= @$message['order_id'] ?></span>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="quantity_return">Quantity<span style = "color : red;"> * </span></label>
                            <input type="text" name="quantity_return" class="form-control mb-1" id="quantity_return" value="<?= @$quantity_return ?>">
                            <span class="text-danger"><?= @$message['quantity_return'] ?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="return_type">Return Type<span style = "color : red"> * </span></label>
                            <select id="return_type" class="form-control mb-1" name="return_type" required>
                                <option value="color_change">Color Change</option>
                                <option value="category_change">Category Change</option>
                                <option value="brand_change">Brand Change</option>
                                <option value="damaged">Damaged</option>
                            </select>
                            <span class="text-danger"><?= @$message['return_type'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="return_reason">Return Reason</label>
                            <textarea class="form-control mb-1" type="text" name="return_reason" id="return_reason" rows="3" value="<?= @$return_reason ?>"  placeholder="Enter Return Reason"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="return_date">Return Date<span style = "color : red;"> * </span></label>
                            <input type="date" name="return_date" class="form-control mb-1" id="return_date" value="<?= @$return_date ?>">
                            <span class="text-danger"><?= @$message['return_date'] ?></span>
                        </div>
                    </div>


                </div>


                <div class="card-footer">
                    <button type="submit" class="btn cancel">Cancel</button>
                    <button type="submit" class="btn submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>