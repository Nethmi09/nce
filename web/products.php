<?php
ob_start();
session_start();
include 'header.php';
include '../mail.php';
?> 

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shopping Products</h1>
</div>
<!-- Single Page Header End -->

<!-- Products display and filtering options here -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <style>
                .product-card {
                    border: 1px solid #04414d;
                    border-radius: 10px;
                    overflow: hidden;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    text-align: center;
                    padding: 20px;
                    margin-bottom: 20px;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    height: 100%;
                }

                .product-card img {
                    width: 100%;
                    height: 300px; /* Fixed height for images */
                    object-fit: cover; /* Ensures the image covers the area and maintains aspect ratio */
                    margin-bottom: 15px;
                }

                .product-card h2 {
                    font-size: 1.5rem;
                    margin-bottom: 10px;
                }

                .product-card p {
                    font-size: 1.2rem;
                    color: #333;
                    margin-bottom: 15px;
                }

                .product-card button {
                    background-color: #31708E;
                    color: #fff;
                    border: none;
                    padding: 10px 20px;
                    font-size: 1rem;
                    cursor: pointer;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                    width: 50%; /* Make all buttons full width */
                    box-sizing: border-box; /* Ensure padding is included in the width */
                    margin-bottom: 10px; /* Add spacing between buttons */
                }

                .product-card button:hover {
                    background-color: #03353b;
                }

            </style>

            <div class="row">

                <?php
                include '../function.php';
                include '../config.php';
                $db = dbConn();
                $sql = "SELECT product_stocks.StockId,"
                        . "products.ProductName,"
                        . "products.ProductImage,"
                        . "product_stocks.Quantity,"
                        . "product_stocks.UnitPrice,"
                        . "categories.CategoryName From product_stocks "
                        . "INNER JOIN products ON (products.ProductId=product_stocks.ProductId) "
                        . "INNER JOIN categories ON (categories.CategoryId=products.CategoryId) "
                        . "GROUP BY products.ProductId,product_stocks.UnitPrice";
                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="product-card">

                                <img src="<?= SYS_URL ?>assets/dist/img/uploads/products/<?= $row['ProductImage'] ?>">
                                <h2><?= $row['ProductName'] ?></h2>
                                <p>LKR <?= number_format($row['UnitPrice'], 2) ?></p>
                                <form method="post" action="shopping_cart.php">
                                    <input type="hidden" name="StockId" value="<?= $row['StockId'] ?>">
                                    <button type="submit" name="operate" value="add_cart">Add to Cart</button> 
                                    <br>                                    
                                    <button type="submit" name="operate" value="add_cart">View Product</button> 
                                    <br>
                                    <button type="submit" name="operate" value="add_cart">Add to Wishlist</button> 
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
<!-- End -->

<?php
include 'footer.php';
ob_end_flush();
?> 