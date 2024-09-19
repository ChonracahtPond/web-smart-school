<?php
require_once("../vendor/autoload.php");
include('../../includes/db_connect.php');
error_reporting(~E_NOTICE);

// ปิดการแสดงข้อผิดพลาดชั่วคราว
ini_set('display_errors', 0);

// mPDF configuration
$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
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

// Get start and end dates from query parameters
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Validate dates
if (!$startDate || !$endDate) {
    die('Invalid dates provided.');
}

// Fetch borrowing data with user names
$sql = "SELECT i.item_name, b.quantity, b.borrowed_at, b.return_due_date, u.first_name, u.last_name
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        JOIN users u ON b.user_id = u.user_id
        WHERE b.borrowed_at BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

// Prepare the report content
$html = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Borrowing Report</title>
    <style>
        body { font-family: 'sarabun', sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>รายงานการยืมอุปกรณ์</h1>
    <p>ระหว่างวันที่: $startDate ถึง $endDate</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ชื่อผู้ยืม</th>
                <th>ชื่ออุปกรณ์</th>
                <th>จำนวน</th>
                <th>วันที่ยืม</th>
      
            </tr>
        </thead>
        <tbody>";

// Add a counter to number the rows
$no = 1;

while ($row = $result->fetch_assoc()) {
    $html .= "
            <tr>
                <td>{$no}</td>
                <td>{$row['first_name']} {$row['last_name']}</td>
                <td>{$row['item_name']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['borrowed_at']}</td>

            </tr>";
    $no++; // Increment the counter
}

$html .= "
        </tbody>
    </table>
</body>
</html>";

// Output the PDF
$mpdf->WriteHTML($html);
$mpdf->Output('borrowing_report.pdf', 'I');
