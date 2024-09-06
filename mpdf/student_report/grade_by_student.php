<?php
require_once("../vendor/autoload.php");
include('../../includes/db_connect.php');
error_reporting(~E_NOTICE);
ini_set('display_errors', 0);

$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
if ($student_id <= 0) {
    die("Invalid student ID");
}

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
    'default_font' => 'sarabun'
]);

// Query to get student grades
$sql = "
    SELECT
        e.enrollment_id,
        e.student_id,
        e.course_id,
        e.semester,
        e.academic_year,
        e.grade,
        e.status,
        e.teacher_id,
        s.student_name,
        c.course_name,
        t.teacher_name,
        e.class,
        e.credits 
    FROM enrollments e
    JOIN students s ON e.student_id = s.student_id
    JOIN courses c ON e.course_id = c.course_id
    JOIN teachers t ON e.teacher_id = t.teacher_id
    WHERE e.student_id = ?
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}
$stmt->bind_param('i', $student_id);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    die("SQL execute failed: " . $stmt->error);
}

$grades = [];
while ($row = $result->fetch_assoc()) {
    $grades[] = $row;
}

function get_class_name($class)
{
    switch ($class) {
        case '0':
            return "ว่าง";
        case '1':
            return "ประถม";
        case '2':
            return "มัธยมต้น";
        case '3':
            return "มัธยมปลาย";
        default:
            return "ไม่ระบุ";
    }
}

function get_status_name($status)
{
    switch ($status) {
        case '0':
            return "กำลังศึกษา";
        case '1':
            return "ศึกษาจบแล้ว";
        case '2':
            return "ดรอปเรียน";
        case '3':
            return "ยกเลิกรายวิชา";
        default:
            return "ไม่ทราบสถานะ";
    }
}

$html = '<h1>รายงานเกรดของนักเรียน</h1>';
$html .= '<table border="1" style="width:100%; border-collapse:collapse;">';
$html .= '<thead><tr>
    <th>ชื่อ-นามสกุล นักศึกษา</th>
    <th>วิชา</th>
    <th>เทอม</th>
    <th>ปี</th>
    <th>เกรดเฉลี่ย</th>
    <th>หน่วยกิจ</th>
    <th>ครูประจำวิชา</th>
    <th>ชั้น</th>
    <th>สถานะ</th>
</tr></thead>';
$html .= '<tbody>';

foreach ($grades as $grade) {
    $grade_color = $grade['grade'] < 1.5 ? 'color:red;' : 'color:green;';
    $html .= '<tr>
        <td>' . htmlspecialchars($grade['student_name']) . '</td>
        <td>' . htmlspecialchars($grade['course_name']) . '</td>
        <td>' . htmlspecialchars($grade['semester']) . '</td>
        <td>' . htmlspecialchars($grade['academic_year']) . '</td>
        <td style="' . $grade_color . '">' . htmlspecialchars($grade['grade']) . '</td>
        <td>' . htmlspecialchars($grade['credits']) . '</td>
        <td>' . htmlspecialchars($grade['teacher_name']) . '</td>
        <td>' . get_class_name($grade['class']) . '</td>
        <td>' . get_status_name($grade['status']) . '</td>
    </tr>';
}

$html .= '</tbody></table>';

$mpdf->WriteHTML($html);
$mpdf->Output();
