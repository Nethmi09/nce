<?php
ob_start();
include_once '../init.php';

$link = "Customer Management";
$breadcrumb_item = "Customer";
$breadcrumb_item_active = "Manage";
?> 

<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Customer Details Table</h3>
            </div>            

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT CustomerId,RegNo, CONCAT(FirstName, ' ', LastName) AS CustomerName, Email, ContactMobile, d.Name FROM customers c INNER JOIN districts d ON d.Id=c.DistrictId";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Registration Number</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Contact Mobile</th>
                            <th>District</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['CustomerId'] ?></td>
                                    <td><?= $row['RegNo'] ?></td> 
                                    <td><?= $row['CustomerName'] ?></td> 
                                    <td><?= $row['Email'] ?></td> 
                                    <td><?= $row['ContactMobile'] ?></td> 
                                    <td><?= $row['Name'] ?></td>
                                    <td>
                                        <!--customerid is a variable. This is call in view.php etc-->
                                        <a href="<?= SYS_URL ?>customers/view.php?customerid=<?= $row['CustomerId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        
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
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>