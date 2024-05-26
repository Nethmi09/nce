<?php
session_start();
include 'header.php';
?>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your order has been sent.",
        showConfirmButton: false,
        timer: 1500
    });
</script>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Order Success</h1>
</div>
<!-- Single Page Header End -->

<!-- Success Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-primary">Congratulations!</h1>
                       <h2 class="text-center">Your order has been successfully sent.</h2>
                       
                    </div>
                </div>

              

            </div>
        </div>
    </div>
</div>
<!-- Success Form End -->
<?php
include 'footer.php';
?>