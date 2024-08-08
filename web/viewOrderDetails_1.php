<?php
session_start();
include 'header.php';
include '../config.php';
include '../function.php';

extract($_GET);
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Order Details</h1>
</div>
<!-- Single Page Header End -->

<!-- Success Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM orders r INNER JOIN order_products o ON o.OrderId=r.OrderId "
                        . "INNER JOIN products p ON p.ProductId=o.ProductId WHERE r.OrderId='$orderid'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    ?>
                    <div class="d-flex justify-content-between mb-4 mt-4">
                        <h5 class="mb-0 me-4">Order Number</h5>
                        <div class="">
                            <p class="mb-0"></p>
                        </div>
                    </div>
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['ProductName'] ?></td> 
                                    <td><?= $row['UnitPrice'] ?></td> 
                                    <td><?= $row['Quantity'] ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>

                </table>

                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">


                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<?php
include 'footer.php';
?>