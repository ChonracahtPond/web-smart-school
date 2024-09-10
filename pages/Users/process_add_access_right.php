<?php
// Include database connection
include 'db_connection.php'; // ปรับเส้นทางให้ตรงกับไฟล์การเชื่อมต่อฐานข้อมูลของคุณ

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $student_id = $_POST['student_id'];
    $role = $_POST['role'];

    // Validate inputs
    if (empty($student_id) || empty($role)) {
        die("<div class='container mx-auto p-4 text-red-600 font-bold'>All fields are required.</div>");
    }

    // Prepare SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO access_rights (student_id, role) VALUES (?, ?)");
    if (!$stmt) {
        die("<div class='container mx-auto p-4 text-red-600 font-bold'>Prepare failed: " . $conn->error . "</div>");
    }

    // Bind parameters and execute
    $stmt->bind_param('ss', $student_id, $role);
    if ($stmt->execute()) {
        header('Location: index.php'); // เปลี่ยนเส้นทางไปยังหน้าที่คุณต้องการหลังจากการเพิ่มข้อมูล
        exit();
    } else {
        die("<div class='container mx-auto p-4 text-red-600 font-bold'>Execute failed: " . $stmt->error . "</div>");
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    die("<div class='container mx-auto p-4 text-red-600 font-bold'>Invalid request method.</div>");
}
?>
