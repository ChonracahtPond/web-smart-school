<?php
require '../vendor/autoload.php'; // Include PhpSpreadsheet library
include('../../includes/db_connect.php'); // ตรวจสอบว่า path ถูกต้อง
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// สร้าง Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ตั้งชื่อหัวตาราง
$sheet->setCellValue('A1', 'รหัสรายวิชา');
$sheet->setCellValue('B1', 'ประเภทการสอบ');
// $sheet->setCellValue('B1', 'ชื่อผู้เรียน');
$sheet->setCellValue('C1', 'รหัสนักเรียน');
$sheet->setCellValue('D1', 'วันที่สอบ');
$sheet->setCellValue('E1', 'คะแนนเต็ม');
$sheet->setCellValue('F1', 'เกณฑ์การผ่าน');
$sheet->setCellValue('G1', 'คะแนน');
// $sheet->setCellValue('H1', 'คะแนน');

// ป้อนข้อมูลตัวอย่าง หรือปล่อยว่าง
$rowNumber = 2; // เริ่มที่แถวที่ 2
// ตัวอย่างข้อมูล
$exampleData = [
    ['001', 'กลางภาค', '1',  '2023-09-15', '100', '20 หรือ 20%', '85'],
];

foreach ($exampleData as $data) {
    $sheet->setCellValue('A' . $rowNumber, $data[0]);
    $sheet->setCellValue('B' . $rowNumber, $data[1]);
    $sheet->setCellValue('C' . $rowNumber, $data[2]);
    $sheet->setCellValue('D' . $rowNumber, $data[3]);
    $sheet->setCellValue('E' . $rowNumber, $data[4]);
    $sheet->setCellValue('F' . $rowNumber, $data[5]);
    $sheet->setCellValue('G' . $rowNumber, $data[6]);
    $rowNumber++;
}

// ตั้งค่าหัวข้อของการส่งออก
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="exam_form.xlsx"');
header('Cache-Control: max-age=0');

// ส่งออกไฟล์
$writer->save('php://output');
exit;
