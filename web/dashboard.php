<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['USERID'])) {
  header("Location:login.php");
}
include 'header.php';
include '../function.php';
include '../config.php';

//checkUserType("customer");
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Dashboard</h1>
</div>
<!-- Single Page Header End -->

<!-- Dashboard Design Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4 mb-4">
                <div class="col-3">
                    <div class="card">
                        <img src="assets/img/dashboardImages/onshopping.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Shopping Products</h5>
                            <p>Explore our wide range of products.</p>
                            <a href="products.php" class="btn btn-outline-dark view-button">View</a>
                            
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <img src="assets/img/dashboardImages/wishlist.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Saved Items/Wishlist</h5>
                             <p> Keep track of items you're interested in.</p>
                            <a href="wishlist.php" class="btn btn-outline-dark view-button">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <img src="assets/img/dashboardImages/checkout.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Cart & Checkout</h5>
                             <p>Manage your shopping cart and complete your purchases.</p>
                            <a href="cart.php" class="btn btn-outline-dark view-button">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <img src="assets/img/dashboardImages/track.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Track order</h5>
                             <p>Stay updated on the status of your current orders in real-time.</p>
                            <a href="track_order.php" class="btn btn-outline-dark view-button">View</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-3">
                <div class="col-3">
                    <div class="card">
                        <img src="assets/img/dashboardImages/history.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Order History</h5>
                            <p>Track your past purchases and orders.</p>
                            <a href="order_history.php" class="btn btn-outline-dark view-button">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <img src="assets/img/dashboardImages/support.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Customer Support</h5>
                            <p>Get assistance and support when needed.</p>
                            <a href="contact.php" class="btn btn-outline-dark view-button">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <img src="assets/img/dashboardImages/userProfileEdit.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">My Profile</h5>
                             <p>Manage and update your personal and profile details.</p>
                            <a href="profile.php" class="btn btn-outline-dark view-button">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <img src="assets/img/dashboardImages/rsz_payment.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Bank Payment</h5>
                             <p>Manage and update your personal and profile details.</p>
                            <a href="bankDetails.php" class="btn btn-outline-dark view-button">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard Design End -->

<?php
include 'footer.php';
ob_end_flush();
?> 


