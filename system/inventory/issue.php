<?php

include_once '../init.php';
$db = dbConn();
extract($_POST);
print_r($_POST);

foreach ($issued_qty as $key => $qty) {
    
    $issue_qty = $qty;
    $product=$products[$key];
    $price=$prices[$key];
    
    while ($issue_qty > 0) {
        // Select the stock with available quantity, ordered by purchase date (FIFO)
        echo $sql = "SELECT * FROM product_stocks
                WHERE ProductId = '$product' 
                  AND UnitPrice = '$price'
                  AND (Quantity - COALESCE(IssuedQuantity, 0)) > 0
                ORDER BY PurchaseDate ASC
                LIMIT 1";
        $result = $db->query($sql);

        // If no more stock available, break the loop to avoid infinite loop
        if ($result->num_rows == 0) {           
            break;
        }

        $row = $result->fetch_assoc();
        $remaining_qty = $row['Quantity'] - ($row['IssuedQuantity'] ?? 0);
        $product_id=$row['ProductId'];
        $unit_price = $row['UnitPrice'];
        $i_date = date('Y-m-d');

        if ($issue_qty <= $remaining_qty) {
            $i_qty = $issue_qty;
            $s_id = $row['StockId'];
            $sql = "UPDATE product_stocks SET IssuedQuantity = COALESCE(IssuedQuantity, 0) + $i_qty WHERE StockId = $s_id";
            $db->query($sql);
            
            $sql = "UPDATE order_products SET IssuedQuantity = COALESCE(IssuedQuantity, 0) + $i_qty WHERE OrderId = '$order_id' AND ProductId='$product_id'";
            $db->query($sql);
            
            $sql = "INSERT INTO order_products_issue(OrderId, ProductId, StockId, UnitPrice, IssuedQuantity, IssuedDate) 
                    VALUES ('$order_id', '$product_id', '$s_id', '$unit_price', '$i_qty', '$i_date')";
            $db->query($sql);
            $issue_qty = 0;  // All quantity issued
        } else {
            $i_qty = $remaining_qty;
            $s_id = $row['StockId'];
            $sql = "UPDATE product_stocks SET IssuedQuantity = COALESCE(IssuedQuantity, 0) + $i_qty WHERE StockId = $s_id";
            $db->query($sql);
            
            $sql = "UPDATE order_products SET IssuedQuantity = COALESCE(IssuedQuantity, 0) + $i_qty WHERE OrderId = '$order_id' AND ProductId='$product_id'";
            $db->query($sql);
            
             $sql = "INSERT INTO order_products_issue(OrderId, ProductId, StockId, UnitPrice, IssuedQuantity, IssuedDate) 
                    VALUES ('$order_id', '$product_id', '$s_id', '$unit_price', '$i_qty', '$i_date')";
            $db->query($sql);
            $issue_qty -= $i_qty;  // Reduce the remaining quantity to be issued
        }
    }
}
 $sql = "UPDATE orders SET OrderStatus='1' WHERE OrderId = $order_id";
 $db->query($sql);
header("Location:../orders/view_order_products.php?order_id=$order_id");