<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';
include '../config.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Mobile Accessories</h1>
</div>
<!-- Single Page Header End -->

<!-- Mobile accessories products display and filtering options here -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">

        </div>
    </div>
</div>
<!-- End -->

<?php
include 'footer.php';
ob_end_flush();
?> 