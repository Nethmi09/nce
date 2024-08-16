<?php

ob_start();
date_default_timezone_set('Asia/Colombo');

include_once 'init.php';
include '../mail.php';
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT i.*,p.*,r.ProductName,s.SupCompanyName,s.Email 
    FROM price_request_item i 
    LEFT JOIN price_request p ON i.PriceRequestId=p.Id 
    LEFT JOIN products r ON r.ProductId=i.ItemId 
    LEFT JOIN suppliers s ON s.SupplierId=P.SupplierId 
    WHERE p.Id='$PriceRequestId'";

    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $Email = $row ['Email'];
    $RequestDate = $row['RequestDate'];
    $Supplier = $row ['SupCompanyName'];
    $send_token = bin2hex(random_bytes(16));

    $db = dbConn();
    $sql = "UPDATE price_request SET Token='$send_token' WHERE ID = '$PriceRequestId'";
    $db->query($sql);

    $msg = "<h1>Quotation Request - Namarathna Cellular and Electronics(NCE)</h1>";
    $msg .= "<h2>If you don't have the requested quantity, please feel free to contact us. (Contact Number:0768945123)</h2>";
    $msg .= "<a href='http://localhost/nce/system/purchases/view_quote.php?token=$send_token'>Click here to view quotation request.</a>";
    sendEmail($Email, $Supplier, "Quotation Request- Namarathna Cellular and Electronics(NCE)", $msg);

    header("Location:purchases/quotationRequestAdd.php");
}
?>




