<?php
session_start();
include 'header.php';
if (!isset($_SESSION['USERID'])) {
    header("Location:login.php");
}
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5 mt-4 mb-4"> 
    <h1 class="text-center text-white display-6">Shop Now</h1>
</div>
<!-- Single Page Header End -->

<!-- Buttons for Computer Accessories and Mobile Accessories -->
<!--<div class="container my-5"> 
    <div class="row justify-content-md-center">
        <div class="col-md-2 mb-2">
            <a href="computer_accessories.php" class="btn btn-outline-dark btn-lg btn-block" style="background-color: #8FC1E3;">Computer Accessories</a>

        </div>
        <div class="col-md-2 mb-2">
            <a href="mobile_accessories.php" class="btn btn-outline-dark btn-lg btn-block" style="background-color: #8FC1E3;">Mobile Accessories</a>

        </div>
    </div>
</div>-->


<!-- Content Design Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4 mb-4">
                <div class="col-6">
                    <div class="card">
                        <img src="assets/img/computer.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title text-center">Computer Accessories</h4>
                            <p class="text-center">Enhance your computing experience with our range of computer accessories.</p>
                            <div class="text-center">
                                <a href="computer_accessories.php" class="btn btn-outline-dark view-button">Shop Now</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <img src="assets/img/mobile.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title text-center">Mobile Accessories </h4>
                            <p class="text-center">Take your mobile device to the next level with our selection of mobile accessories.</p>
                            <div class="text-center">
                                <a href="mobile_accessories.php" class="btn btn-outline-dark view-button">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Content Design End -->

<?php
include 'footer.php';
ob_end_flush();
?>
