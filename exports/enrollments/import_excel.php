<?php
require '../vendor/autoload.php'; // Include the PhpSpreadsheet library
include('../../includes/db_connect.php'); // ตรวจสอบว่า path ถูกต้อง
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    // Load the Excel file
    $spreadsheet = IOFactory::load($file);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Prepare SQL statement without enrollment_id
    $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id, semester, academic_year, grade, status, teacher_id, class, credits) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $countInserted = 0; // Initialize a counter for inserted rows

    // Loop through the data and insert it into the database
    foreach ($sheetData as $row) {
        // Skip the header row
        if ($row['B'] == 'student_id') {
            continue;
        }

        // Bind parameters (assuming correct data types)
        $stmt->bind_param(
            'iisisssss',
            $row['B'], // student_id
            $row['C'], // course_id
            $row['D'], // semester
            $row['E'], // academic_year
            $row['F'], // grade
            $row['G'], // status
            $row['H'], // teacher_id
            $row['I'], // class
            $row['J']  // credits
        );

        // Execute the statement
        if ($stmt->execute()) {
            $countInserted++; // Increment counter on successful insert
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Display the number of rows inserted
    echo "<script>alert(' นำเข้าบันทึกเรียบร้อยแล้ว! $countInserted แถว');</script>";
    echo "<script>window.location.href='../../pages/education.php?page=Manage_enrollments&status=1';</script>";
}
