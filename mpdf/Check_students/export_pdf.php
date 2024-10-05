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
    'default_font' => 'sarabun',
    'format' => 'A4-L' // ตั้งค่าขนาดกระดาษ A4 แนวนอน
]);

// รับค่า course_id จาก URL
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

// ตรวจสอบว่า course_id มีค่าอยู่
if ($course_id > 0) {
    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลจากตาราง enrollments, lessons, students, attendance และ courses
    $sql = "SELECT 
                e.enrollment_id, 
                s.student_id, 
                s.student_name AS student_name, 
                e.semester, 
                e.academic_year, 
                e.grade, 
                e.status AS enrollment_status, 
                e.teacher_id, 
                e.class AS enrollment_class, 
                e.credits, 
                l.lesson_id, 
                l.lesson_title, 
                l.lesson_content, 
                l.lesson_date, 
                l.status AS lesson_status,
                a.attendance_id,
                a.attendance_date,
                a.status AS attendance_status,
                c.course_name
            FROM enrollments e 
            LEFT JOIN lessons l ON e.course_id = l.course_id 
            LEFT JOIN students s ON e.student_id = s.student_id 
            LEFT JOIN attendance a ON a.student_id = s.student_id AND a.lesson_id = l.lesson_id 
            LEFT JOIN courses c ON e.course_id = c.course_id 
            WHERE e.course_id = ? 
            ORDER BY l.lesson_id ASC";  // เรียงลำดับตาม lesson_id

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($result->num_rows > 0) {
        // เริ่มสร้างเนื้อหาของ PDF
        $html = '<h1 style="text-align:center;">รายงานการเข้าเรียน</h1>';
        $html .= '<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000; /* เส้นขอบ */
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2; /* สีพื้นหลังหัวตาราง */
        }
        .linehead {
            width: 100%; /* ขยายให้เต็มความกว้าง */
            height: 5px; /* ความสูงของแถบ */
            background-color: #000; /* สีของแถบ */
            margin: 10px 0; /* เพิ่มระยะห่างด้านบนและล่าง */
        }
    </style>';


        $html .= '<table>';
        $html .= '<thead>
                <tr>
                  <th class="border border-gray-300 px-4 py-2 w-24 h-20 relative">
                    <p class="text-right mb-1">ชื่อ / สัปดาห์</p>
                  </th>
                        ';

        // เพิ่มหัวตารางสำหรับสัปดาห์ที่ 1 ถึง 18
        for ($week = 1; $week <= 18; $week++) {
            $html .= "<th>{$week}</th>";
        }

        $html .= '</tr>
                  </thead>';
        $html .= '<tbody>';

        // จัดกลุ่มข้อมูลการเข้าเรียนตาม student_id
        $attendanceData = [];
        while ($row = $result->fetch_assoc()) {
            $attendanceData[$row['student_id']][] = $row;
        }

        // แสดงข้อมูลในตาราง
        foreach ($attendanceData as $studentData) {
            $studentName = htmlspecialchars($studentData[0]['student_name']);
            $html .= "<tr>";
            $html .= "<td>{$studentName}</td>";

            // แสดงข้อมูลการเข้าเรียนจาก 1 ถึง 18
            for ($i = 0; $i < 18; $i++) {
                if (isset($studentData[$i])) {
                    // กำหนดสถานะ
                    switch ($studentData[$i]['attendance_status']) {
                        case 0:
                            $status = 'มา';
                            break;
                        case 1:
                            $status = 'ขาด';
                            break;
                        case 2:
                            $status = 'ลา';
                            break;
                        case 3:
                            $status = 'มาสาย';
                            break;
                        default:
                            $status = '-'; // หากสถานะไม่ตรงกัน
                    }
                    $html .= "<td>" . htmlspecialchars($status) . "</td>";
                } else {
                    $html .= "<td>-</td>"; // แสดง - ถ้าไม่มีข้อมูล
                }
            }
            $html .= "</tr>";
        }

        if (empty($attendanceData)) {
            $html .= "<tr><td colspan='19' class='text-center'>ไม่มีข้อมูล</td></tr>";
        }

        $html .= '</tbody></table>';

        // เขียนเนื้อหาไปยัง PDF
        $mpdf->WriteHTML($html);

        // ส่ง PDF ไปยังผู้ใช้
        $mpdf->Output("รายงานการเข้าเรียน_{$course_id}.pdf", 'I'); // I = แสดงในเบราว์เซอร์
    } else {
        echo "ไม่มีข้อมูลสำหรับหลักสูตรนี้";
    }
} else {
    echo "ไม่พบรหัสวิชาที่ถูกต้อง";
}
