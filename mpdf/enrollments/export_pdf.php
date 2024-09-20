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
$sql = "SELECT student_id, course_id, semester, academic_year, grade, status, teacher_id, class, credits 
        FROM enrollments 
        WHERE created_at BETWEEN ? AND ? 
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
<h1>รายงานการลงทะเบียน</h1>
<table>
    <thead>
        <tr>
            <th>student_id</th><th>course_id</th><th>semester</th>
            <th>academic_year</th><th>grade</th><th>status</th>
            <th>teacher_id</th><th>class</th><th>credits</th>
        </tr>
    </thead>
    <tbody>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['student_id']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['course_id']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['semester']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['academic_year']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['grade']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['status']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['teacher_id']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['class']) . '</td>';
    $html .= '<td>' . htmlspecialchars($row['credits']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// คำนวณจำนวนหน้าทั้งหมด
$countSql = "SELECT COUNT(*) as total FROM enrollments WHERE created_at BETWEEN ? AND ?";
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
