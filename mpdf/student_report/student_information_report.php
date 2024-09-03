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

// Fetch all student data from the database
$sql = "SELECT * FROM students WHERE status = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Prepare HTML content for PDF
    $html = '
    <html>
    <head>
        <style>
            body {
                font-family: "sarabun", sans-serif;
            }
            .container {
                width: 100%;
                padding: 20px;
            }
            h1 {
                text-align: center;
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>ข้อมูลนักเรียนทั้งหมด</h1>
            <table>
                <tr>
                    <th>รหัสนักเรียน</th>
                    <th>ชื่อเต็ม</th>
                    <th>ระดับชั้น</th>
                    <th>ห้องเรียน</th>
                    <th>ชื่อเล่น</th>
                    <th>อีเมล</th>
                    <th>หมายเลขโทรศัพท์</th>
                    <th>วันเกิด</th>
                    <th>เพศ</th>
                </tr>';

    while ($student = $result->fetch_assoc()) {
        $html .= '
                <tr>
                    <td>' . htmlspecialchars($student['student_id']) . '</td>
                    <td>' . htmlspecialchars($student['fullname']) . '</td>
                    <td>' . htmlspecialchars($student['grade_level']) . '</td>
                    <td>' . htmlspecialchars($student['section']) . '</td>
                    <td>' . htmlspecialchars($student['nicknames']) . '</td>
                    <td>' . htmlspecialchars($student['email']) . '</td>
                    <td>' . htmlspecialchars($student['phone_number']) . '</td>
                    <td>' . htmlspecialchars($student['date_of_birth']) . '</td>
                    <td>' . htmlspecialchars($student['gender']) . '</td>
                </tr>';
    }

    $html .= '
            </table>
        </div>
    </body>
    </html>';

    // Write HTML content to PDF
    $mpdf->WriteHTML($html);

    // Output PDF
    $mpdf->Output('student_information_report.pdf', 'I');
} else {
    echo "No records found";
}

$conn->close();
