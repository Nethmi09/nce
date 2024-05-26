<?php
session_start();
include 'header.php';
?>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your registration been saved.",
        showConfirmButton: false,
        timer: 1500
    });
</script>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Register Success</h1>
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
                       <h2 class="text-center">Your account has been successfully created.</h2>
                        <p class="text-center mb-4">Your Registration Number is <?= $_SESSION['RNO'] ?> </p>
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