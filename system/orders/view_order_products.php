<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "View";

extract($_GET);
extract($_POST);
$db = dbConn();
$sql = "SELECT o.*,c.FirstName,c.LastName,d.Name FROM orders o INNER JOIN customers c ON c.CustomerId=o.CustomerId INNER JOIN districts d ON d.Id=o.PersonalDistrictId WHERE o.OrderID='$order_id'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$order_status = $row['OrderStatus'];
?> 
<div class="row">
    <div class="col-12">

        <a href="<?= SYS_URL ?>orders/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to order List</a>

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Order Products Details</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Customer Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Customer Name</strong></td>
                                        <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Order Number</strong></td>
                                        <td><?= $row['OrderNumber'] ?></td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Billing Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Billing Name</strong></td>
                                        <td><?= ($row['PersonalName']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td><?= ($row['PersonalEmail']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Mobile</strong></td>
                                        <td><?= ($row['PersonalContactMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alternate Mobile</strong></td>
                                        <td><?= ($row['PersonalAlternateMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 1</strong></td>
                                        <td><?= ($row['PersonalAddressLine1']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 2</strong></td>
                                        <td><?= ($row['PersonalAddressLine2']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>City</strong></td>
                                        <td><?= ($row['PersonalCity']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>District</strong></td>
                                        <td><?= ($row['Name']) ?></td>
                                    </tr>
                                </table> 

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Shipping Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Shipping Name</strong></td>
                                        <td><?= ($row['ShippingName']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td><?= ($row['ShippingEmail']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Mobile</strong></td>
                                        <td><?= ($row['ShippingContactMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alternate Mobile</strong></td>
                                        <td><?= ($row['ShippingAlternateMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 1</strong></td>
                                        <td><?= ($row['ShippingAddressLine1']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 2</strong></td>
                                        <td><?= ($row['ShippingAddressLine2']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>City</strong></td>
                                        <td><?= ($row['ShippingCity']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>District</strong></td>
                                        <td><?= ($row['Name']) ?></td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $db = dbConn();

                $sql = "SELECT 
    o.OrderId,
    o.ProductId,
    o.UnitPrice,
    o.Quantity,
    p.ProductName,
    o.IssuedQuantity,
    (COALESCE(stock_totals.total_qty, 0) - COALESCE(stock_totals.total_issued_qty, 0)) AS balance_qty
FROM 
    order_products o 
INNER JOIN 
    products p ON p.ProductId = o.ProductId 
LEFT JOIN 
    (
        SELECT 
            ProductId,
            UnitPrice,
            SUM(Quantity) AS total_qty, 
            SUM(IssuedQuantity) AS total_issued_qty 
        FROM 
            product_stocks 
        GROUP BY 
            ProductId,UnitPrice
    ) AS stock_totals ON stock_totals.ProductId = o.ProductId and  stock_totals.UnitPrice=o.UnitPrice
WHERE 
    o.OrderId = '$order_id'
GROUP BY 
    o.OrderId, o.ProductId, o.UnitPrice;
";
                $result = $db->query($sql);
                ?>
                <form action="../inventory/issue.php" method="post">
                    <h3>Order Products</h3>
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Unit Price</th>  
                                <th>Ordered Qty</th>
                                <th>Balance Qty</th>
                                <th>Issued Qty</th>               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $row['ProductName'] ?></td>
                                        <td><?= $row['UnitPrice'] ?></td>
                                        <td><?= $row['Quantity'] ?></td>
                                        <td><?= $row['balance_qty'] ?></td>
                                        <td>
                                            <?php if ($order_status == '1') {
                                                ?>
                                                <?= $row['IssuedQuantity']; ?>
                                                <a href="return_product.php?product_id=<?= $row['ProductId'] ?>&order_id=<?= $row['OrderId'] ?>">Return Product</a>
                                            <?php } else {
                                                ?>
                                                <input type="hidden" name="products[]" value="<?= $row['ProductId'] ?>">
                                                <input type="hidden" name="order_id" value="<?= $row['OrderId'] ?>">
                                                <input type="hidden" name="prices[]" value="<?= $row['UnitPrice'] ?>">                                           
                                                <input type="text" name="issued_qty[]" max="<?= $row['balance_qty'] ?>">
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <button type="submit" class="btn btn-primary">Issue</button>
                </form>

                <!--Table End-->

            </div>

        </div>

    </div>
</div>
<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>