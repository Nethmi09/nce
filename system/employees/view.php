<?php
ob_start();
include_once '../init.php';

$link = "Employee Management";
$breadcrumb_item = "Employee";
$breadcrumb_item_active = "View";

extract($_GET);
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>employees/manage.php" class="btn btn-dark mb-4"><i class="fas fa-arrow-left"></i> Back to Employees Listing Table</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employee Details</h3>
            </div>

            <div class="card-body">

                <?php
                $db = dbConn();
                $sql = "SELECT EmployeeId,FirstName, LastName, NICNumber, Email, ContactMobile, AlternateMobile, "
                        . "AddressLine1, AddressLine2, City, Image, DOB, Gender, HireDate, AccountName, AccountNumber, BankName, Branch, "
                        . "d.DesignationName, c.CivilStatusName, s.EmployeeStatusName, t.Name FROM employees e "
                        . "INNER JOIN designations d ON d.DesignationId=e.DesignationId "
                        . "INNER JOIN districts t ON t.ID=e.DistrictId "
                        . "INNER JOIN  civil_status c ON c.CivilStatusId=e.CivilStatusId "
                        . "INNER JOIN employee_status s ON s.EmployeeStatusId=e.EmployeeStatusId "
                        . "WHERE e.EmployeeId='$employeeid'";
                $result = $db->query($sql);

                // Check if the query returned a result
                if ($result && $result->num_rows > 0) {
                    // Fetch the employee details
                    $employee = $result->fetch_assoc();
                } else {
                    echo "Employee not found.";
                    exit;
                }
                ?>

                <!-- Employee Details Tables Start -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3><u>Employee Personal Details</u></h3>
                                    <table class="table table-bordered">
                                        <tbody>

                                            <tr>
                                                <th style="width: 400px;">Employee ID</th>
                                                <td><?= $employee['EmployeeId'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Employee Image</th>
                                                <td>
                                                    <?php if (!empty($employee['Image'])): ?>
                                                        <img src="../assets/dist/img/uploads/employee/<?= $employee['Image'] ?>" class="img-square elevation-2" width="100">
                                                    <?php else: ?>
                                                        <img src="../assets/dist/img/default-image.png" class="img-square elevation-2" width="100">
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">First Name</th>
                                                <td><?= $employee['FirstName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Last Name</th>
                                                <td><?= $employee['LastName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">NIC Number</th>
                                                <td><?= $employee['NICNumber'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Email</th>
                                                <td><?= $employee['Email'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Contact Mobile</th>
                                                <td><?= $employee['ContactMobile'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Alternate Mobile</th>
                                                <td><?= $employee['AlternateMobile'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Address Line 1</th>
                                                <td><?= $employee['AddressLine1'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Address Line 2</th>
                                                <td><?= $employee['AddressLine2'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">City</th>
                                                <td><?= $employee['City'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">District</th>
                                                <td><?= $employee['Name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Designation</th>
                                                <td><?= $employee['DesignationName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">DOB</th>
                                                <td><?= $employee['DOB'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Gender</th>
                                                <td><?= $employee['Gender'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Civil Status</th>
                                                <td><?= $employee['CivilStatusName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Employee Status</th>
                                                <td><?= $employee['EmployeeStatusName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Hire Date</th>
                                                <td><?= $employee['HireDate'] ?></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h3><u>Employee Bank Details</u></h3>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th style="width: 400px;">Account Name</th>
                                                <td><?= $employee['AccountName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Account Number</th>
                                                <td><?= $employee['AccountNumber'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Bank Name</th>
                                                <td><?= $employee['BankName'] ?></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 400px;">Branch</th>
                                                <td><?= $employee['Branch'] ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Employee Details Tables End -->
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean(); // Capture the output buffer content
include '../layouts.php'; // Include the layout for the page
?>
