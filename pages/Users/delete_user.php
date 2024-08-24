<?php
// รวมไฟล์การเชื่อมต่อฐานข้อมูล
include '../includes/db_connection.php';

// รับค่า student_id จากพารามิเตอร์ URL
$student_id = $_GET['id'];

// คำสั่ง SQL สำหรับลบข้อมูล
$sql = "DELETE FROM students WHERE student_id = $student_id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Record deleted successfully'); window.location.href='system.php?page=ManageUsers';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
