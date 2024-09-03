<?php
require_once '../vendor/autoload.php';
include('../../includes/db_connect.php');
error_reporting(E_ALL); // Enable all error reporting for debugging
ini_set('display_errors', 1); // Display errors for debugging

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Fetch student data with status = 0
$sql = "SELECT * FROM students WHERE status = 0";
$result = $conn->query($sql);

if ($result === false) {
    die('SQL error: ' . $conn->error); // Check for SQL query errors
}

if ($result->num_rows > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set sheet title
    $sheet->setTitle('Student Information');

    // Set column headers
    $headers = [
        'A1' => 'รหัสนักเรียน',
        'B1' => 'ระดับชั้น',
        'C1' => 'ห้องเรียน',
        'D1' => 'ชื่อผู้ใช้',
        'E1' => 'รหัสผ่าน',
        'F1' => 'ชื่อเต็ม',
        'G1' => 'ชื่อเล่น',
        'H1' => 'อีเมล',
        'I1' => 'หมายเลขโทรศัพท์',
        'J1' => 'วันเกิด',
        'K1' => 'เพศ',
        'L1' => 'ภาพถ่าย',
        'M1' => 'สถานะ',
        'N1' => 'ชื่อ-นามสกุล',
        'O1' => 'เลขบัตรประชาชน',
        'P1' => 'ศาสนา',
        'Q1' => 'สัญชาติ',
        'R1' => 'อาชีพ',
        'S1' => 'รายได้เฉลี่ยต่อปี',
        'T1' => 'ชื่อ-นามสกุล บิดา',
        'U1' => 'สัญชาติ บิดา',
        'V1' => 'อาชีพ บิดา',
        'W1' => 'ชื่อ-นามสกุล มารดา',
        'X1' => 'สัญชาติ มารดา',
        'Y1' => 'อาชีพ มารดา',
        'Z1' => 'ความรู้เดิมจบชั้น',
        'AA1' => 'ปี พ.ศ. ที่จบ',
        'AB1' => 'จากโรงเรียน',
        'AC1' => 'อำเภอ/เขต',
        'AD1' => 'จังหวัด',
        'AE1' => 'วุฒิทางธรรม',
        'AF1' => 'ปี พ.ศ. ที่จบ',
        'AG1' => 'จากสถานศึกษา',
        'AH1' => 'อำเภอ/เขต',
        'AI1' => 'จังหวัด',
        'AJ1' => 'ที่อยู่'
    ];

    foreach ($headers as $cell => $header) {
        $sheet->setCellValue($cell, $header);
    }

    // Add student data to the sheet
    $rowNumber = 2; // Start from the second row
    while ($student = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, htmlspecialchars($student['student_id']));
        $sheet->setCellValue('B' . $rowNumber, htmlspecialchars($student['grade_level']));
        $sheet->setCellValue('C' . $rowNumber, htmlspecialchars($student['section']));
        $sheet->setCellValue('D' . $rowNumber, htmlspecialchars($student['username']));
        $sheet->setCellValue('E' . $rowNumber, htmlspecialchars($student['password']));
        $sheet->setCellValue('F' . $rowNumber, htmlspecialchars($student['fullname']));
        $sheet->setCellValue('G' . $rowNumber, htmlspecialchars($student['nicknames']));
        $sheet->setCellValue('H' . $rowNumber, htmlspecialchars($student['email']));
        $sheet->setCellValue('I' . $rowNumber, htmlspecialchars($student['phone_number']));
        $sheet->setCellValue('J' . $rowNumber, htmlspecialchars($student['date_of_birth']));
        $sheet->setCellValue('K' . $rowNumber, htmlspecialchars($student['gender']));
        $sheet->setCellValue('L' . $rowNumber, htmlspecialchars($student['file_images']));
        $sheet->setCellValue('M' . $rowNumber, htmlspecialchars($student['status']));
        $sheet->setCellValue('N' . $rowNumber, htmlspecialchars($student['student_name']));
        $sheet->setCellValue('O' . $rowNumber, htmlspecialchars($student['national_id']));
        $sheet->setCellValue('P' . $rowNumber, htmlspecialchars($student['religion']));
        $sheet->setCellValue('Q' . $rowNumber, htmlspecialchars($student['nationality']));
        $sheet->setCellValue('R' . $rowNumber, htmlspecialchars($student['occupation']));
        $sheet->setCellValue('S' . $rowNumber, htmlspecialchars($student['average_income']));
        $sheet->setCellValue('T' . $rowNumber, htmlspecialchars($student['father_name']));
        $sheet->setCellValue('U' . $rowNumber, htmlspecialchars($student['father_nationality']));
        $sheet->setCellValue('V' . $rowNumber, htmlspecialchars($student['father_occupation']));
        $sheet->setCellValue('W' . $rowNumber, htmlspecialchars($student['mother_name']));
        $sheet->setCellValue('X' . $rowNumber, htmlspecialchars($student['mother_nationality']));
        $sheet->setCellValue('Y' . $rowNumber, htmlspecialchars($student['mother_occupation']));
        $sheet->setCellValue('Z' . $rowNumber, htmlspecialchars($student['previous_education_level']));
        $sheet->setCellValue('AA' . $rowNumber, htmlspecialchars($student['graduation_year']));
        $sheet->setCellValue('AB' . $rowNumber, htmlspecialchars($student['graduation_school']));
        $sheet->setCellValue('AC' . $rowNumber, htmlspecialchars($student['district']));
        $sheet->setCellValue('AD' . $rowNumber, htmlspecialchars($student['province']));
        $sheet->setCellValue('AE' . $rowNumber, htmlspecialchars($student['buddhist_qualification']));
        $sheet->setCellValue('AF' . $rowNumber, htmlspecialchars($student['buddhist_qualification_year']));
        $sheet->setCellValue('AG' . $rowNumber, htmlspecialchars($student['buddhist_qualification_school']));
        $sheet->setCellValue('AH' . $rowNumber, htmlspecialchars($student['buddhist_district']));
        $sheet->setCellValue('AI' . $rowNumber, htmlspecialchars($student['buddhist_province']));
        $sheet->setCellValue('AJ' . $rowNumber, htmlspecialchars($student['address']));
        $rowNumber++;
    }

    // Set the header to force download the file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="student_information.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
} else {
    echo "No records found";
}

$conn->close();
