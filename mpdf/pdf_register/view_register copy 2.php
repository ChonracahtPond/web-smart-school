<?php
require_once("../vendor/autoload.php");
include('../../includes/db_connect.php');
error_reporting(~E_NOTICE);

// ปิดการแสดงข้อผิดพลาดชั่วคราว
ini_set('display_errors', 0);

// mPDF configuration
$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
ini_set("pcre.backtrack_limit", "5000000");

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf'
        ]
    ],
    'default_font' => 'sarabun' // เลือกฟอนต์ที่ต้องการใช้
]);

// Get student ID from the query parameter
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($student_id > 0) {
    // Fetch student data from the database
    $sql = "SELECT * FROM register WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit();
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid student ID";
    exit();
}

// Create HTML content for the PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Details</title>
</head>
<body>
    <h1>Student Details</h1>
    <h2>Personal Information</h2>
    <p><strong>Grade Level:</strong> ' . htmlspecialchars($student['grade_level']) . '</p>
    <p><strong>Student Name:</strong> ' . htmlspecialchars($student['student_name']) . '</p>
    <p><strong>Nicknames:</strong> ' . htmlspecialchars($student['nicknames']) . '</p>
    <p><strong>Email:</strong> ' . htmlspecialchars($student['email']) . '</p>
    <p><strong>Phone Number:</strong> ' . htmlspecialchars($student['phone_number']) . '</p>
    <p><strong>Date of Birth:</strong> ' . htmlspecialchars($student['date_of_birth']) . '</p>
    <p><strong>Gender:</strong> ' . htmlspecialchars($student['gender']) . '</p>
    <p><strong>Status:</strong> ' . htmlspecialchars($student['status']) . '</p>

    <h2>Family Information</h2>
    <p><strong>Father\'s Name:</strong> ' . htmlspecialchars($student['father_name']) . '</p>
    <p><strong>Father\'s Nationality:</strong> ' . htmlspecialchars($student['father_nationality']) . '</p>
    <p><strong>Father\'s Occupation:</strong> ' . htmlspecialchars($student['father_occupation']) . '</p>
    <p><strong>Mother\'s Name:</strong> ' . htmlspecialchars($student['mother_name']) . '</p>
    <p><strong>Mother\'s Nationality:</strong> ' . htmlspecialchars($student['mother_nationality']) . '</p>
    <p><strong>Mother\'s Occupation:</strong> ' . htmlspecialchars($student['mother_occupation']) . '</p>

    <h2>Uploaded Documents</h2>
    <p><strong>Profile Image:</strong> <a href="../uploads/' . htmlspecialchars($student['file_images']) . '" target="_blank">View Image</a></p>
    <p><strong>House Document:</strong> <a href="../uploads/' . htmlspecialchars($student['ofhouse']) . '" target="_blank">View Document</a></p>
    <p><strong>ID Card:</strong> <a href="../uploads/' . htmlspecialchars($student['ofIDcard']) . '" target="_blank">View Document</a></p>
    <p><strong>Educational Qualification:</strong> <a href="../uploads/' . htmlspecialchars($student['ofeducationalqualification']) . '" target="_blank">View Document</a></p>
    <p><strong>Student Photo:</strong> <a href="../uploads/' . htmlspecialchars($student['photoofstudent']) . '" target="_blank">View Photo</a></p>
    <p><strong>Other Documents:</strong> <a href="../uploads/' . htmlspecialchars($student['ofotherdocuments']) . '" target="_blank">View Documents</a></p>
</body>
</html>
';

// Write the HTML content into the PDF
$mpdf->WriteHTML($html);

// Output the PDF to the browser
$mpdf->Output('student_details.pdf', 'I');
