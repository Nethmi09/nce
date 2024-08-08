<?php
session_start();
include 'header.php';
include '../function.php';
include '../config.php';
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Delivery Policy</h1>
</div>
<!-- Single Page Header End -->

<!-- Shipping Policy Content Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <p><b>The delivery charge will vary by your district.</b></p>
                <br>
                <p>Delivery times are estimates and commence from the date of shipping, rather than the date of order. Delivery times are to be used as a guide only and are subject to the acceptance and approval of your order.</p>
                <br>
                <p>Unless there are exceptional circumstances, we make every effort to fulfill your order within [03] business days of the date of your order. Business day mean Monday to Friday, except holidays.</p>
                <br>
                <p>Please note we do not dispatch on [Saturdays and Sundays].</p>
                <br>
                <p>Date of delivery may vary due to carrier shipping practices, delivery location, method of delivery.</p>
            
            </div>

        </div>
    </div>
</div>

<!-- Shipping Policy Content End -->
<?php
include 'footer.php';
?>