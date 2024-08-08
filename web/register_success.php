<?php
session_start();
include 'header.php';
include '../config.php';
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
                        <h5 class="text-center">Your account has been successfully created. </h5>
                        <h5 class="text-center"> We have been sent verification email to your email address. </h5>
                        <h5 class="text-center"> Please check your email.</h5>
                        <h2 class="text-center mb-4">Your Registration Number is <?= $_SESSION['RNO'] ?> </h2>
                        <a href="resendemail.php">Resend Email</a>
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