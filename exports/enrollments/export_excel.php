<?php
require '../vendor/autoload.php'; // Include the PhpSpreadsheet library
include('../../includes/db_connect.php'); // ตรวจสอบว่า path ถูกต้อง
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// รับค่าจาก GET
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// สร้าง Spreadsheet ใหม่
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// กำหนดหัวข้อคอลัมน์
$sheet->setCellValue('A1', 'student_id');
$sheet->setCellValue('B1', 'course_id');
$sheet->setCellValue('C1', 'semester');
$sheet->setCellValue('D1', 'academic_year');
$sheet->setCellValue('E1', 'grade');
$sheet->setCellValue('F1', 'status');
$sheet->setCellValue('G1', 'teacher_id');
$sheet->setCellValue('H1', 'class');
$sheet->setCellValue('I1', 'credits');

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT student_id, course_id, semester, academic_year, grade, status, teacher_id, class, credits 
        FROM enrollments WHERE created_at BETWEEN ? AND ? AND status = '0'";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('เตรียมคำสั่ง SQL ไม่สำเร็จ: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param('ss', $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows > 0) {
    $rowNumber = 2; // เริ่มต้นที่แถวที่ 2
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['student_id']);
        $sheet->setCellValue('B' . $rowNumber, $row['course_id']);
        $sheet->setCellValue('C' . $rowNumber, $row['semester']);
        $sheet->setCellValue('D' . $rowNumber, $row['academic_year']);
        $sheet->setCellValue('E' . $rowNumber, $row['grade']);
        $sheet->setCellValue('F' . $rowNumber, $row['status']);
        $sheet->setCellValue('G' . $rowNumber, $row['teacher_id']);
        $sheet->setCellValue('H' . $rowNumber, $row['class']);
        $sheet->setCellValue('I' . $rowNumber, $row['credits']);
        $rowNumber++;
    }
} else {
    // ถ้าไม่มีข้อมูลให้แสดงข้อความ
    $sheet->setCellValue('A2', 'ไม่มีข้อมูลที่ตรงตามเงื่อนไข');
}

// ตั้งค่าชื่อไฟล์
$filename = 'enrollments_' . date('Y-m-d') . '.xlsx';

// ส่งออกไฟล์ Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
exit;
