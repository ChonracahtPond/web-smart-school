<?php
require_once '../vendor/autoload.php'; // ตรวจสอบว่า path ถูกต้อง
include('../../includes/db_connect.php'); // ตรวจสอบว่า path ถูกต้อง
error_reporting(E_ALL); // Enable all error reporting for debugging
ini_set('display_errors', 1); // Display errors for debugging

use PhpOffice\PhpSpreadsheet\IOFactory;

// Load the uploaded Excel file
if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['import_file']['tmp_name'];
    $fileType = $_FILES['import_file']['type'];

    // ตรวจสอบว่าไฟล์เป็น Excel
    if (
        $fileType != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' &&
        $fileType != 'application/vnd.ms-excel'
    ) {
        die("Invalid file type. Please upload an Excel file.");
    }

    // Load the spreadsheet
    $spreadsheet = IOFactory::load($fileTmpPath);
    $sheet = $spreadsheet->getActiveSheet();
    $highestRow = $sheet->getHighestRow();

    // Iterate through each row and import data
    $importedRows = 0;
    for ($row = 2; $row <= $highestRow; $row++) { // Start from the second row to skip headers
        // Retrieve cell values
        $values = [];
        for ($col = 'A'; $col <= 'AJ'; $col++) { // A to AJ (31 columns)
            $cellValue = $sheet->getCell($col . $row)->getValue();
            if ($cellValue === null) {
                $cellValue = ''; // Assign empty string if the cell is empty
            }
            $values[] = $cellValue;
        }

        // Debugging: Output the retrieved values
        echo "Row $row values: " . implode(", ", $values) . "<br>";

        // Check the number of imported columns
        if (count($values) !== 36) { // 36 columns (A to AJ)
            echo "Error: Row $row has " . count($values) . " values but expected 36.<br>";
            continue; // Skip this row
        }

        // Assigning values for clarity
        list(
            $student_id,
            $grade_level,
            $section,
            $username,
            $password,
            $status,
            $fullname,
            $nicknames,
            $email,
            $phone_number,
            $date_of_birth,
            $gender,
            $file_images,
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
        ) = $values;

        // Prepare the SQL statement
        $sql = "INSERT INTO students (
            student_id, grade_level, section, username, password, status, fullname, nicknames, email, phone_number, 
            date_of_birth, gender, file_images, student_name, national_id, religion, nationality, occupation, 
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
            'sssssssssssssssssssssssssssssssss',
            $student_id,
            $grade_level,
            $section,
            $username,
            $password,
            $status,
            $fullname,
            $nicknames,
            $email,
            $phone_number,
            $date_of_birth,
            $gender,
            $file_images,
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

        // Execute the statement and handle errors
        if ($stmt->execute()) {
            $importedRows++;
        } else {
            echo "Error importing row $row with values: " . implode(", ", $values) . " - " . $stmt->error . "<br>";
        }

        // Close the statement
        $stmt->close();
    }

    echo "Import complete. $importedRows rows imported.";
} else {
    $fileError = $_FILES['import_file']['error'] ?? 'Unknown error';
    echo "No file uploaded or upload error: $fileError";
}

$conn->close();
?>
