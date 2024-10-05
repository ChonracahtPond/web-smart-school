<?php
require '../../includes/db_connect.php';  // รวมไฟล์เชื่อมต่อฐานข้อมูล
require_once '../vendor/autoload.php';  // โหลด PhpSpreadsheet ผ่าน autoload

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ตั้งค่าหัวตาราง
$sheet->setCellValue('A1', 'ชื่อ');  // คอลัมน์ที่ 1 เป็นชื่อ
for ($i = 1; $i <= 18; $i++) {
    $sheet->setCellValueByColumnAndRow($i + 1, 1, "สัปดาห์ $i");  // สัปดาห์ที่ 1 ถึง 18
}

// รับค่า course_id จาก URL หรือ POST
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

// ดึงข้อมูลจากฐานข้อมูล
if ($course_id > 0) {
    $sql = "SELECT 
                s.student_name, 
                a.lesson_id, 
                a.status AS attendance_status 
            FROM enrollments e 
            LEFT JOIN students s ON e.student_id = s.student_id 
            LEFT JOIN attendance a ON e.student_id = a.student_id 
            LEFT JOIN lessons l ON a.lesson_id = l.lesson_id
            WHERE e.course_id = ?
            ORDER BY s.student_id ASC, l.lesson_id ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // จัดกลุ่มข้อมูลตาม student_name และ lesson_id
        $rowIndex = 2; // เริ่มที่แถว 2 (แถวแรกเป็นหัวตาราง)
        $attendanceData = [];
        while ($row = $result->fetch_assoc()) {
            if (!isset($attendanceData[$row['student_name']])) {
                $attendanceData[$row['student_name']] = array_fill(1, 18, '-'); // เตรียมพื้นที่สำหรับ 18 สัปดาห์
            }
            // ปรับให้ข้อมูลเริ่มที่ lesson_id ตรงกับสัปดาห์
            $lessonWeek = intval($row['lesson_id']); // เปลี่ยน lesson_id ให้เป็นตัวเลขเพื่อแมปกับสัปดาห์
            if ($lessonWeek >= 1 && $lessonWeek <= 18) {
                $attendanceData[$row['student_name']][$lessonWeek] = $row['attendance_status'];
            }
        }

        // เติมข้อมูลลงใน Excel
        foreach ($attendanceData as $studentName => $lessons) {
            $sheet->setCellValueByColumnAndRow(1, $rowIndex, $studentName); // ชื่อในคอลัมน์แรก

            for ($i = 1; $i <= 18; $i++) {
                $status = $lessons[$i];  // ค่าของสัปดาห์ที่ 1 ถึง 18
                $sheet->setCellValueByColumnAndRow($i + 1, $rowIndex, $status);  // เติมข้อมูลในแต่ละสัปดาห์
            }
            $rowIndex++;
        }

        // สร้างไฟล์ Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'attendance_report.xlsx';

        // ส่งออกไฟล์
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    } else {
        echo "ไม่มีข้อมูลสำหรับหลักสูตรนี้";
    }
} else {
    echo "ไม่พบรหัสวิชาที่ถูกต้อง";
}
?>
