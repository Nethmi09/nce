<?php
session_start();
include 'header.php';
include '../function.php';
include '../config.php';
?> 
<style>
    /* Styles for .product-card */
    .product-card {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);   /* Adds a shadow around the card */
        text-align: center;                      /* Centers the text inside the card */
        display: flex;                           /* Applies the flexbox layout model to the card, making it a flex container */
        flex-direction: column;                  /* Stacks the child elements of the card vertically */
        justify-content: space-between;          /* Distributes space between child elements, placing the first element at the start and the last element at the end. */
        position: relative;                      /* Positions child elements relative to the product card */
        height: 100%;
        max-width: 350px;                        /* Fixed width for cards */
        margin: 0 auto;                         /* Centers the card horizontally */
    }

    .product-card img {
        width: 100%;                             /* Fixed width for images */
        height: 250px;                           /* Fixed height for images */
    }

    .product-card h3 {
        font-size: 1.4rem;                       /* Sets the font size to 1.5 rem units (relative to the root element's font size). */
        margin-bottom: 10px;                     /* Adds a 10px bottom margin to create space below the heading */
    }

    .product-card p {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 15px;
    }

    .availability {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: black;
        color: white;
        padding: 5px 10px;
        font-size: 0.9rem;
        border-radius: 3px;
    }

    .product-card button {
        background-color: #31708E;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        cursor: pointer;
        border-radius: 5px;
        width: 80%;                             /* Make buttons width */
        margin-bottom: 10px;                    /* Add spacing between buttons */
    }

    .product-card button[disabled] {
        background-color: grey;
        cursor: not-allowed;
    }

    .product-card button:hover:not([disabled]) {
        background-color: #03353b;
    }

</style>

<!-- Hero Start -->
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3">Make Your Smart World!</h4>
                <h1 class="mb-5 display-3 text-primary">Namarathna Cellular and Electronics</h1>
                <div class="position-relative mx-auto">
                    <a href="products.php" class="btn btn-outline-dark view-button">Shop Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active rounded">
                            <img src="assets/img/computer.png" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                        </div>
                        <div class="carousel-item rounded">
                            <img src="assets/img/mobile.png" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- Products Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-4">
                <div class="col-lg-4 text-start">
                    <h1>Our Products</h1>
                </div>
                <div class="col-lg-8 text-end">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5">
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                <span class="text-dark" style="width: 130px;">All Products</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                <span class="text-dark" style="width: 130px;">Computer Accessories</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                <span class="text-dark" style="width: 130px;">Mobile Accessories</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <!-- All Products Tab -->
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT product_stocks.StockId, products.ProductName, products.ProductImage, product_stocks.Quantity, product_stocks.UnitPrice, product_stocks.IssuedQuantity, categories.CategoryName 
                                FROM product_stocks 
                                INNER JOIN products ON (products.ProductId = product_stocks.ProductId) 
                                INNER JOIN categories ON (categories.CategoryId = products.CategoryId) 
                                GROUP BY products.ProductId, product_stocks.UnitPrice 
                                LIMIT 6"; // Limiting the query to 6 products
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $availableQuantity = $row['Quantity'] - $row['IssuedQuantity'];
                                ?>
                                <div class="col-md-4">
                                    <div class="product-card border p-3 rounded">
                                        <img src="<?= SYS_URL ?>assets/dist/img/uploads/products/<?= $row['ProductImage'] ?>" class="img-fluid" alt="<?= $row['ProductName'] ?>">
                                        <h3><?= $row['ProductName'] ?></h3>
                                        <p>LKR <?= number_format($row['UnitPrice'], 2) ?></p>
                                        <?php if ($availableQuantity > 0) { ?>
                                            <div class="availability"><?= $availableQuantity ?> stocks available</div>
                                        <?php } else { ?>
                                            <div class="availability">Out of stock</div>
                                        <?php } ?>
                                        <form method="post" action="shopping_cart.php">
                                            <input type="hidden" name="StockId" value="<?= $row['StockId'] ?>">
                                            <button type="submit" name="operate" value="add_cart" <?= $availableQuantity <= 0 ? 'disabled' : '' ?>>Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="text-center mt-4">
                        <a href="products.php" class="btn btn-outline-info text-primary bg-white" style="padding: 12px 24px; font-size: 1.2rem;">See More...</a>
                    </div>
                </div>

                <!-- Computer Accessories Tab -->
                <div id="tab-2" class="tab-pane fade p-0">
                    <div class="row g-4">
                        <?php
                        $sql = "SELECT product_stocks.StockId, products.ProductName, products.ProductImage, product_stocks.Quantity, product_stocks.UnitPrice, product_stocks.IssuedQuantity, categories.CategoryName 
                                FROM product_stocks 
                                INNER JOIN products ON (products.ProductId = product_stocks.ProductId) 
                                INNER JOIN categories ON (categories.CategoryId = products.CategoryId) 
                                WHERE products.MainCategoryId = 1  
                                GROUP BY products.ProductId, product_stocks.UnitPrice 
                                LIMIT 6";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $availableQuantity = $row['Quantity'] - $row['IssuedQuantity'];
                                ?>
                                <div class="col-md-4">
                                    <div class="product-card border p-3 rounded">
                                        <img src="<?= SYS_URL ?>assets/dist/img/uploads/products/<?= $row['ProductImage'] ?>" class="img-fluid" alt="<?= $row['ProductName'] ?>">
                                        <h3><?= $row['ProductName'] ?></h3>
                                        <p>LKR <?= number_format($row['UnitPrice'], 2) ?></p>
                                        <?php if ($availableQuantity > 0) { ?>
                                            <div class="availability"><?= $availableQuantity ?> stocks available</div>
                                        <?php } else { ?>
                                            <div class="availability">Out of stock</div>
                                        <?php } ?>
                                        <form method="post" action="shopping_cart.php">
                                            <input type="hidden" name="StockId" value="<?= $row['StockId'] ?>">
                                            <button type="submit" name="operate" value="add_cart" <?= $availableQuantity <= 0 ? 'disabled' : '' ?>>Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="text-center mt-4">
                        <a href="products.php" class="btn btn-outline-info text-primary bg-white" style="padding: 12px 24px; font-size: 1.2rem;">See More...</a>
                    </div>
                </div>

                <!-- Mobile Accessories Tab -->
                <div id="tab-3" class="tab-pane fade p-0">
                    <div class="row g-4">
                        <?php
                        $sql = "SELECT product_stocks.StockId, products.ProductName, products.ProductImage, product_stocks.Quantity, product_stocks.UnitPrice, product_stocks.IssuedQuantity, categories.CategoryName 
                                FROM product_stocks 
                                INNER JOIN products ON (products.ProductId = product_stocks.ProductId) 
                                INNER JOIN categories ON (categories.CategoryId = products.CategoryId) 
                                WHERE products.MainCategoryId = 2  
                                GROUP BY products.ProductId, product_stocks.UnitPrice 
                                LIMIT 6";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $availableQuantity = $row['Quantity'] - $row['IssuedQuantity'];
                                ?>
                                <div class="col-md-4">
                                    <div class="product-card border p-3 rounded">
                                        <img src="<?= SYS_URL ?>assets/dist/img/uploads/products/<?= $row['ProductImage'] ?>" class="img-fluid" alt="<?= $row['ProductName'] ?>">
                                        <h3><?= $row['ProductName'] ?></h3>
                                        <p>LKR <?= number_format($row['UnitPrice'], 2) ?></p>
                                        <?php if ($availableQuantity > 0) { ?>
                                            <div class="availability"><?= $availableQuantity ?> stocks available</div>
                                        <?php } else { ?>
                                            <div class="availability">Out of stock</div>
                                        <?php } ?>
                                        <form method="post" action="shopping_cart.php">
                                            <input type="hidden" name="StockId" value="<?= $row['StockId'] ?>">
                                            <button type="submit" name="operate" value="add_cart" <?= $availableQuantity <= 0 ? 'disabled' : '' ?>>Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="text-center mt-4">
                        <a href="products.php" class="btn btn-outline-info text-primary bg-white" style="padding: 12px 24px; font-size: 1.2rem;">See More...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Products Shop End-->



<!-- Featurs Section Start -->
<div class="container-fluid featurs py-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fas fa-car-side fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>Fast Shipping</h5>                    
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fas fa-cube fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>Quality Packaging</h5>
                    </div>
                </div>
            </div>                  
            <div class="col-md-6 col-lg-4">
                <div class="featurs-item text-center rounded bg-light p-4">
                    <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                        <i class="fa fa-phone-alt fa-3x text-white"></i>
                    </div>
                    <div class="featurs-content text-center">
                        <h5>24/7 Support</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Featurs Section End -->


<!--Brand Section Start-->
<div class="container-fluid banner bg-secondary my-5">
    <div class="container py-5">
        <div class="testimonial-header text-center">
            <h1 class="display-5 mb-5 text-dark">Our Brands</h1>
        </div>
        <div class="brand-carousel section-padding owl-carousel">
            <div class="single-logo">
                <img src="assets/img/brands/apple.png" class="img-fluid rounded banner-image" alt="">
            </div>
            <div class="single-logo">
                <img src="assets/img/brands/hp.png" class="img-fluid rounded banner-image" alt="">
            </div>
            <div class="single-logo">
                <img src="assets/img/brands/samsung.png" class="img-fluid rounded banner-image" alt="">
            </div>
            <div class="single-logo">
                <img src="assets/img/brands/google.png" class="img-fluid rounded banner-image" alt="">
            </div>
            <div class="single-logo">
                <img src="assets/img/brands/kaku.png" class="img-fluid rounded banner-image" alt="">
            </div>
            <div class="single-logo">
                <img src="assets/img/brands/lenovo.png" class="img-fluid rounded banner-image" alt="">
            </div>
            <div class="single-logo">
                <img src="assets/img/brands/yesido.png" class="img-fluid rounded banner-image" alt="">
            </div>
        </div>

    </div>
</div>
<!--Brand Section End-->

<!-- Fact Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="bg-light p-5 rounded">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fas fa-users"></i>
                        <h4>satisfied customers</h4>
                        <h1>100%</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fab fa-telegram-plane"></i>
                        <h4>Quality of service</h4>
                        <h1>100%</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fas fa-cubes"></i>
                        <h4>Available Products</h4>
                        <h1>100</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fact Start -->

<!-- Recently Added Products Start-->
<div class="container-fluid vesitable py-5">
    <div class="container py-5">
        <h1 class="mb-0">Recently Added</h1>
        <div class="owl-carousel vegetable-carousel justify-content-center">
            <?php
            $db = dbConn(); 
            $sql = "SELECT * FROM products WHERE Status = '1' ORDER BY ProductId Desc LIMIT 8";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="product-card border p-3 rounded">
                        <img src="<?= SYS_URL ?>assets/dist/img/uploads/products/<?= $row['ProductImage'] ?>" class="img-fluid" alt="<?= $row['ProductName'] ?>">
                        <h3><?= $row['ProductName'] ?></h3>
                        <p>LKR <?= number_format($row['SellingPrice'], 2) ?></p>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No recently added products.</p>'; // Message when no products are available
            }
            ?>
        </div>
        <div class="text-center mt-4">
                        <a href="products.php" class="btn btn-outline-info text-primary bg-white" style="padding: 12px 24px; font-size: 1.2rem;">Shop Now</a>
                    </div>
    </div>
</div>
<!-- Recently Added Products End -->

<script>
$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        items: 3, // Adjust based on how many items you want to display
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true
    });
});
</script>


<?php
include 'footer.php';
ob_end_flush();
?> 