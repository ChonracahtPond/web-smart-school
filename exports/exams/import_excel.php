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
    $stmt = $conn->prepare("INSERT INTO exams (enrollment_id, exam_type, exam_date, total_marks, student_id, score , criterion , exams_status) VALUES (?, ?, ?, ?, ?, ?,?, ?)");

    $countInserted = 0; // Initialize a counter for inserted rows

    // Loop through the data and insert it into the database
    foreach ($sheetData as $row) {
        // Skip the header row
        if ($row['A'] == 'enrollment_id') {
            continue;
        }

        // Get values
        // $enrollment_id = $row['A'];
        // $exam_type = $row['B'];
        // $exam_date = $row['C'];
        // $duration = $row['D'];
        // $total_marks = $row['E'];
        // $student_id = $row['F'];
        // $score = $row['G'];
        // $criterion = $row['H'];

        $enrollment_id = $row['A'];
        $exam_type = $row['B'];
        $student_id = $row['C'];
        $exam_date = $row['D'];
        $total_marks = $row['E'];
        $criterion = $row['F'];
        $score = $row['G'];


        // Check if enrollment_id is not empty
        if (empty($enrollment_id)) {
            echo "Enrollment ID cannot be empty in row: " . implode(", ", $row) . "<br>";
            continue; // Skip this row
        }

        // ======================== คำนวน ========================

        $status = "ไม่ผ่าน"; // ตั้งค่าเริ่มต้นเป็น "ไม่ผ่าน"

        if (strpos($criterion, '%') !== false) { // ตรวจสอบว่ามี "%" หรือไม่
            // ลบเครื่องหมาย '%' ออก
            $cleanedCriterion = str_replace('%', '', $criterion);
            $total = $total_marks * ($cleanedCriterion / 100);

            // ตรวจสอบว่าคะแนนผ่านหรือไม่
            if ($score >= $total) {
                $status = "ผ่าน"; // หากคะแนนมากกว่าหรือเท่ากับเกณฑ์ที่คำนวณได้ แสดงว่าผ่าน
            }
        } else {
            if ($score >= $criterion) {
                $status = "ผ่าน"; // หากคะแนนมากกว่าหรือเท่ากับเกณฑ์ที่คำนวณได้ แสดงว่าผ่าน
            }
        }
        // เก็บค่า exams_status เป็นผลลัพธ์
        $exams_status = $status;
        // ======================== คำนวน ========================


        // Bind parameters (assuming correct data types)
        $stmt->bind_param(
            'isisisis', // Correct number of types
            $enrollment_id, // enrollment_id
            $exam_type, // exam_type
            $student_id, // student_id
            $exam_date, // exam_date
            // $duration, // duration
            $total_marks, // total_marks
            $criterion, // score
            $score, // score
            $exams_status

        );

        // Execute the statement
        if ($stmt->execute()) {
            $countInserted++; // Increment counter on successful insert
        } else {
            echo "Error inserting row: " . $stmt->error . "<br>"; // Show error if insert fails
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Display the number of rows inserted
    echo "<script>alert('นำเข้าบันทึกเรียบร้อยแล้ว! $countInserted แถว');</script>";
    echo "<script>window.location.href='../../pages/education.php?page=Manage_exam_Midterm&status=1';</script>";
}
