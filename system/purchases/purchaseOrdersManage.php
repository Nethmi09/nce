<?php
ob_start();
include_once '../init.php';

$link = "Purchase Management";
$breadcrumb_item = "Purchase";
$breadcrumb_item_active = "Manage";
?> 
<div class="row">
    <div class="col-12">

        <div class="card mt">
            <div class="card-header">
                <h3 class="card-title">Add Purchase Orders</h3>
            </div>
            <div class="card-body">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);

                    if (!empty($date_from) && !empty($date_to)) {
                        $where .= "DeliverDate BETWEEN '$date_from' AND '$date_to'AND";
                    }


                    if (!empty($CompanyName)) {
                        $where .= "SupCompanyName= '$SupCompanyName' AND";
                    }

                    if (!empty($where)) {
                        $where = substr($where, 0, -3);
                        $where = "WHERE " . $where;
                    }
                }
                ?>
                <!--Table Start-->

                <table id="" class="table table-bordered table-striped">
                    <?php
                    $db = dbConn();
                    $sql = "SELECT p.DeliverDate,p.RequestDate,p.FinalUpdateDate,s.SupCompanyName,s.Email,p.Token FROM price_request p LEFT JOIN suppliers s ON p.SupplierId=S.SupplierId";
                    $result = $db->query($sql);
                    ?>
                    <thead>
                        <tr>

                            <th>Supplier Name</th>
                            <th>Supplier Email</th>
                            <th>Request Date</th>
                            <th>Received Date</th>
                            <th>Final Update Date</th>
                            <th>Token</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['SupCompanyName'] ?></td>
                                    <td><?= $row['Email'] ?></td>
                                    <td><?= $row['RequestDate'] ?></td>
                                    <td><?= $row['DeliverDate'] ?></td>
                                    <td><?= $row['FinalUpdateDate'] ?></td>
                                    <td><?= $row['Token'] ?></td>
                                    <td><a href="<?= SYS_URL ?>purchaseOrdersAdd.php?token=<?= $row['Token'] ?>" class="btn btn-info">Add</a></td>
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
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>