<?php
require_once("../vendor/autoload.php");
include('../../includes/db_connect.php');

// รับค่า start_date, end_date และ year จาก URL
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;
$year = isset($_GET['year']) ? $_GET['year'] : null;

// แปลงวันที่จากรูปแบบ dd/mm เป็น yyyy-mm-dd
function convertDateFormat($date, $year) {
    if ($date) {
        $parts = explode('/', $date);
        if (count($parts) == 2) {
            return $year . '-' . str_pad($parts[1], 2, '0', STR_PAD_LEFT) . '-' . str_pad($parts[0], 2, '0', STR_PAD_LEFT) . ' 00:00:00';
        }
    }
    return null;
}

// ถ้าปีไม่ได้ระบุ ใช้ปีจากวันที่เริ่มต้น (หรือปีปัจจุบัน)
$current_year = date('Y');
$start_year = $current_year;
$end_year = $current_year;

if ($start_date) {
    $start_year = date('Y', strtotime(convertDateFormat($start_date, $current_year)));
}

if ($end_date) {
    $end_year = date('Y', strtotime(convertDateFormat($end_date, $current_year)));
}

$year = $year ?: $current_year;

// แปลงวันที่ให้ใช้ปีที่ระบุ
$start_date = convertDateFormat($start_date, $year);
$end_date = convertDateFormat($end_date, $year);
$end_date = $end_date ? date('Y-m-d 23:59:59', strtotime($end_date)) : null;

// แปลงปีคริสตศักราชเป็นปีพุทธศักราช
$year_be = $year + 543;

// สร้าง SQL Query
$sql = "SELECT * FROM register WHERE status_register IN (0, 1, 3)";
$params = [];
$types = '';

// ตรวจสอบวันที่
if ($start_date && $end_date) {
    $sql .= " AND registration_date BETWEEN ? AND ?";
    $params = [$start_date, $end_date];
    $types = 'ss';
} elseif ($year) {
    $sql .= " AND YEAR(registration_date) = ?";
    $params = [$year];
    $types = 'i';
}

// ใช้ Prepared Statements เพื่อป้องกัน SQL Injection
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('เตรียมคำสั่ง SQL ล้มเหลว: ' . $conn->error);
}

if ($params) {
    $stmt->bind_param($types, ...$params);
}

// เรียกใช้งาน query
$stmt->execute();
$result = $stmt->get_result();
$students = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

// จำนวนผู้สมัคร
$total_students = count($students);

// สร้างไฟล์ PDF
$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [
        __DIR__ . '/tmp', // กำหนดโฟลเดอร์เก็บฟอนต์
    ]),
    'fontdata' => (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'] + [
        'sarabun' => [ // ฟอนต์ภาษาไทย
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'sarabun' // ตั้งฟอนต์เป็น TH Sarabun
]);

// แสดงวันที่ในรูปแบบที่เข้าใจง่าย
$start_date_display = date('d/m/Y', strtotime($start_date));
$end_date_display = date('d/m/Y', strtotime($end_date));

// สร้างเนื้อหาของ PDF
$html = '<h1>รายงานและสถิติการสมัครเรียน ปี ' . htmlspecialchars($year_be) . '</h1>';
$html .= '<p>ระหว่างวันที่: ' . htmlspecialchars($start_date_display) . ' ถึง ' . htmlspecialchars($end_date_display) . '</p>';
$html .= '<p>จำนวนผู้สมัคร: ' . htmlspecialchars($total_students) . ' คน</p>';
$html .= '<table border="1" style="width:100%; border-collapse: collapse;">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>No</th>';
$html .= '<th>ชื่อของนักเรียน</th>';
$html .= '<th>เพศ</th>';
$html .= '<th>อีเมล</th>';
$html .= '<th>หมายเลขโทรศัพท์</th>';
$html .= '<th>สถานะ</th>'; // เพิ่มคอลัมน์สถานะ
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

// แปลสถานะ
function translateStatus($status) {
    switch ($status) {
        case 0:
            return 'สนใจสมัครเรียน';
        case 1:
            return 'ผ่าน';
        case 3:
            return 'ไม่ผ่าน';
        default:
            return 'ไม่ทราบ';
    }
}

if (!empty($students)) {
    $no = 1;
    foreach ($students as $student) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($no++) . '</td>';
        $html .= '<td>' . htmlspecialchars($student['student_name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($student['gender']) . '</td>';
        $html .= '<td>' . htmlspecialchars($student['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($student['phone_number']) . '</td>';
        $html .= '<td>' . htmlspecialchars(translateStatus($student['status_register'])) . '</td>'; // แสดงสถานะ
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="6" style="text-align:center;">ไม่พบข้อมูล</td></tr>'; // ปรับจำนวนคอลัมน์ให้ตรง
}

$html .= '</tbody>';
$html .= '</table>';

// ใส่เนื้อหาใน PDF
$mpdf->WriteHTML($html);

// แสดง PDF ในเบราว์เซอร์
$mpdf->Output('student_report.pdf', 'I'); // 'I' สำหรับแสดง PDF ในเบราว์เซอร์
exit();
?>
