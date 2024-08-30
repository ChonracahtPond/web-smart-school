<?php
require 'vendor/autoload.php'; // ใช้ Composer autoload
include "../includes/db_connect.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


// Default sorting order
$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'item_name';
$orderDirection = isset($_GET['order_dir']) && $_GET['order_dir'] === 'desc' ? 'desc' : 'asc';

// Default search term
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Build SQL query with search filter
$sql = "SELECT * FROM items WHERE item_name LIKE '%$search%' OR item_description LIKE '%$search%' OR status LIKE '%$search%' ORDER BY $orderBy $orderDirection";
$result = $conn->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header
$sheet->setCellValue('A1', 'ชื่อรายการ');
$sheet->setCellValue('B1', 'คำอธิบาย');
$sheet->setCellValue('C1', 'หมวดหมู่');
$sheet->setCellValue('D1', 'ปริมาณ');
$sheet->setCellValue('E1', 'หน่วย');
$sheet->setCellValue('F1', 'ตำแหน่งที่เก็บ');
$sheet->setCellValue('G1', 'วันที่ซื้อ');
$sheet->setCellValue('H1', 'ผู้จัดหา');
$sheet->setCellValue('I1', 'ราคาซื้อ');
$sheet->setCellValue('J1', 'สถานะ');

// Add data
$rowNum = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNum, $row['item_name']);
    $sheet->setCellValue('B' . $rowNum, $row['item_description']);
    $sheet->setCellValue('C' . $rowNum, $row['category']);
    $sheet->setCellValue('D' . $rowNum, $row['quantity']);
    $sheet->setCellValue('E' . $rowNum, $row['unit']);
    $sheet->setCellValue('F' . $rowNum, $row['location']);
    $sheet->setCellValue('G' . $rowNum, $row['purchase_date']);
    $sheet->setCellValue('H' . $rowNum, $row['supplier']);
    $sheet->setCellValue('I' . $rowNum, $row['purchase_price']);
    $sheet->setCellValue('J' . $rowNum, $row['status']);
    $rowNum++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'items_report.xlsx';

// Send file to browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
