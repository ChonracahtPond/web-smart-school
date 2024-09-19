<?php
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

$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y') + 543; // เพิ่ม 543 เพื่อให้เป็นปีไทย

// Query the database for the data for the selected year
$sql = "
    SELECT 
        item_name AS ชื่ออุปกรณ์, 
        item_description AS รายละเอียด, 
        purchase_date AS วันที่ซื้อ, 
        purchase_price AS ราคาซื้อ
    FROM 
        items
    WHERE 
        YEAR(purchase_date) + 543 = $year 
";

$result = $conn->query($sql);
if (!$result) {
    die('การค้นหาไม่สำเร็จ: ' . $conn->error);
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
$mpdf->Cell(0, 10, "รายงานประจำปี $year", 0, 1, 'C');
$mpdf->Ln(10);  // Add a line break

// Add data to the PDF
$mpdf->SetFont('sarabun', '', 12);
foreach ($items as $item) {
    $mpdf->Cell(0, 10, $item['ชื่ออุปกรณ์'] . ' - ' . $item['รายละเอียด'], 0, 1);
    $mpdf->Cell(0, 10, 'วันที่ซื้อ: ' . $item['วันที่ซื้อ'], 0, 1);
    $mpdf->Cell(0, 10, 'ราคา: ' . number_format($item['ราคาซื้อ'], 2) . ' บาท', 0, 1);
    $mpdf->Ln(5);  // Add a small line break between items
}

// Output the PDF
$mpdf->Output();
