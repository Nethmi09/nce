<?php
ob_start();
include_once '../init.php';
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
    $sqlcheck = "SELECT * FROM price_request WHERE Token='$token'";
    $resultcheck = $db->query($sqlcheck);
    $rowcheck = $resultcheck->fetch_assoc();

    $FinalUpdateDate = $rowcheck['FinalUpdateDate'];
    $cur_date = date('Y-m-d');

    if ($cur_date > $FinalUpdateDate) {
        header("Location: expired_priceRequest.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'submit') {
        extract($_POST);
        foreach ($RequestId as $key => $RId) {
            $sql = "UPDATE price_request_item SET UnitPrice='$UnitPrice[$key]', UpdatedDate='$cur_date' WHERE Id='$RId'";
            $db->query($sql);
        }
    }

    $sql = "SELECT pri.*, p.*, r.ProductName, s.SupCompanyName, pri.Id as irid 
            FROM price_request_item pri 
            LEFT JOIN price_request p ON pri.PriceRequestId=p.Id 
            LEFT JOIN products r ON r.ProductId=pri.ItemId 
            LEFT JOIN suppliers s ON s.SupplierId=p.SupplierId 
            WHERE Token='$token'";
    $result = $db->query($sql);
    ?>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Price Request Details</h4>
        </div>
        <div class="card-body">
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Request Date</th>
                            <th>Required Date</th>
                            <th>Your Final Update Date</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['RequestDate']) ?></td>
                                    <td><?= htmlspecialchars($row['DeliverDate']) ?></td>
                                    <td><?= htmlspecialchars($row['FinalUpdateDate']) ?></td>
                                    <td><?= htmlspecialchars($row['ProductName']) ?></td>
                                    <td><?= htmlspecialchars($row['Qty']) ?></td>
                                    <td>
                                        <input type="hidden" name="RequestId[]" value="<?= htmlspecialchars($row['irid']) ?>">
                                        <input type="text" name="UnitPrice[]" class="form-control" placeholder="Enter Unit Price" value="<?= htmlspecialchars($row['UnitPrice']) ?>">
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center">No records found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <button type="submit" class="btn btn-success mt-3" name="action" value="submit">Update Prices</button>
            </form>
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
