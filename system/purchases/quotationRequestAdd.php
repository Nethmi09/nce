<?php
ob_start();
include_once '../init.php';

$link = "Quotation Request Management";
$breadcrumb_item = "Quotation Request";
$breadcrumb_item_active = "Add";

extract($_POST);
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'add') {
    $db = dbConn();
    $sql = "SELECT * FROM price_request WHERE RequestDate='$RequestDate' AND SupplierId='$Supplier' ";
    //$sql = "SELECT * FROM price_request WHERE RequestDate='$RequestDate'";
    $result = $db->query($sql);
    // Add 3 days to the RequestDate
    $FinalUpdateDate = date('Y-m-d', strtotime($RequestDate . ' +3 days'));
    if ($result->num_rows <= 0) {
        $sql = "INSERT INTO price_request(SupplierId, DeliverDate,RequestDate,FinalUpdatedate, Token) VALUES ('$Supplier','$DeliverDate','$RequestDate','$FinalUpdateDate',null)";
        $db->query($sql);
        $PriceRequestId = $db->insert_id;
    } else {
        $PriceRequestId = $result->fetch_assoc()['Id'];
    }

    $sql = "INSERT INTO price_request_item( PriceRequestId, ItemId, Qty, UnitPrice, UpdatedDate) VALUES ('$PriceRequestId','$Product','$Qty', null, null)";
    $db->query($sql);
    
    
}
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>purchases/quotationRequestsManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Quotation Requests Details List</a>

        <div class="card ">
            <div class="card-header ">
                <h3 class="card-title">Add New Quotation Request</h3>
            </div>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="card-body">

                    <!--Supplier Name-->

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="Supplier">Select Supplier<span style = "color : red"> * </span></label>
                            <select class="form-control" id="Supplier" name="Supplier">
                                <option value="">Select Supplier</option>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM suppliers WHERE Status='1'";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['SupplierId'] ?>"<?= @$Supplier == $row['SupplierId'] ? 'selected' : '' ?>><?= $row['SupCompanyName'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?= @$message['Supplier'] ?></span>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="RequestDate" class="form-label fw-bold">Request Date<span style = "color: red"> * </span></label>
                            <input type="date" class="form-control" id="RequestDate" name="RequestDate" placeholder="Enter Deliver Date" value="<?= @$RequestDate ?>">
                            <span class="text-danger"><?= @$message['RequestDate'] ?></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="DeliverDate" class="form-label fw-bold">Required Date<span style = "color: red"> * </span></label>
                            <input type="date" class="form-control" id="DeliverDate" name="DeliverDate" placeholder="Enter Deliver Date" value="<?= @$DeliverDate ?>">
                            <span class="text-danger"><?= @$message['DeliverDate'] ?></span>
                        </div>
                        
                    </div>
                    <table class="table table-bordered table-striped" id="items">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>    
                            <tr class="items-row">
                                <td>
                                    <select name="Product" id="Product" class="form-control" >
                                        <option value="" disabled selected>Select Product</option>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT ProductId, ProductName FROM Products";
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value="<?= $row['ProductId'] ?>"><?= $row['ProductName'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>  
                                    <span class="text-danger"><?= @$message['Product'] ?></span>
                                </td>

                                <td>
                                    <input type="number" name="Qty" min="0" id="Qty" class="form-control">
                                    <span class="text-danger"><?= @$message['Qty'] ?></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name='action' value="add">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT pri.*,p.*,r.ProductName,s.SupCompanyName FROM price_request_item pri "
            . "LEFT JOIN price_request p ON pri.PriceRequestId=p.Id "
            . "LEFT JOIN products r ON r.ProductId=pri.ItemId "
            . "LEFT JOIN suppliers s ON s.SupplierId=P.SupplierId "
            . "WHERE PriceRequestId='$PriceRequestId'";
    $result = $db->query($sql);
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap ">
                        <tr>
                            <th>Supplier</th>
                            <th>Request Date</th>
                            <th>Required Date</th>
                            <th>Product</th>
                            <th>Quantity</th>
                        </tr>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['SupCompanyName'] ?></td>
                                    <td><?= $row['RequestDate'] ?></td>
                                    <td><?= $row['DeliverDate'] ?></td>
                                    <td><?= $row['ProductName'] ?></td>
                                    <td><?= $row['Qty'] ?></td>
                                </tr>
                                
                                <?php
                            }
                        }
                       
                        ?>
                                
                    </table>
                    
                  <a href="<?= SYS_URL ?>send_quote.php?PriceRequestId=<?= $PriceRequestId ?>" class="btn btn-info">Send Price Request</a>

                </div>
            </div>

            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <?php
}
?>


<?php
$content = ob_get_clean();
include '../layouts.php';
?>

