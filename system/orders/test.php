<?php
ob_start();
session_start();
include_once 'init.php';
$invoice =$_SESSION['INVOICE'];
?>
<link href="../assets/dist/css/mystylecss.css" rel="stylesheet" type="text/css" />
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rajawaka Minerals</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/jqvmap/jqvmap.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/summernote/summernote-bs4.min.css">

   <!-- my system style -->
  <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/system.css">

   <!-- <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/mysystem.css"> -->

   <!-- confirm password -->
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script> -->
</head>


<?php


// extract($_POST);


// $db = dbConn();
// if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
//     extract($_POST); 
     
//     if (isset($_POST['reject'])) { 
//         // Update order status to rejected (status id 8) 
//         $updateSql = "UPDATE orders SET order_status = 7 WHERE id = '$OrderId'"; 
//         if ($db->query($updateSql)) { 
//             echo "<script>alert('Order has been rejected.');</script>"; 
//         } else { 
//             echo "<script>alert('Failed to update order status. Please try again.');</script>"; 
//         } 
//     } elseif (isset($_POST['accept'])) { 
//         // Update order status to accepted (status id 7) 
//         $updateSql = "UPDATE orders SET order_status = 8 WHERE id = '$OrderId'"; 
//         if ($db->query($updateSql)) { 
//             echo "<script>alert('Order has been accepted.');</script>"; 
//         } else { 
//             echo "<script>alert('Failed to update order status. Please try again.');</script>"; 
//         } 
//     } }?>


<div class="row">
    <?php
    extract($_GET);
    extract($_POST);

    $db = dbConn();
    //get the token from email and load relevent data via below query
    $sql = "SELECT pri.*,p.*,m.material,s.FirstName,s.CompanyName,pri.Id as irid FROM price_request_item pri 
    LEFT JOIN price_request p ON pri.PriceRequestId=p.Id LEFT JOIN materials m ON m.Id=pri.ItemId 
    LEFT JOIN supplier s ON s.SupplierId=P.SupplierId WHERE Token='$token'";
    $result = $db->query($sql);

    $sqlsupplier = "SELECT pri.*,p.*,m.material,s.FirstName,s.CompanyName,s.Email,pri.Id as irid FROM price_request_item pri 
    LEFT JOIN price_request p ON pri.PriceRequestId=p.Id LEFT JOIN materials m ON m.Id=pri.ItemId 
    LEFT JOIN supplier s ON s.SupplierId=P.SupplierId WHERE Token='$token'";
    $resultsupplier = $db->query($sqlsupplier);

    $rowsupplier=$resultsupplier->fetch_assoc();

    $Supplier=$rowsupplier['FirstName'];
    $email=$rowsupplier['Email'];
    $Id=$rowsupplier['PriceRequestId'];


    $sqlpay= "SELECT s.* FROM `sup_payments` s INNER JOIN price_request p ON p.Id=s.PriceRequestId WHERE p.Token='$token'";
    $resultpay = $db->query($sqlpay);
    $rowpay= $resultpay->fetch_assoc(); 
    $pay=$rowpay['PaymentSlip']; 
    $ChequeNo=$rowpay['ChequeNo'];  
    // $InvoiceNo=$rowpay['InvoiceNo'];    


    ?>

    <div class="row">
        <div class="col-12">


            <div class="card">
                <div class="card-header bgcolor">
                    <h3 class="card-title text-white">Payment Details</h3>
                </div>

                <div class="card-body table-responsive p-0 bgcolorbody">

                    <table class="table table-hover text-nowrap">

                        <thead>
                            <tr>
                                <th>Request Date</th>
                                <th>Delivery Date</th>
                                <th>Final Update Date</th>
                                <th>Supplier</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total Amount</th>



                            </tr>
                        </thead>

                        <tbody>
                            <?php
                          

                            if ($result->num_rows > 0) {
                                $qt=0;
                                $grand=0;
                                $total=0;
                                $noofproducts=0;
                                while ($row = $result->fetch_assoc()) {
                                   
                                    ?>
                            <tr>
                                <td><?= $row['RequestDate'] ?></td>
                                <td><?= $row['DeliverDate'] ?></td>
                                <td><?= $row['FinalUpdateDate'] ?></td>
                                <td><?= $row['CompanyName'] ?></td>
                                <td><?= $row['material'] ?></td>
                                <td><?= $row['Qty'] ?></td>
                                <td><?= $row['UnitPrice'] ?></td>
                                <td> <?php 
                                       
                                         $amt=$row['Qty'] * $row['UnitPrice'];
                                            echo number_format($amt,2) ; 
                                            ?>
                                </td>

                                <?php
                                $qt += $row['Qty'];
                                $total+=$amt; 
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
                                            echo number_format($total,2) ; 
                                            ?>
                                </td>
                                <td>

                                </td>
                                <!-- <td><a href="<?= SYS_URL ?>quotation/view_quote1.php?token=<?= $row['Token'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td> -->
                                <td>
                            </tr>
                            <tr></tr>
                            <tr></tr>

                            <tr>
                                <td><?= $rowpay['InvoiceNo'] ?> </td>
                            </tr>

                            <tr>
                                <td><?= $rowpay['ChequeNo'] ?> </td>
                            </tr>
                            <tr>
                                <td>Rs. <?= $rowpay['TotalAmount'] ?> </td>
                            </tr>

                            <tr>
                                <td>
                                    <?php
                                            

                                if (!empty($pay)): ?>
                                    <img src="<?= SYS_URL ?>assets/dist/img/uploads/supplierpayments/<?= $rowpay['PaymentSlip'] ?>"
                                        class="img-square elevation-2" width="500" height="500">
                                    <?php else: ?>
                                    <img src="<?= SYS_URL ?>assets/dist/img/default-image.png"
                                        class="img-square elevation-2" width="500">
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>

                            </tr>

                        </tfooter>
                    </table>

                    <form action="view_payment_slip.php" method="POST">
                        <input type='hidden' name='token' value='<?= $token ?>'>
                        <button type="submit" name="reject" value="reject" class="btn btn-danger">Reject</button>
                        <button type="submit" name="accept" value="accept" class="btn btn-success">Accept</button>
                    </form>




                </div>

            </div>

        </div>

    </div>


    <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets/dist/js/pages/dashboard.js"></script>
</body>
</html>