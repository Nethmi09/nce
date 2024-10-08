<?php

session_start();
include '../function.php';

extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $operate == 'add_wishlist') {

    $db = dbConn();

    $sql = "SELECT * FROM product_stocks 
        INNER JOIN products ON (products.ProductId = product_stocks.ProductId) 
        WHERE product_stocks.StockId='$StockId'";  //Only one record return
        
    //wishlist[1]=array('1','1','2','980.50'); wishlist is session variable name
    //wishlist[1]=array("StockId"=>'1',"ProductId"=>'1',"Quantity"=>'2',"UnitPrice"=>'980.50');
    //wishlist[3]=array('3','5','1','780.50');
    //wishlist[3]=array("StockId"=>'3',"ProductId"=>'5',"Quantity"=>'1',"UnitPrice"=>'780.50');
   

    $result = $db->query($sql);

    $row = $result->fetch_assoc();
    if (isset($_SESSION['wishlist']) && isset($_SESSION['wishlist'][$StockId])) {
        $current_qty = $_SESSION['wishlist'][$StockId]['Quantity'] += 1;
    } else {
        $current_qty = 1;
    }
    $_SESSION['wishlist'][$StockId] = array(
        'StockId' => $row['StockId'],
        'ProductId' => $row['ProductId'],
        'ProductName' => $row['ProductName'],
        'ProductImage' => $row['ProductImage'],
        'UnitPrice' => $row['UnitPrice'],
        'Quantity' => $current_qty);

    // print_r($_SESSION['wishlist']);
    header('Location:products.php');
}