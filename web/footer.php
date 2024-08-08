<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
    <div class="container py-5">

        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Why People Like us!</h4>
                    <p class="mb-5">Discover a world of convenience and innovation with our wide range of mobile and computer accessories. From stylish cases to powerful chargers, we offer the perfect solution for every need. Shop now and experience the difference!</p>


                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Shop Info</h4>
                    <a class="btn-link" href="about.php">About Us</a>
                    <a class="btn-link" href="contact.php">Contact Us</a>
                    <a class="btn-link" href="privacyPolicy.php">Privacy Policy</a>
                    <a class="btn-link" href="termsAndCond.php">Terms & Condition</a>
                    <a class="btn-link" href="deliveryPolicy.php">Delivery Policy</a>

                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Informations</h4>
                    <a class="btn-link" href="dashboard.php">User Dashboard</a>                
                   <a class="btn-link" href="profile.php">My Account</a>
                         
                    <a class="btn-link" href="cart.php">Shopping Cart</a>
                    <a class="btn-link" href="wishlist.php">Wishlist</a>
                    <a class="btn-link" href="order_history.php">Order History</a>

                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Contact</h4>
                    <p class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i>358/A, Henegama road, Radawana</p>
                    <p class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i>namarathnagroup@gmail.com</p>
                    <p class="me-3"><i class="fas fa-phone-alt me-2 text-secondary"></i>0712056162</p>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i></a>2024, All right reserved.</span>
            </div>
            <div class="col-md-6 my-auto text-center text-md-end text-white">
                <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                Designed By Nethmi Udara
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->



<!-- Back to Top -->
<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   


<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/lib/easing/easing.min.js"></script>
<script src="assets/lib/waypoints/waypoints.min.js"></script>
<script src="assets/lib/lightbox/js/lightbox.min.js"></script>
<script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="assets/js/main.js"></script>

<script>
    
    $('.brand-carousel').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });

</script>

</body>

</html>

<?php
ob_end_flush();
?>