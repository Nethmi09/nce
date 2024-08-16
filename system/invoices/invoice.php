<?php

// Include the TCPDF library
require_once('../../TCPDF/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page header
    public function Header() {
        // Logo
        $image_file = 'NCE-Logo-1.jpg'; // Path to the logo file
        $this->Image($image_file, 10, 10, 30, '', 'jpg', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'Namarathna Cellulars and Electronics', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Ensure there is no output before PDF generation
ob_start();

// Include database connection
include_once '../init.php';
extract($_GET);
$db = dbConn();

// Query to fetch payment data from the table
$sql = "SELECT o.*,c.*,u.* FROM orders o "
        . "INNER JOIN customers c ON c.CustomerId=o.CustomerId "
        . "INNER JOIN users u ON u.UserId=c.UserId WHERE OrderId = $order_id";
$result = $db->query($sql);

// Fetch the payment data
$orders = $result->fetch_assoc();

// save pdf directory
$save_path = __DIR__. '/../../docs/invoice.pdf';

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Namarathna Cellulars and Electronics');
$pdf->SetTitle('Orders');
$pdf->SetSubject('Invoice');

// Set header and footer fonts
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 16);

// Title
$pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');
$pdf->Ln(10); // Line break

// Add payment details
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(50, 10, 'Invoice Number :', 0, 0);
$pdf->Cell(0, 10, $orders['OrderId'], 0, 1);

$pdf->Cell(50, 10, 'Customer Name :', 0, 0);
$pdf->Cell(0, 10, $orders['FirstName']." ".$orders['LastName'], 0, 1);

$pdf->Cell(50, 10, 'Customer Email :', 0, 0);
$pdf->Cell(0, 10, $orders['PersonalEmail'], 0, 1);

$pdf->Cell(50, 10, 'Order Date :', 0, 0);
$pdf->Cell(0, 10, $orders['OrderDate'], 0, 1);

$pdf->Cell(50, 10, 'Order Number :', 0, 0);
$pdf->Cell(0, 10, $orders['OrderNumber'], 0, 1);

$pdf->Cell(50, 10, 'Products Total :', 0, 0);
$pdf->Cell(0, 10, 'Rs. '.$orders['OrderNumber'], 0, 1);

$pdf->Cell(50, 10, 'Discount :', 0, 0);
$pdf->Cell(0, 10, 'Rs. '. ($orders['Discount']), 0, 1);

$pdf->Cell(50, 10, 'Net Total :', 0, 0);
$pdf->Cell(0, 10, 'Rs. '.$orders['NetTotal'], 0, 1);

$pdf->Cell(50, 10, 'Delivery Cost :', 0, 0);
$pdf->Cell(0, 10, 'Rs. '.$orders['DeliveryCost'], 0, 1);

$pdf->Cell(50, 10, 'Total Payment :', 0, 0);
$pdf->Cell(0, 10, 'Rs. '.$orders['TotalAmount'], 0, 1);

$pdf->Ln(20); // Line break

// Add thank you note
$pdf->Cell(0, 10, 'Thank you for your order!', 0, 1, 'C');

// Output the PDF
ob_end_clean(); // Clean the output buffer
$pdf->Output($save_path, 'I');

?>
