<?php
require '../vendor/autoload.php'; // Include the PhpSpreadsheet library
include('../../includes/db_connect.php'); // Ensure the path is correct

use PhpOffice\PhpSpreadsheet\IOFactory;

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['import_file'])) {
    $file = $_FILES['import_file']['tmp_name'];

    // Load the Excel file
    $spreadsheet = IOFactory::load($file);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO students (
        grade_level, section, username, password, fullname, nicknames, email, phone_number, 
        date_of_birth, gender, file_images, status, student_name, national_id, religion, 
        nationality, occupation, average_income, father_name, father_nationality, 
        father_occupation, mother_name, mother_nationality, mother_occupation, 
        previous_education_level, graduation_year, graduation_school, district, province, 
        buddhist_qualification, buddhist_qualification_year, buddhist_qualification_school, 
        buddhist_district, buddhist_province, address
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? 
    )");

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $countInserted = 0; // Initialize a counter for inserted rows

    // Loop through the data and insert it into the database
    foreach ($sheetData as $row) {
        // Skip the header row
        if ($row['A'] == 'grade_level') {
            continue;
        }

        // Check if status is empty and assign a default value if it is
        $status = !empty($row['L']) ? $row['L'] : 'active'; // Replace 'active' with your default status

        // Bind parameters
        $stmt->bind_param(
            'sssssssssssssssssssssssssssssssssss',
            $row['A'], // grade_level
            $row['B'], // section
            $row['C'], // username
            $row['D'], // password
            $row['E'], // fullname
            $row['F'], // nicknames
            $row['G'], // email
            $row['H'], // phone_number
            $row['I'], // date_of_birth
            $row['J'], // gender
            $row['K'], // file_images
            $status,   // status (using the variable instead of $row['L'])
            $row['M'], // student_name
            $row['N'], // national_id
            $row['O'], // religion
            $row['P'], // nationality
            $row['Q'], // occupation
            $row['R'], // average_income
            $row['S'], // father_name
            $row['T'], // father_nationality
            $row['U'], // father_occupation
            $row['V'], // mother_name
            $row['W'], // mother_nationality
            $row['X'], // mother_occupation
            $row['Y'], // previous_education_level
            $row['Z'], // graduation_year
            $row['AA'], // graduation_school
            $row['AB'], // district
            $row['AC'], // province
            $row['AD'], // buddhist_qualification
            $row['AE'], // buddhist_qualification_year
            $row['AF'], // buddhist_qualification_school
            $row['AG'], // buddhist_district
            $row['AH'], // buddhist_province
            $row['AI']  // address
        );

        // Execute the statement
        if ($stmt->execute()) {
            $countInserted++; // Increment counter on successful insert
        } else {
            echo "Error importing row with values: " . implode(", ", $row) . " - " . $stmt->error . "<br>";
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Display the number of rows inserted
    // echo "<script>alert('นำเข้าบันทึกเรียบร้อยแล้ว! $countInserted แถว');</script>";
    // echo "<script>window.location.href='../../pages/education.php?page=Manage_students&status=1';</script>";
} else {
    // echo "<script>alert('ไม่พบไฟล์ที่อัปโหลดหรือเกิดข้อผิดพลาดในการอัปโหลด');</script>";
}
