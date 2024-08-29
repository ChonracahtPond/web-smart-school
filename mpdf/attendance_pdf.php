<?php
require_once("vendor/autoload.php");
include('../includes/db_connect.php');
error_reporting(~E_NOTICE);

// ปิดการแสดงข้อผิดพลาดชั่วคราว
ini_set('display_errors', 0);

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

// ตั้งค่าตัวแปรสำหรับกรองวันที่
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// ดึงข้อมูลการเข้าร่วม
$sql = "SELECT a.attendance_id, a.student_id, a.lesson_id, a.attendance_date, a.status,
               s.student_name, l.lesson_title, c.course_name
        FROM attendance a
        JOIN students s ON a.student_id = s.student_id
        JOIN lessons l ON a.lesson_id = l.lesson_id
        JOIN courses c ON l.course_id = c.course_id
        WHERE a.attendance_date BETWEEN ? AND ?";

// เตรียมและรันคำสั่ง SQL
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบข้อผิดพลาดของ SQL
if (!$result) {
    die("ข้อผิดพลาดในการดำเนินการ SQL: " . $conn->error);
}

// สร้าง PDF
$mpdf->AddPage();
$mpdf->SetFont('sarabun', 'B', 12);

// Header
$mpdf->Cell(0, 10, 'รายงานการขาด ลา มาสาย', 0, 1, 'C');
$mpdf->Ln(10);

// Table header
$mpdf->SetFont('sarabun', 'B', 10);
$mpdf->Cell(40, 10, 'ชื่อผู้เรียน', 1);
$mpdf->Cell(40, 10, 'ชื่อรายวิชา', 1);
$mpdf->Cell(50, 10, 'ชื่อบทเรียน', 1);
$mpdf->Cell(30, 10, 'วันที่เข้าร่วม', 1);
$mpdf->Cell(30, 10, 'สถานะ', 1);
$mpdf->Ln();

// Table data
$mpdf->SetFont('sarabun', '', 10);
while ($row = $result->fetch_assoc()) {
    $mpdf->Cell(40, 10, htmlspecialchars($row['student_name']), 1);
    $mpdf->Cell(40, 10, htmlspecialchars($row['course_name']), 1);
    $mpdf->Cell(50, 10, htmlspecialchars($row['lesson_title']), 1);
    $mpdf->Cell(30, 10, htmlspecialchars($row['attendance_date']), 1);

    // Map status to Thai text
    $statusText = '';
    switch ($row['status']) {
        case 'Missingclass':
            $statusText = 'ขาด';
            break;
        case 'Studyleave':
            $statusText = 'ลา';
            break;
        case 'Arrivelate':
            $statusText = 'มาสาย';
            break;
        default:
            $statusText = 'ไม่ทราบ';
    }
    $mpdf->Cell(30, 10, $statusText, 1);
    $mpdf->Ln();
}

// Output PDF
$mpdf->Output('I', 'รายงานการขาด_ลา_มาสาย.pdf'); // I for inline display, D for download
