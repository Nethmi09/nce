<?php
ob_start();
session_start();
include 'header.php';
include '../mail.php';

include '../function.php';
include '../config.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shopping Products</h1>
</div>
<!-- Single Page Header End -->

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

<!-- Filtering options and Products display here -->

<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Shop All</h1>
        <div class="row g-4">
            <div class="col-lg-12">
               
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <br>
                                <div class="mb-3">
                                    <h4> Filter By Main Category</h4>

                                    <ul>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM main_categories WHERE Status = '1'";
                                        $result = $db->query($sql);

                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <li><a href="#" onclick="loadProductsByMainCategory(<?= $row['MainCategoryId'] ?>)"><?= $row['MainCategoryName'] ?></a></li>
                                            <?php
                                        }
                                        ?>
                                        <li><a href="#" onclick="loadProductsByMainCategory('0')">All</a></li>
                                    </ul>
                                </div>

                                <br>
                                <div class="mb-3">
                                    <h4>Filter By Sub Category</h4>
                                    <ul>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM categories WHERE Statuss = '1'";
                                        $result = $db->query($sql);

                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <li><a href="#" onclick="loadProductsByCategory(<?= $row['CategoryId'] ?>)"><?= $row['CategoryName'] ?></a></li>
                                            <?php
                                        }
                                        ?>
                                        <li><a href="#" onclick="loadProductsByCategory('0')">All</a></li>
                                    </ul>
                                    
                                </div>

                                <br>
                                <div class="mb-3">
                                    <h4>Filter By Brands</h4>
                                     <ul>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM brands WHERE BStatus = '1'";
                                        $result = $db->query($sql);

                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <li><a href="#" onclick="loadProductsByBrand(<?= $row['BrandId'] ?>)"><?= $row['BrandName'] ?></a></li>
                                            <?php
                                        }
                                        ?>
                                        <li><a href="#" onclick="loadProductsByBrand('0')">All</a></li>
                                    </ul>

                                </div>

                                <br>
                                <div class="mb-3">
                                    <h4>Filter By Colors</h4>
                                     <ul>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM colors WHERE Status = '1'";
                                        $result = $db->query($sql);

                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <li><a href="#" onclick="loadProductsByColor(<?= $row['ColorId'] ?>)"><?= $row['ColorName'] ?></a></li>
                                            <?php
                                        }
                                        ?>
                                        <li><a href="#" onclick="loadProductsByColor('0')">All</a></li>
                                    </ul>

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-center" id="product_grid">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT product_stocks.StockId, products.ProductName, products.ProductImage, 
                                product_stocks.Quantity, product_stocks.UnitPrice, product_stocks.IssuedQuantity, categories.CategoryName 
                                    FROM product_stocks 
                                    INNER JOIN products ON (products.ProductId = product_stocks.ProductId) 
                                    INNER JOIN categories ON (categories.CategoryId = products.CategoryId) 
                                    GROUP BY products.ProductId, product_stocks.UnitPrice";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $availableQuantity = $row['Quantity'] - $row['IssuedQuantity'];
                                    ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="product-card border p-3 rounded">
                                            <img src="<?= SYS_URL ?>assets/dist/img/uploads/products/<?= $row['ProductImage'] ?>">
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
                                            <!--<form method="post" action="">
                                                    <input type="hidden" name="StockId" value="<?= $row['StockId'] ?>">
                                                    <button type="submit" name="operate" value="">View Product</button>
                                                </form>-->
                                            <form method="post" action="shopping_wishlist.php">
                                                <input type="hidden" name="StockId" value="<?= $row['StockId'] ?>">
                                                <button type="submit" name="operate" value="add_wishlist">Add to Wishlist</button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End-->

<?php
include 'footer.php';
ob_end_flush();
?> 

<!--Load Products By Main Category-->
<script>

    function loadProductsByMainCategory(maincategoryId) {

        if (maincategoryId) {

            $.ajax({
                url: 'loadProductsByMainCategory.php?maincategoryId=' + maincategoryId,
                type: 'GET',
                success: function (data) {
                    $("#product_grid").html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }
    }
</script>

<!--Load Products By Category-->
<script>

    function loadProductsByCategory(categoryId) {

        if (categoryId) {

            $.ajax({
                url: 'loadProductsByCategory.php?categoryId=' + categoryId,
                type: 'GET',
                success: function (data) {
                    $("#product_grid").html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }
    }
</script>


<!--Load Products By Brand-->
<script>

    function loadProductsByBrand(brandId) {

        if (brandId) {

            $.ajax({
                url: 'loadProductsByBrand.php?brandId=' + brandId,
                type: 'GET',
                success: function (data) {
                    $("#product_grid").html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }
    }
</script>

<!--Load Products By Color-->
<script>

    function loadProductsByColor(colorId) {

        if (colorId) {

            $.ajax({
                url: 'loadProductsByColor.php?colorId=' + colorId,
                type: 'GET',
                success: function (data) {
                    $("#product_grid").html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }
    }
</script>