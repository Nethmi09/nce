
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['USERID'])) {
        header("Location:login.php");
    }
}
include_once 'init.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NCE | Dashboard</title>

        <!-- Favicon -->
        <link rel="icon" href="<?= SYS_URL ?>assets/dist/img/NCE-Logo-1.jpg" type="image/x-icon">
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
        <!-- Select2 -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
        <!-- MyStyleFile -->
        <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/newstyle.css" type="text/css"/>
           <!-- Javascript -->
        <script src="<?= SYS_URL ?>assets/dist/js/sweetalert2@11.js" type="text/javascript"></script>
        
      
       

        <style>
            .blue-text {
                color: #007bff;
            }
            .nav-treeview{
                display:none;
            }
            .nav-treeview.show{
                display:block;
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">

        <!-- wrapper -->
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="<?= SYS_URL ?>assets/dist/img/NCE-Logo-1.jpg" alt="AdminLTELogo" height="60" width="60">
            </div>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?= SYS_URL ?>dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">                   

                    <li class="nav-item">
                        <a class="nav-link" href="<?= SYS_URL ?>userProfile.php" role="button">
                            <i class="fas fa-user"></i>
                            My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="<?= SYS_URL ?>logout.php" role="button">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="" class="brand-link">
                    <img src="<?= SYS_URL ?>assets/dist/img/NCE-Logo-1.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">NCE</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        
                        <!--Logged user's name and role display-->
                        <div class="info">
                            <a href="#" class="d-block"><?= $_SESSION['FIRSTNAME'] . " " . $_SESSION['LASTNAME'] ?></a>
                            <p style="color: white"><?= $_SESSION['ROLE'] ?></p>
                        </div>
                          <!--Logged user's name and role display-->
                    </div>


                    <?php
                    $userid = $_SESSION['USERID'];
                    $db = dbConn();
                    $sql = "SELECT * FROM  user_modules um "
                            . "INNER JOIN modules m ON m.Id=um.ModuleId "
                            . "WHERE um.UserId='$userid' "
                            . "AND m.Status='1' ORDER BY Idx ASC";

                    $result = $db->query($sql);
                    $current_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    $url_without_file = preg_replace('/\/[^\/]*$/', '', $current_url);
                    ?>
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $menu_url = SYS_URL . $row['Path'] . '/' . $row['File'] . '.php';
                                    $menu_url_without_file = preg_replace('/\/[^\/]*$/', '', $menu_url);
                                    $active_class = ($url_without_file == $menu_url_without_file ) ? 'active' : '';
                                    $menu_open = ($url_without_file == $menu_url_without_file ) ? 'menu-open' : '';
                                    $module_id = $row['ModuleId'];
                                    $sql = "SELECT * FROM sub_modules WHERE module_id='$module_id' ORDER BY Idx ASC";
                                    $result_sub_module = $db->query($sql);

                                    if ($result_sub_module->num_rows > 0) {
                                        ?>
                                        <li class="nav-item <?= $menu_open ?>">
                                            <a href="#" class="nav-link <?= $active_class ?>">
                                                <i class="nav-icon  <?= $row['Icon'] ?> "></i>
                                                <p>
                                                    <?= $row['Name'] ?>  
                                                    <i class="right fas fa-angle-left"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview" style="display: <?= $display ?>;">
                                                <?php
                                                $active_class_sub = '';
                                                $url_without_file_sub = preg_replace('/\.[^\/.]+$/', '', $current_url);
                                                //Get sub menu items
                                                while ($row_sub_module = $result_sub_module->fetch_assoc()) {
                                                    $menu_url_sub = SYS_URL . $row_sub_module['Path'] . '/' . $row_sub_module['File'] . '.php';
                                                    $menu_url_without_file_sub = preg_replace('/\.[^\/.]+$/', '', $menu_url_sub);

                                                    $active_class_sub = ($url_without_file_sub == $menu_url_without_file_sub ) ? 'active' : '';
                                                    ?>
                                                    <li class="nav-item">
                                                        <a href="<?= $menu_url_sub ?>" class="nav-link <?= $active_class_sub ?>">
                                                            <i class="far fa-circle nav-icon"></i>
                                                            <p> <?= $row_sub_module['Name'] ?>  </p>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <?php
                                    } else {
                                        // Display only main menu....
                                        ?>
                                        <li class="nav-item">
                                            <a href="<?= $menu_url ?>" class="nav-link <?= $active_class ?>">
                                                <i class="nav-icon <?= $row['Icon'] ?>"></i>
                                                <p>
                                                    <?= $row['Name'] ?>                
                                                </p>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                            }
                            ?>

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
            <!-- End Main Sidebar Container -->

            <!--Breadcrumb-->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0"><?= @$link ?></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#"><?= @$breadcrumb_item ?></a></li>
                                    <li class="breadcrumb-item active"><?= @$breadcrumb_item_active ?></li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <section class="content">
                    <div class="container-fluid">
                        <?php echo $content ?>
                    </div>
                </section>
            </div>
            <!--End Breadcrumb-->

            <!--Footer-->
            <footer class="main-footer">
                <strong>Copyright &copy; 2024.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Powered By</b> Nethmi Udara.
                </div>
            </footer>
            <!--End Footer-->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- End ontrol-sidebar -->
        </div>
        <!-- ./wrapper -->

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
        <script src="<?= SYS_URL ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- Select2 -->
        <script src="<?= SYS_URL ?>assets/plugins/select2/js/select2.full.min.js"></script>
        <!-- DataTables  & Plugins -->
        <script src="<?= SYS_URL ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/jszip/jszip.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="<?= SYS_URL ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <!-- Data Table specific script -->
        <!-- AdminLTE App -->
        <script src="<?= SYS_URL ?>assets/dist/js/adminlte.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?= SYS_URL ?>assets/dist/js/demo.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?= SYS_URL ?>assets/dist/js/pages/dashboard.js"></script>
       

        <script>
            $(function () {
                $("#datatable").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["csv", "pdf", "print"]
                }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
            });

            $(document).ready(function () {
                function addItems() {
                    var tableBody = $('#items tbody');
                    var newRow = tableBody.find('.items-row').first().clone();

                    // Clear input values in the cloned row
                    newRow.find('input').val('');
                    newRow.find('.select2-container').remove();
                    newRow.find('select').removeClass('select2-hidden-accessible').removeAttr('data-select2-id tabindex aria-hidden');
                    newRow.find('select').select2();
                    // Append the cloned row to the table body
                    tableBody.append(newRow);
                }
                function removeItems(button) {
                    var row = $(button).closest('tr');
                    row.remove();
                }
                $('#addBtn').click(addItems);
                $('#items').on('click', '.removeBtn', function () {
                    removeItems(this);
                });

                //Initialize Select2 Elements
                $('.select2').select2();


            });
        </script>
    </body>
</html>
