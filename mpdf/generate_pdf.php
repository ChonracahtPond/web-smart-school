<?php
require_once("vendor/autoload.php");
include('../includes/db_connect.php');
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

$student_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($student_id) {
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        // แสดงข้อผิดพลาดอย่างเหมาะสมในกรณีที่ไม่พบข้อมูล
        exit('ไม่พบข้อมูลนักเรียน.');
    }
} else {
    exit('ไม่พบรหัสนักเรียน.');
}

// สร้างเอกสาร PDF
$html = '
<html>
<head>
    <style>
        body { font-family: sarabun, sans-serif; }
        .container { width: 100%; }
        .header { text-align: center; }
        .content { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>รายงานนักเรียน</h1>
        </div>
        <div class="content">
            <table>
                <tr><th>รหัสนักเรียน</th><td>' . htmlspecialchars($student['student_id']) . '</td></tr>
                <tr><th>ระดับชั้น</th><td>' . htmlspecialchars($student['grade_level']) . '</td></tr>
                <tr><th>หมวดหมู่</th><td>' . htmlspecialchars($student['section']) . '</td></tr>
                <tr><th>ชื่อผู้ใช้</th><td>' . htmlspecialchars($student['username']) . '</td></tr>
                <tr><th>ชื่อเต็ม</th><td>' . htmlspecialchars($student['fullname']) . '</td></tr>
                <tr><th>ชื่อเล่น</th><td>' . htmlspecialchars($student['nicknames']) . '</td></tr>
                <tr><th>อีเมล</th><td>' . htmlspecialchars($student['email']) . '</td></tr>
                <tr><th>หมายเลขโทรศัพท์</th><td>' . htmlspecialchars($student['phone_number']) . '</td></tr>
                <tr><th>วันเกิด</th><td>' . htmlspecialchars($student['date_of_birth']) . '</td></tr>
                <tr><th>เพศ</th><td>' . htmlspecialchars($student['gender']) . '</td></tr>
                <tr><th>สถานะ</th><td>' . htmlspecialchars($student['status']) . '</td></tr>
                <tr><th>ชื่อเรียกนักเรียน</th><td>' . htmlspecialchars($student['student_name']) . '</td></tr>
                <tr><th>รหัสบัตรประชาชน</th><td>' . htmlspecialchars($student['national_id']) . '</td></tr>
                <tr><th>ศาสนา</th><td>' . htmlspecialchars($student['religion']) . '</td></tr>
                <tr><th>สัญชาติ</th><td>' . htmlspecialchars($student['nationality']) . '</td></tr>
                <tr><th>อาชีพ</th><td>' . htmlspecialchars($student['occupation']) . '</td></tr>
                <tr><th>รายได้เฉลี่ยต่อปี</th><td>' . htmlspecialchars($student['average_income']) . '</td></tr>
                <tr><th>รหัสประจำตัวบิดา</th><td>' . htmlspecialchars($student['father_id']) . '</td></tr>
                <tr><th>รหัสประจำตัวมารดา</th><td>' . htmlspecialchars($student['mother_id']) . '</td></tr>
                <tr><th>ความรู้เดิมจบชั้น</th><td>' . htmlspecialchars($student['previous_education_level']) . '</td></tr>
                <tr><th>ปี พ.ศ. ที่จบ</th><td>' . htmlspecialchars($student['graduation_year']) . '</td></tr>
                <tr><th>จากโรงเรียน</th><td>' . htmlspecialchars($student['graduation_school']) . '</td></tr>
                <tr><th>อำเภอ/เขต</th><td>' . htmlspecialchars($student['district']) . '</td></tr>
                <tr><th>จังหวัด</th><td>' . htmlspecialchars($student['province']) . '</td></tr>
                <tr><th>วุฒิทางธรรม</th><td>' . htmlspecialchars($student['buddhist_qualification']) . '</td></tr>
                <tr><th>ปี พ.ศ. ที่จบวุฒิทางธรรม</th><td>' . htmlspecialchars($student['buddhist_qualification_year']) . '</td></tr>
                <tr><th>จากสถานศึกษา</th><td>' . htmlspecialchars($student['buddhist_qualification_school']) . '</td></tr>
                <tr><th>อำเภอ/เขตของวุฒิทางธรรม</th><td>' . htmlspecialchars($student['buddhist_district']) . '</td></tr>
                <tr><th>จังหวัดของวุฒิทางธรรม</th><td>' . htmlspecialchars($student['buddhist_province']) . '</td></tr>
                <tr><th>ที่อยู่</th><td>' . htmlspecialchars($student['address']) . '</td></tr>
            </table>
        </div>
    </div>
</body>
</html>
';

// ทำการเขียน PDF
$mpdf->WriteHTML($html);

// ส่งออก PDF
$mpdf->Output('student_report.pdf', 'I');

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
