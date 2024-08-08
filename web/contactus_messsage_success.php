<?php
session_start();
include 'header.php';
include '../config.php';
?>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your message has been sent.",
        showConfirmButton: false,
        timer: 1500
    });
</script>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Success Message</h1>
</div>
<!-- Single Page Header End -->

<!-- Success Form Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h5 class="text-center"> Your message has been successfully sent. </h5>
                        <h5 class="text-center"> We will reply to your email address as soon as we can. </h5>
                        <h5 class="text-center"> Please keep an eye on your email.</h5>
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