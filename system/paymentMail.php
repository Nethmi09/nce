<?php
session_start();
ob_start();
// session_start();
include_once 'init.php';

include '../mail.php';
$link = "Purchase Management";
$breadcrumb_item1 = "Quotation";
$breadcrumb_item2 = "Manage_quote";

//$invoice = $_SESSION['INVOICE'];
//$total = $_SESSION['TOTAL'];

?>

<?php
extract($_GET);

extract($_POST);

$db = dbConn();
if ($_SERVER["REQUEST_METHOD"] == "POST" && @$action = 'pay') {
    extract($_GET);

    extract($_POST);
    $CheqNo = dataClean($CheqNo);
    // print_r($_FILES['PaymentSlip']);
    // producct image upload
    if (isset($_FILES['PaymentSlip'])) {
        // $uploads- file directory  
        $uploads = 'assets/dist/img/uploads/supplierpayments/';
        $upload_File = $uploads . basename($_FILES['PaymentSlip']['name']);
        if (move_uploaded_file($_FILES['PaymentSlip']['tmp_name'], $upload_File)) {
            $PaymentSlip = basename($_FILES['PaymentSlip']['name']);
        }
    }

    $sql_sum = "SELECT SUM(UnitPrice*QTY) AS Total FROM price_request_item WHERE PriceRequestId='$Id'";
    $resultsum = $db->query($sql_sum);
    $rowsum = $resultsum->fetch_assoc();
    $Total = $rowsum['Total'];

    $sql = "INSERT INTO sup_payments(PriceRequestId, SupplierId, TotalAmount,InvoiceNo,ChequeNo, PaymentSlip) VALUES ('$Id','$SupplierId','$Total','$invoice','$CheqNo','$PaymentSlip')";
    $db->query($sql);

    $msg = "<h1>Payment details- Namarathna Cellular and Electronics(NCE)</h1>";
    $msg .= "<a href='http://localhost/nce/system/sendPayment.php?token=$token'>Click here to view payment details</a>";
    sendEmail($email, $Supplier, "Payment Details - Namarathna Cellular and Electronics(NCE)", $msg);
}
?>



<?php
extract($_GET);
extract($_POST);

//get the token from email and load relevent data via below query

$sql = "SELECT pri.*,p.*,r.ProductName,s.SupCompanyName,pri.Id FROM price_request_item pri 
    LEFT JOIN price_request p ON pri.PriceRequestId=p.Id 
    LEFT JOIN products r ON r.ProductId=pri.ItemId 
    LEFT JOIN suppliers s ON s.SupplierId=P.SupplierId 
    WHERE Token='$token'";
$result = $db->query($sql);

// get email,firstname
$sqlsupplier = "SELECT pri.*,p.*,r.ProductName,s.SupCompanyName,s.Email,pri.Id FROM price_request_item pri 
     LEFT JOIN price_request p ON pri.PriceRequestId=p.Id  
    LEFT JOIN products r ON r.ProductId=pri.ItemId
     LEFT JOIN suppliers s ON s.SupplierId=P.SupplierId 
    WHERE Token='$token'";
$resultsupplier = $db->query($sqlsupplier);

$rowsupplier = $resultsupplier->fetch_assoc();

$Supplier = $rowsupplier['SupCompanyName'];
$email = $rowsupplier['Email'];
$Id = $rowsupplier['PriceRequestId'];
$SupplierId = $rowsupplier['SupplierId'];
?>

<div class="row">
     <div class="col-12">
        <a href="<?= SYS_URL ?>purchases/supPaymentManage.php" class="btn btn-dark mb-2"><i class="fas fa-arrow-left"></i> View list</a>
        <div class="card">
            <div class="card-header bgcolor">
                <h3 class="card-title text-white">Mange Supplier Payments</h3>
            </div>

            <div class="card-body table-responsive p-0 bgcolorbody">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" >

                    <table class="table table-hover text-nowrap">

                        <thead>
                            <tr>
                                <th>Request Date</th>
                                <th>Delivery Date</th>
                                <th>Final Update Date</th>
                                <th>Supplier</th>
                                <th>Product</th>
                                <th>Qty</th>
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
                                <td style="color:'red'">Grand Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?= @$qt ?></td>
                                <td></td>
                                <td>
                                    <?php
                                    echo number_format($total, 2);
                                    ?>
                                </td>
                                <td>

                                </td>
                                <td>
                            </tr>

                        </tfooter>
                    </table>

                    <!-- add hidden file to kept the token for future references-->
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <input type="hidden" name="name" value="<?= $Supplier ?>">
                    <input type="hidden" name="Id" value="<?= $Id ?>">



                </form>

                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                      enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="cheqno">Cheque Number</label>
                        <input type="text" name="CheqNo" id="CheqNo" class="form-control" value="<?= @$CheqNo ?>">

                        <label for="total">Total Amount</label>
                        <input type="text" name="total" id="total" class="form-control" value="<?= @$total ?>">

                        <label for="invoice">Invoice Number</label>
                        <input type="text" name="invoice" id="invoice" class="form-control" value="<?= @$invoice ?>">

                        <label for="PaymentSlip">Payment Slip</label>
                        <input type="file" name="PaymentSlip" id="PaymentSlip" class="form-control" value="<?= @$PaymentSlip ?>">



                    </div>
                    <!-- add hidden file to kept the token for future references-->
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <input type="hidden" name="name" value="<?= $Supplier ?>">
                    <input type="hidden" name="Id" value="<?= $Id ?>">
                    <input type="hidden" name="SupplierId" value="<?= $SupplierId ?>">


                    <button type="submit" action='pay' value="pay" class="btn btn-info">Send Payment Slip </button>


                </form>



            </div>

        </div>

    </div>

</div>


<?php
$content = ob_get_clean();
include 'layouts.php';
?>
