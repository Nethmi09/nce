<?php
ob_start();
session_start();
include 'header.php';
include '../mail.php';
include '../config.php';
extract($_GET);
if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'del') {
    $wishlist = $_SESSION['wishlist'];
    unset($wishlist[$StockId]);
    $_SESSION['wishlist'] = $wishlist;
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'empty') {
    $_SESSION['wishlist'] = array();
}
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Wishlist</h1>
</div>
<!-- Single Page Header End -->

<!-- Wishlist Content Start-->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <a href="wishlist.php?action=empty">Empty Wishlist</a>
        <div class="p-5 bg-light rounded">
            <div class="table-responsive">             

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        if(isset($_SESSION['wishlist'])){
                        foreach ($_SESSION['wishlist'] as $key => $value) {
                            ?>
                            <tr>
                                <td>
                                    <img src="<?= SYS_URL ?>assets/dist/img/uploads/products/<?= $value['ProductImage'] ?>" style="width: 60px; height: 60px;">
                                </td>
                                <td><?= $value['ProductName'] ?></td>
                                <td><?= $value['UnitPrice'] ?></td>                                                           
                                <td>
                                    <a href="wishlist.php?StockId=<?= $key ?>&action=del">Remove</a>
                                </td>
                            </tr>
                            <?php
                        }
                        }
                        ?>
                    </tbody>
                </table>
                

            </div>
        </div>

    </div>
</div>
<!--Wishlist Content End -->


<?php
include 'footer.php';
ob_end_flush();
?> 
