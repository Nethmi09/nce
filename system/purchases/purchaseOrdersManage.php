<?php
ob_start();
include_once '../init.php';

$link = "Purchase Order Management";
$breadcrumb_item = "Purchase Order";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Purchase Order Details Table</h3>
            </div>
            <div class="card-body">
                <?php
                ?>
                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PO Number</th>
                            <th>Supplier Name</th>
                            <th>Supplier Email</th>
                            <th>Supplier Contact Number</th>
                            <th>Request Date</th>
                            <th>Required Date</th>
                            <th>Actions</th>
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