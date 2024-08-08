<?php

include_once '../init.php';
$db = dbConn();

$issue_qty = 25; //15,
$product = 10;

while ($issue_qty > 0) {
    // Select the oldest stock record for the product which still has quantity available
    $sql = "SELECT *
            FROM product_stocks
            WHERE ProductId = $product
              AND (Quantity - COALESCE(IssuedQuantity, 0)) > 0 
            ORDER BY PurchaseDate ASC
            LIMIT 1";
    //COALESCE : Null convert to 0 or notnull-get existing value
    $result = $db->query($sql);

    // If a stock record is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Calculate the remaining quantity of the current stock record
        $remaining_qty = $row['Quantity'] - ($row['IssuedQuantity'] ?? 0);

        if ($issue_qty <= $remaining_qty) {
            // If the issue quantity is less than or equal to the remaining quantity
            $i_qty = $issue_qty;
            $s_id = $row['StockId'];
            $sql = "UPDATE product_stocks SET IssuedQuantity = COALESCE(IssuedQuantity, 0) + $i_qty WHERE StockId = $s_id";
            $db->query($sql);
            $issue_qty = 0; // All items have been issued
        } else {
            // If the issue quantity is more than the remaining quantity
            $i_qty = $remaining_qty;
            $s_id = $row['StockId'];
            $sql = "UPDATE product_stocks SET IssuedQuantity = COALESCE(IssuedQuantity, 0) + $i_qty WHERE StockId = $s_id";
            $db->query($sql);
            $issue_qty -= $i_qty;    // Subtract the issued quantity from the total issue quantity        
        }
    } else {
        // If no stock record is found, break the loop
        break;
    }
}
