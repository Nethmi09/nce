<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<?php
if (!isset($_SESSION['CustomerId'])) {
    header("Location:../signin/signin.php");
}
?>

<?php
//extract($_POST);
//if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'orderhistory') {
//    extract($_POST);
////    $CustomerId = $_GET['CustomerId'];
//    echo $CustomerId;
//    echo $sql = "SELECT * FROM tbl_orders  WHERE customerId=$CustomerId";
//    $db = dbConn();
//    $results = $db->query($sql);
//}
?>
<main>
    <section id="acv" class="section">
        <div class="section-title" >
            <h2 class="">Personal and Payments Details</h2>
        </div>
    </section>

    <form action="customerDashboard.php" method="POST">

        <input type="hidden" name="CustomerId" value="<?= $_SESSION['CustomerId'] ?>">
        <button type="submit" name="action" value="updateprofile" class="btn btn-primary btn-lg btn-block">Back Dashboard</button>

    </form>




    <section>
        <form method="post"  action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <div class="row g-3">
                <div class="col-sm-4 text-center" style="margin-left: 120px">
                    <label></label>
                    <input type="text" name="orderID" value="<?= @$orderID ?>" class="form-control" placeholder="Enter Order ID">
                </div>
                <div class="col-sm">
                    <?php
//                $db = dbConn();
//                $sql = "SELECT DISTINCT Model FROM vehicle";
//                $result = $db->query($sql);
                    ?>
                    <label></label>
                    <select name="payementmethod" class="form-control">
                        <option value="">--Payment Method--</option>
                        <option value="Bank_transfer">Bank transfer</option>
                        <option value="Cashondelivery">Cashondelivery</option>

                    </select>
                </div>
                <div class="col-sm">
                    <label> From</label>
                    <input type="date" class="form-control" name="from" placeholder="Enter From Date" >
                </div>
                <div class="col-sm">
                    <label> To</label>
                    <input type="date" class="form-control" name="to" placeholder="Enter To Date" >
                </div>
                <div class="col-sm">

                    <input type="hidden" name="CustomerId " value="<?= $_SESSION['CustomerId'] ?>">
                    <label></label>
                    <button type="submit" class="btn btn-warning">Search</button>
                </div>
            </div>
        </form>

        <?php
        $where = null;
        extract($_POST);
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!empty($orderID)) {
                $where .= " orderID='$orderID' AND";
            }
            if (!empty($payementmethod)) {
                $where .= " payementmethod='$payementmethod' AND";
            }
            if (!empty($from) && empty($to)) {
                $where .= " adddate  = '$from' AND";
            }
            if (empty($from) && !empty($to)) {
                $where .= " adddate  = '$to' AND";
            }
            if (!empty($from) && !empty($to)) {
                $where .= " adddate  BETWEEN '$from' AND '$to' AND";
            }
        }

//        if (!empty($where)) {
//            $where = substr($where, 0, -3);
//            $where = " WHERE $where";
//        }


        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }



//        extract($_POST);
//        if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
        extract($_POST);
//    $CustomerId = $_GET['CustomerId'];
        $CustomerId = $_SESSION['CustomerId'];
        $sql = "SELECT * FROM tbl_orders  WHERE customerId=$CustomerId $where ORDER BY tbl_orders.adddate DESC ";
        $db = dbConn();
        $results = $db->query($sql);

//        }
        ?>

        <div class="container">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Order Id</th>
                        <th>Purchased Date</th>

                        <th>Total Amount</th>
                        <th>Total Quantity</th>
                        <th>Total Discount</th>
                        <th>Payment method</th>
                        <th>Payment Status</th>
                        <th>View Order</th>
                        <th>Order Status</th>

                        <th>Cancellation availability</th>
<!--                            <th>Cumalative Total</th>-->




                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($results->num_rows > 0) {
                        $i = 1;
                        while ($row = $results->fetch_assoc()) {
                            ?>
                            <tr>

                                <td><?= $i ?></td>
                                <td><?= $row['orderID'] ?></td>
                                <td><?= $row['adddate'] ?></td>

                                <td ><?= number_format($row['grandtotal'], 2) ?></td>
                                <td ><?= $row['totalquantity'] ?> Products</td>
                                <td><?= number_format($row['totaldiscount'], 2) ?></td>
                                <td><?= $row['payementmethod'] ?></td>
                                <td>Paid not paid</td>


                                <td >
                                    <form action="vieworder.php" method="POST">
                                        <input type="hidden" name="orderID" value="<?= $row['orderID'] ?>">
                                        <button class="form-control btn btn-outline-primary btn-sm " style="border-color: blue" type="submit" name="action" value="vieworder"><strong> View Order </strong></button>
                                    </form>

                                </td>



                                <td > <?php
                                    if
                                    ($row['orderstatus'] == 0) {
                                        ?>
                                        <div class="p-2 text-center" style="background-color: #ff6666;"><strong>Not Proccessed</strong> </div> <?php
                                    } else if ($row['orderstatus'] == 1) {
                                        ?>
                                        <div class="p-2 text-center" style="background-color: #ffff99"> <strong>Proccessing</strong></div> <?php
                                    } else if ($row['orderstatus'] == 2) {
                                        ?>
                                        <div class="p-2 text-center" style="background-color: #9999ff"> <strong>Packed</strong></div> <?php
                                    } else if ($row['orderstatus'] == 3) {
                                        ?>
                                        <div class="p-2 text-center" style="background-color: #99ffff"> <strong>Handed to deliver</strong></div> <?php
                                    } else if ($row['orderstatus'] == 4) {
                                        ?>
                                        <div class="p-2 text-center" style="background-color: #009966"><strong>Delivered</strong>  </div> <?php
                                    } else if ($row['orderstatus'] == 5) {
                                        ?>
                                        <div class="p-2 text-center" style="background-color: #cc0033"> <strong>Cancelled</strong> </div> <?php
                                    }
                                    ?></td> 




                                <?php
                                $currentdate = date('Ymd');
                                $timestamp = strtotime($currentdate);
                                $currentdatenumber = date('Ymd', $timestamp);

                                $orderdate = $row ['adddate'];
                                $timestamp = strtotime($orderdate);
                                $orderdatenumber = date('Ymd', $timestamp);

                                if (($currentdatenumber - $orderdatenumber) < 10) {
                                    echo "Applicable";
                                } else {
                                    echo 'Not Applicable';
                                }
                                ?>



                                <td><?php

                                    if ($row['orderstatus'] == 0) {
                                        ?>
                                        <form action="orderstatus.php" method="POST" >
                                            <input type='hidden' name='productid' value='<?= $row['productid'] ?>'>
                                            <input type='hidden' name='orderID' value='<?= $row['orderID'] ?>'>
                                            <input type='hidden' name='qty' value='<?= $row['qty'] ?>'>
                                            <input type='hidden' name='customerid' value='<?= $_SESSION['CustomerId'] ?>'>
                                            <button name="action" class="btn btn-outline-danger " value="view"><strong>Cancel </strong> </button>
                                        </form><?php
                                    } else {
                                        echo "Time Exceeded";
                                    }
                                    ?>


                                </td>
     

                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
                <tr>
                    <td colspan="10">Total of the delivered Orders</td> 
                    <td >Rs.<?= number_format($total, 2) ?></td>
                </tr>

            </table>  
        </div>
        <form action="customerDashboard.php" method="POST">
            <div class="row text-end">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <input type="hidden" name="CustomerId" value="<?= $_SESSION['CustomerId'] ?>">
                    <button type="submit" name="action" value="updateprofile" class="btn btn-primary ">Back Dashboard</button>
                </div>
            </div>
        </form>
    </section>

</main>
<?php include '../footer.php'; ?> 
