<?php
ob_start();
session_start();
include 'header.php';
include '../mail.php';
include '../config.php';

?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Cart</h1>
</div>
<!-- Single Page Header End -->

<!-- Cart Page Content-->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <a href="cart.php?action=empty">Empty Cart</a>
        <div class="p-5 bg-light rounded">
            <div class="table-responsive">             


            </div>
        </div>


        <!-- Cart Total Card -->
        <div class="row justify-content-end mt-4">
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Order <span class="fw-normal">Summary</span></h1>
                       
                        

                    </div>
                    
                    <a class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" href="checkout.php">Proceed Checkout</a>
                </div>
            </div>
        </div>
        <!--Cart Total Card End -->
    </div>
</div>
<!--Cart Page Content End -->


<?php
include 'footer.php';
ob_end_flush();
?> 

