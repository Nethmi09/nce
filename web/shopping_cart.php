<?php
session_start();
include '../function.php';

extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $operate == 'add_cart') {

    $db = dbConn();
    $sql = "SELECT * FROM product_stocks 
        INNER JOIN products ON (products.ProductId = product_stocks.ProductId) 
        WHERE product_stocks.StockId='$StockId'";  //Only one record return
    //cart[1]=array('1','1','2','980.50'); cart is session variable name
    //cart[1]=array("StockId"=>'1',"ProductId"=>'1',"Quantity"=>'2',"UnitPrice"=>'980.50');
    //cart[3]=array('3','5','1','780.50');
    //cart[3]=array("StockId"=>'3',"ProductId"=>'5',"Quantity"=>'1',"UnitPrice"=>'780.50');

    $result = $db->query($sql);

    $row = $result->fetch_assoc();
    if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$StockId])) {
        $current_qty = $_SESSION['cart'][$StockId]['Quantity'] += 1;
    } else {
        $current_qty = 1;
    }
    $profit=$row['SellingPrice'] - $row['PurchasePrice'];
    //Customer add the product to cart. 
//In this code,I used to cart session. 
//This cart session used when I click on the Add to cart button pass the stock id and crate some query to get details and check the cart session already set or not. 
//If the cart session already set update the quantity if not set the current quantity as a 1. 
//Then i assign to the cart session to using the associate array with a sub array all details store the cart session.
    $_SESSION['cart'][$StockId] = array(
    'StockId' => $row['StockId'],
    'ProductId' => $row['ProductId'],
    'ProductName' => $row['ProductName'],
    'ProductImage' => $row['ProductImage'],
    'UnitPrice' => $row['UnitPrice'],
    'Quantity' => $current_qty,
    'Profit' => $profit);
    
    header('Location:products.php');
}