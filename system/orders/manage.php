<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="date" name="from_date">
            <input type="date" name="to_date">
            <input type="text" name="customer_name" placeholder="Enter Customer Name">
            <input type="text" name="order_number" placeholder="Enter Order Number">
            <button type="submit">Filter</button>
        </form>
        <br>
        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Order Details Table</h3>
            </div>
            <div class="card-body">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);

                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " orders.OrderDate BETWEEN '$from_date' AND '$to_date' AND";
                    }

                    if (!empty($order_number)) {
                        $where .= " orders.OrderNumber='$order_number' AND";
                    }

                    if (!empty($where)) {
                        $where = substr($where, 0, -3);
                        $where = " WHERE $where";
                    }
                }

                $db = dbConn();
                $sql = "SELECT o.*,c.FirstName,c.LastName FROM orders o INNER JOIN customers c ON c.CustomerId=o.CustomerId";
                $result = $db->query($sql);
                ?>
                <!--Table Start-->

                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>  
                            <th>Order Number</th>
                            <th>Order Date</th>                            
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['OrderId'] ?></td>
                                    <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td> 
                                    <td><?= $row['OrderNumber'] ?></td> 
                                    <td><?= $row['OrderDate'] ?></td>

                                    <td>
                                        <a href="<?= SYS_URL ?>orders/view.php?orderid=<?= $row['OrderId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>orders/edit.php?orderid=<?= $row['OrderId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="<?= SYS_URL ?>orders/delete.php?orderid=<?= $row['OrderId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <!--Table End-->

            </div>

        </div>

    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>