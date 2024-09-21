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

    // Prepare SQL statement for exams table
    $stmt = $conn->prepare("INSERT INTO exams (enrollment_id, exam_type, exam_date, duration, total_marks, created_at, updated_at, student_id, score) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), ?, ?)");

    $countInserted = 0; // Initialize a counter for inserted rows

    // Loop through the data and insert it into the database
    foreach ($sheetData as $row) {
        // Skip the header row
        if ($row['A'] == 'enrollment_id') {
            continue;
        }

        // Bind parameters (assuming correct data types)
        $stmt->bind_param(
            'isssiis', // Correct number of types
            $row['A'], // enrollment_id
            $row['B'], // exam_type
            $row['C'], // exam_date
            $row['D'], // duration
            $row['E'], // total_marks
            $row['F'], // student_id
            $row['G']  // score
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
    echo "<script>alert('นำเข้าบันทึกเรียบร้อยแล้ว! $countInserted แถว');</script>";
    echo "<script>window.location.href='../../pages/education.php?page=Manage_exam_Midterm&status=1';</script>";
}
