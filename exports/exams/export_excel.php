<?php
require '../vendor/autoload.php'; // Include the PhpSpreadsheet library
include('../../includes/db_connect.php'); // ตรวจสอบว่า path ถูกต้อง
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// รับค่าจาก URL
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// ตรวจสอบว่ามีการส่งวันที่หรือไม่
if ($startDate && $endDate) {
    // ดึงข้อมูลการสอบตามวันที่เริ่มต้นและสิ้นสุด
    $sql = "SELECT e.exam_id, e.enrollment_id, e.exam_type, e.exam_date, e.duration, e.total_marks, e.created_at, e.updated_at,e.criterion, e.exams_status, e.student_id, e.score, s.student_name, en.course_id
            FROM exams e
            JOIN students s ON e.student_id = s.student_id
            JOIN enrollments en ON e.enrollment_id = en.enrollment_id
            WHERE e.exam_date BETWEEN ? AND ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
    }

    // Binding parameters
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("กรุณากรอกวันที่เริ่มต้นและสิ้นสุด");
}

// สร้าง Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ตั้งชื่อหัวตาราง
$sheet->setCellValue('A1', 'รหัสการสอบ');
$sheet->setCellValue('B1', 'รหัสรายวิชา');
$sheet->setCellValue('C1', 'ชื่อผู้เรียน');
$sheet->setCellValue('D1', 'ประเภทการสอบ');
$sheet->setCellValue('E1', 'วันที่สอบ');
$sheet->setCellValue('F1', 'คะแนนเต็ม');
$sheet->setCellValue('G1', 'เกณฑ์การผ่าน');
$sheet->setCellValue('H1', 'คะแนนการสอบ');
$sheet->setCellValue('I1', 'สถานะ');

// เติมข้อมูลจากฐานข้อมูล
$rowNumber = 2; // เริ่มที่แถวที่ 2
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNumber, $row['exam_id']);
    $sheet->setCellValue('B' . $rowNumber, $row['enrollment_id']);
    $sheet->setCellValue('C' . $rowNumber, $row['student_name']);
    $sheet->setCellValue('D' . $rowNumber, $row['exam_type']);
    $sheet->setCellValue('E' . $rowNumber, $row['exam_date']);
    $sheet->setCellValue('F' . $rowNumber, $row['total_marks']);
    $sheet->setCellValue('G' . $rowNumber, $row['criterion']);
    $sheet->setCellValue('H' . $rowNumber, $row['score']);
    $sheet->setCellValue('I' . $rowNumber, $row['exams_status']);
    $rowNumber++;
}

// ตั้งค่าหัวข้อของการส่งออก
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="exams_data.xlsx"');
header('Cache-Control: max-age=0');

// ส่งออกไฟล์
$writer->save('php://output');
exit;
