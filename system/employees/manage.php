<?php
ob_start();
include_once '../init.php';

$link = "Employee Management";
$breadcrumb_item = "Employee";
$breadcrumb_item_active = "Manage";
?> 

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>employees/add.php" class="btn btn-dark mb-4" ><i class="fas fa-plus-circle"></i> Add New Employee</a>
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Employee Details Table</h3>
            </div>            

            <div class="card-body">
                <?php
                $db = dbConn();
                $sql = "SELECT EmployeeId,CONCAT(FirstName, ' ', LastName) AS EmployeeName, "
                        . "d.DesignationName, s.EmployeeStatusName, ContactMobile, HireDate FROM employees e "
                        . "INNER JOIN designations d ON d.DesignationId=e.DesignationId "
                        . "INNER JOIN employee_status s ON s.EmployeeStatusId=e.EmployeeStatusId";
                $result = $db->query($sql);
                ?>

                <!--Table Start-->
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee Name</th>
                            <th>Contact Mobile</th>
                            <th>Designation</th>
                            <th>Hire Date</th>
                            <th>Employee Status</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $statusClass = $row['EmployeeStatusName'] === 'Working' ? 'text-success' : 'text-danger';
                                ?>
                                <tr>
                                    <td><?= $row['EmployeeId'] ?></td>
                                    <td><?= $row['EmployeeName'] ?></td> 
                                    <td><?= $row['ContactMobile'] ?></td> 
                                    <td><?= $row['DesignationName'] ?></td> 
                                    <td><?= $row['HireDate'] ?></td> 
                                    <td class="<?= $statusClass ?>" style="font-weight: bold;"><?= $row['EmployeeStatusName'] ?></td> 
                                    <td>
                                        <a href="<?= SYS_URL ?>employees/view.php?employeeid=<?= $row['EmployeeId'] ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="<?= SYS_URL ?>employees/edit.php?employeeid=<?= $row['EmployeeId'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
<!--                                        <a href="<?= SYS_URL ?>employees/delete.php?employeeid=<?= $row['EmployeeId'] ?>" class="btn btn-danger" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>-->
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