<?php

// รับค่า student_id จากพารามิเตอร์ URL
$student_id = $_GET['id'];

// คำสั่ง SQL สำหรับลบข้อมูล
$sql = "DELETE FROM students WHERE student_id = $student_id";

if ($conn->query($sql) === TRUE) {
    echo "<script>window.location.href='?page=Manage_student&status=1';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    echo "<script>window.location.href='?page=Manage_student&status=0';</script>";

}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
