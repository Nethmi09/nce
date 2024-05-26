<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "View";

extract($_GET);


?> 
<div class="row">
    <div class="col-12">

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Order Details</h3>
            </div>
            <div class="card-body">
                
               
              
                 <?php
                $db = dbConn();
                $sql = "SELECT o.*, p.ProductName FROM order_products o INNER JOIN products p ON p.ProductId=o.ProductId WHERE o.OrderId='$orderid'";
                $result = $db->query($sql);
                ?>

                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit Price</th>  
                            <th>Quantity</th>                 
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
$content = ob_get_clean();
include '../layouts.php';
?>