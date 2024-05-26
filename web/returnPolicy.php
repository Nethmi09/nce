<?php
ob_start();
session_start();
include 'header.php';
include '../function.php';
include '../mail.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Return Policy</h1>
</div>
<!-- Single Page Header End -->



<?php
include 'footer.php';
ob_end_flush();
?> 