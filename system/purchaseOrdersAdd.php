<?php
ob_start();
include_once 'init.php';
include '../mail.php';

$link = "Purchase Management";
$breadcrumb_item1 = "Purchase Orders";
$breadcrumb_item2 = "Add";
?>

<?php
extract($_GET);
extract($_POST);

$db = dbConn();
if ($_SERVER["REQUEST_METHOD"] == "POST" && @$action = 'submit') {
    extract($_POST);

    $msg = "<h1>Purchase Order - Namarathna Cellular and Electronics(NCE)</h1>";
    $msg .= "<a href='http://localhost/nce/system/send_purchase.php?token=$token'>Click here to view purchase order.</a>";
    sendEmail($email, $name, "Purchase Order - Namarathna Cellular and Electronics(NCE)", $msg);
}

//Get the token from email and load relevent data via below query
$sql = "SELECT pri.*,p.*,r.ProductName,s.SupCompanyName,pri.Id FROM price_request_item pri 
    LEFT JOIN price_request p ON pri.PriceRequestId=p.Id 
    LEFT JOIN products r ON r.ProductId=pri.ItemId 
    LEFT JOIN suppliers s ON s.SupplierId=P.SupplierId 
    WHERE Token='$token'";
$result = $db->query($sql);

$sqlsupplier = "SELECT pri.*,p.*,r.ProductName,s.SupCompanyName,s.Email,pri.Id FROM price_request_item pri 
    LEFT JOIN price_request p ON pri.PriceRequestId=p.Id 
    LEFT JOIN products r ON r.ProductId=pri.ItemId 
    LEFT JOIN suppliers s ON s.SupplierId=P.SupplierId  
    WHERE Token='$token'";
$resultsupplier = $db->query($sqlsupplier);

$rowsupplier = $resultsupplier->fetch_assoc();

$email = $rowsupplier['Email'];
$Supplier=$rowsupplier['SupCompanyName'];
$Id = $rowsupplier['PriceRequestId'];
?>

<div class="row">
    <div class="col-12">

        <a href="<?= SYS_URL ?>purchases/purchaseOrdersManage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Purchase Orders Details List</a>
        <div class="card">
            <div class="card-header bgcolor">
                <h3 class="card-title text-white">Mange Purchase Orders</h3>
            </div>

            <div class="card-body table-responsive p-0 bgcolorbody">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                    <table class="table table-hover text-nowrap">

                        <thead>
                            <tr>
                                <th>Request Date</th>
                                <th>Delivery Date</th>
                                <th>Final Update Date</th>
                                <th>Supplier</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Amount</th>


                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $qt = 0;
                                $grand = 0;
                                $total = 0;
                                $noofproducts = 0;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $row['RequestDate'] ?></td>
                                        <td><?= $row['DeliverDate'] ?></td>
                                        <td><?= $row['FinalUpdateDate'] ?></td>
                                        <td><?= $row['SupCompanyName'] ?></td>
                                        <td><?= $row['ProductName'] ?></td>
                                        <td><?= $row['Qty'] ?></td>
                                        <td><?= $row['UnitPrice'] ?></td>
                                        <td> <?php
                                            $amt = $row['Qty'] * $row['UnitPrice'];
                                            echo number_format($amt, 2);
                                            ?>
                                        </td>

                                        <?php
                                        $qt += $row['Qty'];
                                        $total += $amt;
                                        ?>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>
                        </tbody>

                        <tfooter>
                            <tr>
                                <td style="color: blue"><b>Grand Total</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                         <!-- <td><?= @$qt ?></td>-->
                                <td></td>
                                <td></td>
                                <td>
                                    <?php
                                    echo number_format($total, 2);
                                    ?>
                                </td>

                            </tr>

                        </tfooter>
                    </table>

                    <!-- add hidden file to kept the token for future references-->
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <input type="hidden" name="name" value="<?= $Supplier ?>">
                    <button type="submit" name='action' value="submit" class="btn btn-info">Place Order </button>

                </form>


            </div>

        </div>

    </div>

</div>


<?php
$content = ob_get_clean();
include 'layouts.php';
?>
