<?php
require_once("../vendor/autoload.php"); // ปรับ path ตามความเหมาะสม

include('../../includes/db_connect.php'); // เชื่อมต่อกับฐานข้อมูล

// ปิดการแสดงข้อผิดพลาดชั่วคราว
error_reporting(~E_NOTICE);
ini_set('display_errors', 0);

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง courses
$sql = "SELECT c.course_id, c.course_name, c.course_description, c.teacher_id, c.course_type, c.course_code, c.credits, c.semester, c.academic_year, c.status, t.teacher_name
        FROM courses c
        LEFT JOIN teachers t ON c.teacher_id = t.teacher_id
        WHERE c.course_name LIKE ? OR c.course_description LIKE ? OR t.teacher_name LIKE ?
        ORDER BY c.course_id DESC";

// เตรียมคำค้นหา
$searchTerm = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// สร้าง PDF
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
ini_set("pcre.backtrack_limit", "5000000");

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [__DIR__ . '/tmp']),
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

$html = '<h1>รายงานรายวิชา</h1>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>รหัสรายวิชา</th>
                    <th>ชื่อรายวิชา</th>
                    <th>คำอธิบาย</th>
                    <th>ชื่อครู</th>
                    <th>ประเภท</th>
                    <th>รหัสรายวิชา</th>
                    <th>หน่วยกิจ</th>
                    <th>ภาคเรียน</th>
                    <th>ปีการศึกษา</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'] == 1 ? 'กำลังทำงาน' : 'ไม่ได้ใช้งาน';
        $html .= "<tr>
                    <td>{$row['course_id']}</td>
                    <td>{$row['course_name']}</td>
                    <td>{$row['course_description']}</td>
                    <td>{$row['teacher_name']}</td>
                    <td>" . ($row['course_type'] === 'mandatory' ? 'บังคับ' : 'วิชาเลือก') . "</td>
                    <td>{$row['course_code']}</td>
                    <td>{$row['credits']}</td>
                    <td>{$row['semester']}</td>
                    <td>{$row['academic_year']}</td>
                    <td>{$status}</td>
                </tr>";
    }
} else {
    $html .= '<tr><td colspan="10" style="text-align:center;">ไม่มีข้อมูล</td></tr>';
}

$html .= '    </tbody>
          </table>';

// กำหนดเนื้อหา PDF
$mpdf->WriteHTML($html);

// ส่งไฟล์ PDF ไปยังเบราว์เซอร์
$mpdf->Output('report.pdf', 'I'); // 'I' หมายถึงแสดงในเบราว์เซอร์
