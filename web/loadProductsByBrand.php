<?php
include '../function.php';
include '../config.php';
$db = dbConn();
extract($_GET);

// If colorId is 0, load all products.
if ($brandId == '0') {
    $sql = "SELECT product_stocks.StockId, products.ProductName, products.ProductImage, 
                                product_stocks.Quantity, product_stocks.UnitPrice, product_stocks.IssuedQuantity, categories.CategoryName 
                                    FROM product_stocks 
                                    INNER JOIN products ON (products.ProductId = product_stocks.ProductId) 
                                    INNER JOIN categories ON (categories.CategoryId = products.CategoryId) 
                                    GROUP BY products.ProductId, product_stocks.UnitPrice";
} else {
    $sql = "SELECT product_stocks.StockId, products.ProductName, products.ProductImage, 
                                product_stocks.Quantity, product_stocks.UnitPrice, product_stocks.IssuedQuantity, categories.CategoryName 
                                    FROM product_stocks 
                                    INNER JOIN products ON (products.ProductId = product_stocks.ProductId) 
                                    INNER JOIN categories ON (categories.CategoryId = products.CategoryId) WHERE products.ColorId='$brandId' AND products.Status = '1'
                                    GROUP BY products.ProductId, product_stocks.UnitPrice";
}

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

