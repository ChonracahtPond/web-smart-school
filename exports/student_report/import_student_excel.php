<?php
require_once '../vendor/autoload.php'; // ตรวจสอบว่า path ถูกต้อง
include('../../includes/db_connect.php'); // ตรวจสอบว่า path ถูกต้อง
error_reporting(E_ALL); // Enable all error reporting for debugging
ini_set('display_errors', 1); // Display errors for debugging

use PhpOffice\PhpSpreadsheet\IOFactory;

// Load the uploaded Excel file
if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['import_file']['tmp_name'];

    // Load the spreadsheet
    $spreadsheet = IOFactory::load($fileTmpPath);
    $sheet = $spreadsheet->getActiveSheet();
    $highestRow = $sheet->getHighestRow();

    // Iterate through each row and import data
    $importedRows = 0;
    for ($row = 2; $row <= $highestRow; $row++) { // Start from the second row to skip headers
        $student_id = $sheet->getCell('A' . $row)->getValue();
        // ... (other fields)

        // Insert data into the database
        $sql = "INSERT INTO students (
            student_id, grade_level, section, username, password, fullname, nicknames, email, phone_number, 
            date_of_birth, gender, file_images, status, student_name, national_id, religion, nationality, occupation, 
            average_income, father_name, father_nationality, father_occupation, mother_name, mother_nationality, 
            mother_occupation, previous_education_level, graduation_year, graduation_school, district, province, 
            buddhist_qualification, buddhist_qualification_year, buddhist_qualification_school, buddhist_district, 
            buddhist_province, address
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param(
            'ssssssssssssssssssssssssssssssssss',
            $student_id,
            $grade_level,
            $section,
            $username,
            $password,
            $fullname,
            $nicknames,
            $email,
            $phone_number,
            $date_of_birth,
            $gender,
            $file_images,
            $status,
            $student_name,
            $national_id,
            $religion,
            $nationality,
            $occupation,
            $average_income,
            $father_name,
            $father_nationality,
            $father_occupation,
            $mother_name,
            $mother_nationality,
            $mother_occupation,
            $previous_education_level,
            $graduation_year,
            $graduation_school,
            $district,
            $province,
            $buddhist_qualification,
            $buddhist_qualification_year,
            $buddhist_qualification_school,
            $buddhist_district,
            $buddhist_province,
            $address
        );

        if ($stmt->execute()) {
            $importedRows++;
        } else {
            echo "Error importing row $row: " . $stmt->error . "<br>";
        }
    }

    echo "Import complete. $importedRows rows imported.";
} else {
    $fileError = $_FILES['import_file']['error'] ?? 'Unknown error';
    echo "No file uploaded or upload error: $fileError";
}

$conn->close();
