<?php
ob_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Inventory";
$breadcrumb_item_active = "Add Stock";
?>

<div class="row">
    <div class="col-12">

        <a href="<?= SYS_URL ?>inventory/manage.php" class="btn btn-dark mb-4">View Stock Table</a>

        <!--Card Start-->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Stock</h3>
            </div>   

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                extract($_POST);
                $purchase_date = dataClean($purchase_date);
                $supplier = dataClean($supplier);

                $message = array();

//    Required validation
                if (empty($supplier)) {
                    $message['supplier'] = "Supplier is required...!";
                }
                if (empty($purchase_date)) {
                    $message['purchase_date'] = "Purchase Date is required...!";
                }
                if (empty($ProductId)) {
                    $message['ProductId'] = "Product Name is required...!";
                }
                if (empty($Quantity)) {
                    $message['Quantity'] = "Quantity is required...!";
                }
                if (empty($UnitPrice)) {
                    $message['UnitPrice'] = "Unit Price is required...!";
                }
//    Advance validation



                if (empty($message)) {

                    $db = dbConn();
                    foreach ($ProductId as $key => $value) {
                        $q = $Quantity[$key];
                        $up = $UnitPrice[$key];
                        $sql = "INSERT INTO product_stocks(ProductId, Quantity, UnitPrice, PurchaseDate, SupplierId) VALUES ('$value','$q','$up','$purchase_date','$supplier')";
                        $db->query($sql);
                    }


                    header("Location:manage.php");
                }
            }
            ?>

            <!--Form Start-->

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="card-body">

                    <!--Supplier Name-->

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="supplier">Supplier<span style = "color : red"> * </span></label>
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

                        <div class="form-group col-md-6">
                            <label for="purchase_date" class="form-label fw-bold">Purchase Date<span style = "color: red"> * </span></label>
                            <input type="date" name="purchase_date" class="form-control mb-1" id="purchase_date" value="<?= @$purchase_date ?>">
                            <span class="text-danger"><?= @$message['purchase_date'] ?></span>
                        </div>
                    </div>

                    <table  class="table table-bordered table-striped" id="products">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>                                                  
                                <th>Unit Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="products-row">
                                <td>
                                    <select name="ProductId[]" id="ProductId" value="<?= @$ProductId ?>"class="form-control" >
                                        <option value="">Select Product</option>
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
                                    <span class="text-danger"><?= @$message['ProductId'] ?></span>
                                </td>
                                <td>
                                    <input type="number" name="Quantity[]" min="0" id="Quantity" class="form-control">
                                    <span class="text-danger"><?= @$message['Quantity'] ?></span>
                                </td>
                                <td>
                                    <input type="text" name="UnitPrice[]" id="UnitPrice" class="form-control">
                                    <span class="text-danger"><?= @$message['UnitPrice'] ?></span>
                                </td>
                                <td>
                                    <button class="removeBtn" type="button" class="btn btn-primary">Remove</button>
                                    <!--<a href="">Remove</a>-->
                                </td>

                            </tr>
                        </tbody>
                    </table>

                    <br>

                    <button type="button" id="addBtn" class="btn btn-info">Add More...</button>

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

<script>

//when document is ready ($ mean - load document with jquery)
    $(document).ready(function () {
        function addProducts() {
            var tableBody = $('#products tbody');
            var newRow = tableBody.find('.products-row').first().clone(true);

            // Clear input values in the cloned row
            newRow.find('input').val('');

            // Append the cloned row to the table body
            tableBody.append(newRow);
        }
        function removeProducts(button) {
            var row = $(button).closest('tr');
            row.remove();
        }
        $('#addBtn').click(addProducts);
        $('#products').on('click', '.removeBtn', function () {
            removeProducts(this);
        });
    });

</script>