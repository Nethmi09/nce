<?php
ob_start();
include_once '../init.php';

$link = "Return Management";
$breadcrumb_item = "Return";
$breadcrumb_item_active = "Manage";
?> 

<div class="row">
    <div class="col-12">

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Return Details Table</h3>
            </div>


            <div class="card-body">

                <?php
                $db = dbConn();
                $sql = "SELECT 
            orders.OrderNumber,
            products.ProductName,
            order_returns_products.UnitPrice AS ProductPrice,
            order_returns_products.Quantity,
            order_returns_products.ReturnType,
            order_returns_products.ReturnReason,
            order_returns_products.ReturnDate
        FROM 
            order_returns_products
        INNER JOIN orders ON order_returns_products.OrderId = orders.OrderId
        INNER JOIN products ON order_returns_products.ProductId = products.ProductId
        INNER JOIN product_stocks ON order_returns_products.StockId = product_stocks.StockId";

                $result = $db->query($sql);
                ?>
                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Product Name</th> 
                            <th>Product Price</th> 
                            <th>Quantity</th>  
                            <th>Return Type</th> 
                            <th>Return Reason</th>
                            <th>Return Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>


                                    <td><?= $row['OrderNumber'] ?></td> 
                                    <td><?= $row['ProductName'] ?></td>
                                    <td><?= $row['ProductPrice'] ?></td> 
                                    <td><?= $row['Quantity'] ?></td> 
                                    <td><?= $row['ReturnType'] ?></td> 
                                    <td><?= $row['ReturnReason'] ?></td> 
                                    <td><?= $row['ReturnDate'] ?></td>


                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <!--Table End-->

            </div>

        </div>

    </div>
</div>
<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>