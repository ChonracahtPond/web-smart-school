<?php
require '../vendor/autoload.php'; // Include the PhpSpreadsheet library
include('../../includes/db_connect.php'); // Ensure the path is correct

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the header row for the Excel file
$sheet->setCellValue('A1', 'grade_level')
    ->setCellValue('B1', 'section')
    ->setCellValue('C1', 'username')
    ->setCellValue('D1', 'password')
    ->setCellValue('E1', 'fullname')
    ->setCellValue('F1', 'nicknames')
    ->setCellValue('G1', 'email')
    ->setCellValue('H1', 'phone_number')
    ->setCellValue('I1', 'date_of_birth')
    ->setCellValue('J1', 'gender')
    ->setCellValue('K1', 'file_images')
    ->setCellValue('L1', 'status')
    ->setCellValue('M1', 'student_name')
    ->setCellValue('N1', 'national_id')
    ->setCellValue('O1', 'religion')
    ->setCellValue('P1', 'nationality')
    ->setCellValue('Q1', 'occupation')
    ->setCellValue('R1', 'average_income')
    ->setCellValue('S1', 'father_name')
    ->setCellValue('T1', 'father_nationality')
    ->setCellValue('U1', 'father_occupation')
    ->setCellValue('V1', 'mother_name')
    ->setCellValue('W1', 'mother_nationality')
    ->setCellValue('X1', 'mother_occupation')
    ->setCellValue('Y1', 'previous_education_level')
    ->setCellValue('Z1', 'graduation_year')
    ->setCellValue('AA1', 'graduation_school')
    ->setCellValue('AB1', 'district')
    ->setCellValue('AC1', 'province')
    ->setCellValue('AD1', 'buddhist_qualification')
    ->setCellValue('AE1', 'buddhist_qualification_year')
    ->setCellValue('AF1', 'buddhist_qualification_school')
    ->setCellValue('AG1', 'buddhist_district')
    ->setCellValue('AH1', 'buddhist_province')
    ->setCellValue('AI1', 'address')
    ->setCellValue('AJ1', 'student_id');

// Fetch data from the database
$sql = "SELECT grade_level, section, username, password, fullname, nicknames, email, phone_number, 
        date_of_birth, gender, file_images, status, student_name, national_id, religion, nationality, occupation, 
        average_income, father_name, father_nationality, father_occupation, mother_name, mother_nationality, 
        mother_occupation, previous_education_level, graduation_year, graduation_school, district, province, 
        buddhist_qualification, buddhist_qualification_year, buddhist_qualification_school, buddhist_district, 
        buddhist_province, address, student_id FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rowNumber = 2; // Start from the second row since the first row is the header

    // Populate the Excel sheet with data from the database
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['grade_level'])
            ->setCellValue('B' . $rowNumber, $row['section'])
            ->setCellValue('C' . $rowNumber, $row['username'])
            ->setCellValue('D' . $rowNumber, $row['password'])
            ->setCellValue('E' . $rowNumber, $row['fullname'])
            ->setCellValue('F' . $rowNumber, $row['nicknames'])
            ->setCellValue('G' . $rowNumber, $row['email'])
            ->setCellValue('H' . $rowNumber, $row['phone_number'])
            ->setCellValue('I' . $rowNumber, $row['date_of_birth'])
            ->setCellValue('J' . $rowNumber, $row['gender'])
            ->setCellValue('K' . $rowNumber, $row['file_images'])
            ->setCellValue('L' . $rowNumber, $row['status'])
            ->setCellValue('M' . $rowNumber, $row['student_name'])
            ->setCellValue('N' . $rowNumber, $row['national_id'])
            ->setCellValue('O' . $rowNumber, $row['religion'])
            ->setCellValue('P' . $rowNumber, $row['nationality'])
            ->setCellValue('Q' . $rowNumber, $row['occupation'])
            ->setCellValue('R' . $rowNumber, $row['average_income'])
            ->setCellValue('S' . $rowNumber, $row['father_name'])
            ->setCellValue('T' . $rowNumber, $row['father_nationality'])
            ->setCellValue('U' . $rowNumber, $row['father_occupation'])
            ->setCellValue('V' . $rowNumber, $row['mother_name'])
            ->setCellValue('W' . $rowNumber, $row['mother_nationality'])
            ->setCellValue('X' . $rowNumber, $row['mother_occupation'])
            ->setCellValue('Y' . $rowNumber, $row['previous_education_level'])
            ->setCellValue('Z' . $rowNumber, $row['graduation_year'])
            ->setCellValue('AA' . $rowNumber, $row['graduation_school'])
            ->setCellValue('AB' . $rowNumber, $row['district'])
            ->setCellValue('AC' . $rowNumber, $row['province'])
            ->setCellValue('AD' . $rowNumber, $row['buddhist_qualification'])
            ->setCellValue('AE' . $rowNumber, $row['buddhist_qualification_year'])
            ->setCellValue('AF' . $rowNumber, $row['buddhist_qualification_school'])
            ->setCellValue('AG' . $rowNumber, $row['buddhist_district'])
            ->setCellValue('AH' . $rowNumber, $row['buddhist_province'])
            ->setCellValue('AI' . $rowNumber, $row['address'])
            ->setCellValue('AJ' . $rowNumber, $row['student_id']);
        $rowNumber++;
    }
} else {
    echo "No records found!";
    exit;
}

// Set the headers to download the file as Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="student_data.xlsx"');
header('Cache-Control: max-age=0');

// Create a Writer object and output the file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Close the database connection
$conn->close();
