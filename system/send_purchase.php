<?php
ob_start();
include_once 'init.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Price Request Details</title>

        <!-- Favicon -->
        <link rel="icon" href="<?= SYS_URL ?>assets/dist/img/NCE-Logo-1.jpg" type="image/x-icon">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/fontawesome-free/css/all.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- JQVMap -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/jqvmap/jqvmap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/daterangepicker/daterangepicker.css">
        <!-- summernote -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/summernote/summernote-bs4.min.css">
        <!-- MyStyleFile -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/newstyle.css" type="text/css"/>
    </head>
    <body>

        <div class="container mt-4">
            <?php
            extract($_GET);
            extract($_POST);

            $db = dbConn();
            //get the token from email and load relevent data via below query
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
            $Id = $rowsupplier['PriceRequestId'];
            ?>

            <div class="row">
                <div class="col-12">


                    <div class="card">
                        <div class="card-header bgcolor">
                            <h3 class="card-title text-white">Purchase Order Request</h3>
                        </div>

                        <div class="card-body">

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
                                        <td><?= @$qt ?></td>
                                        <td></td>
                                        <td>
                                            <?php
                                            echo number_format($total, 2);
                                            ?>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>

                                </tfooter>
                            </table>




                        </div>

                    </div>

                </div>

            </div>
        </div>


        <!-- jQuery -->
        <script src="<?= SYS_URL ?>assets/plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?= SYS_URL ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="<?= SYS_URL ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
        <script src="<?= SYS_URL ?>assets/plugins/chart.js/Chart.min.js"></script>
        <!-- Sparkline -->
        <script src="<?= SYS_URL ?>assets/plugins/sparklines/sparkline.js"></script>
        <!-- JQVMap -->
        <script src="<?= SYS_URL ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?= SYS_URL ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="<?= SYS_URL ?>assets/plugins/moment/moment.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="<?= SYS_URL ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Summernote -->
        <script src="<?= SYS_URL ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="<?= SYS_URL ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>s
        <!-- AdminLTE App -->
        <script src="<?= SYS_URL ?>assets/dist/js/adminlte.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?= SYS_URL ?>assets/dist/js/demo.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?= SYS_URL ?>assets/dist/js/pages/dashboard.js"></script>


    </body>
</html>

