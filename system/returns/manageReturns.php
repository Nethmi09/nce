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
                $sql = "SELECT * FROM order_returns_products";
                $result = $db->query($sql);
                ?>
                <!--Table Start-->

                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Product Name</th> 
                            <th>Product Price</th> 
                            <th>Quantity</th>  
                            <th>Return Type</th> 
                            <th>Return Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        
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