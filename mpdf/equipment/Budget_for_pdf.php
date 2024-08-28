<?php
// require_once '../vendor/autoload.php';  // Make sure this path is correct for your Composer autoload
// include '../../includes/db_connect.php';  // Adjust the path as necessary
require_once("../vendor/autoload.php");
include('../../includes/db_connect.php');

error_reporting(~E_NOTICE);

// ปิดการแสดงข้อผิดพลาดชั่วคราว
ini_set('display_errors', 0);

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
ini_set("pcre.backtrack_limit", "5000000");

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf'
        ]
    ],
    'default_font' => 'sarabun' // เลือกฟอนต์ที่ต้องการใช้
]);


$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Query the database for the data for the selected year
$sql = "
    SELECT 
        item_name, 
        item_description, 
        purchase_date, 
        purchase_price
    FROM 
        items
    WHERE 
        YEAR(purchase_date) = $year
";

$result = $conn->query($sql);
if (!$result) {
    die('Query failed: ' . $conn->error);
}

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

// Clear any previous output buffer
ob_clean();

// Start creating the PDF
$mpdf->AddPage();
$mpdf->SetFont('sarabun', 'B', 16);
$mpdf->Cell(0, 10, "Report for the year $year", 0, 1, 'C');
$mpdf->Ln(10);  // Add a line break

// Add data to the PDF
$mpdf->SetFont('sarabun', '', 12);
foreach ($items as $item) {
    $mpdf->Cell(0, 10, $item['item_name'] . ' - ' . $item['item_description'], 0, 1);
    $mpdf->Cell(0, 10, 'Purchase Date: ' . $item['purchase_date'], 0, 1);
    $mpdf->Cell(0, 10, 'Price: ' . number_format($item['purchase_price'], 2) . ' บาท', 0, 1);
    $mpdf->Ln(5);  // Add a small line break between items
}

// Output the PDF
$mpdf->Output();
