<?php
session_start();
include 'header.php';
include '../config.php';
include '../function.php';
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
                extract($_GET);
                extract($_POST);
                $db = dbConn();
                $sql = "SELECT o.*, c.FirstName, c.LastName, d.Name 
                        FROM orders o 
                        INNER JOIN customers c ON c.CustomerId = o.CustomerId 
                        INNER JOIN districts d ON d.Id = o.PersonalDistrictId 
                        WHERE o.OrderID = '$orderid'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                if ($result->num_rows > 0) {
                ?>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Customer Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Customer Name</strong></td>
                                        <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Order Number</strong></td>
                                        <td><?= $row['OrderNumber'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Order Date</strong></td>
                                        <td><?= $row['OrderDate'] ?></td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Billing Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Billing Name</strong></td>
                                        <td><?= ($row['PersonalName']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td><?= ($row['PersonalEmail']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Mobile</strong></td>
                                        <td><?= ($row['PersonalContactMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alternate Mobile</strong></td>
                                        <td><?= ($row['PersonalAlternateMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 1</strong></td>
                                        <td><?= ($row['PersonalAddressLine1']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 2</strong></td>
                                        <td><?= ($row['PersonalAddressLine2']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>City</strong></td>
                                        <td><?= ($row['PersonalCity']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>District</strong></td>
                                        <td><?= ($row['Name']) ?></td>
                                    </tr>
                                </table> 

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Shipping Details</u></h3>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Shipping Name</strong></td>
                                        <td><?= ($row['ShippingName']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td><?= ($row['ShippingEmail']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Mobile</strong></td>
                                        <td><?= ($row['ShippingContactMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alternate Mobile</strong></td>
                                        <td><?= ($row['ShippingAlternateMobile']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 1</strong></td>
                                        <td><?= ($row['ShippingAddressLine1']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address Line 2</strong></td>
                                        <td><?= ($row['ShippingAddressLine2']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>City</strong></td>
                                        <td><?= ($row['ShippingCity']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>District</strong></td>
                                        <td><?= ($row['Name']) ?></td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                }

                $sql = "SELECT o.OrderId, o.ProductId, o.UnitPrice, o.Quantity, p.ProductName 
                        FROM order_products o 
                        INNER JOIN products p ON p.ProductId = o.ProductId 
                        WHERE o.OrderId = '$orderid'";
                $result = $db->query($sql);
                ?>

                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Order Products</u></h3>
                                <table id="" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Unit Price</th>  
                                            <th>Ordered Qty</th>               
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
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
                            </div>
                        </div>
                    </div>
                </div>

                <?php
          
                extract($_GET);
                extract($_POST);
                $db = dbConn();
                $sql = "SELECT * FROM orders o 
                        WHERE o.OrderID = '$orderid'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                if ($result->num_rows > 0) {
                    
                }
           
                ?>
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h3><u>Order Summary</u></h3>
                                <table class="table table-bordered">
                                    
                                    <tr>
                                        <td><strong>Total Product/s Quantity</strong></td>
                                        <td><?= $row['Quantity'] ?></td>
                                    </tr>
                                     <tr>
                                        <td><strong>Grand Total</strong></td>
                                        <td><?= $row['GrandTOTAL'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Discount</strong></td>
                                        <td><?= $row['Discount'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Net Total after Discount</strong></td>
                                        <td><?= $row['NetTotal'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Coupon Discount </strong></td>
                                        <td><?= $row['CouponDiscount'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Net Total after Coupon Discount</strong></td>
                                        <td><?= $row['NetTtAftCD'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Courier Charge</strong></td>
                                        <td><?= $row['DeliveryCost'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Amount</strong></td>
                                        <td><?= $row['TotalAmount'] ?></td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
