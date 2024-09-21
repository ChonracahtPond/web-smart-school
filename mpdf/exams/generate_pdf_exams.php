<?php
require_once("../vendor/autoload.php");
include('../../includes/db_connect.php');

error_reporting(~E_NOTICE);
ini_set('display_errors', 0);

// การตั้งค่า mPDF
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

// ตรวจสอบว่ามีการส่งวันที่มาหรือไม่
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// กำหนดจำนวนข้อมูลต่อหน้า
$itemsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// สร้างคำสั่ง SQL สำหรับดึงข้อมูลตามวันที่
$sql = "SELECT e.exam_id, e.enrollment_id, e.exam_type, e.exam_date, e.duration, e.total_marks, e.student_id, e.score, s.student_name, en.course_id , e.exams_status , e.criterion
        FROM exams e
        JOIN students s ON e.student_id = s.student_id
        JOIN enrollments en ON e.enrollment_id = en.enrollment_id
        WHERE e.exam_date BETWEEN ? AND ?
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssii', $startDate, $endDate, $offset, $itemsPerPage);
$stmt->execute();
$result = $stmt->get_result();

// สร้าง HTML สำหรับการแสดงผล
$html = '
<style>
    body {
        font-family: "sarabun";
        margin: 0;
        padding: 20px;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid black;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .pagination {
        margin-top: 20px;
        text-align: center;
    }
    .pagination a {
        margin: 0 5px;
        text-decoration: none;
        color: blue;
    }
</style>
<h1>รายงานการสอบจาก ' . htmlspecialchars($startDate) . ' ถึง ' . htmlspecialchars($endDate) . '</h1>
<table>
    <thead>
        <tr>
            <th>รหัสการสอบ</th>
            <th>รหัสการลงทะเบียน</th>
            <th>ชื่อผู้เรียน</th>
            <th>ประเภทการสอบ</th>
            <th>วันที่สอบ</th>
            <th>คะแนนเต็ม</th>
            <th>เกณฑ์การผ่าน</th>
            <th>คะแนนการสอบ</th>
            <th>สถานะ</th>
        </tr>
    </thead>
    <tbody>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['exam_id']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['enrollment_id']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['student_name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['exam_type']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['exam_date']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['total_marks']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['criterion']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['score']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['exams_status']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// คำนวณจำนวนหน้าทั้งหมด
$countSql = "SELECT COUNT(*) as total FROM exams WHERE exam_date BETWEEN ? AND ?";
$countStmt = $conn->prepare($countSql);
$countStmt->bind_param('ss', $startDate, $endDate);
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $itemsPerPage);

// แสดงข้อมูลการแบ่งหน้า
$html .= '<div class="pagination">หน้า: ';
for ($i = 1; $i <= $totalPages; $i++) {
    $html .= '<a href="?start_date=' . htmlspecialchars($startDate) . '&end_date=' . htmlspecialchars($endDate) . '&page=' . $i . '">' . $i . '</a> ';
}
$html .= '</div>';

// เขียน HTML ลงใน PDF
$mpdf->WriteHTML($html);
$mpdf->Output('report.pdf', 'I'); // แสดง PDF ในเบราว์เซอร์

$conn->close();
exit;
