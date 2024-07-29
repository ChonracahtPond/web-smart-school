<?php

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    // รับข้อมูลจากฟอร์ม
    $activity_id = $_POST['activity_id'];
    $student_id = $_POST['student_id'];
    $registration_date = $_POST['registration_date'];
    $status = $_POST['status'];
    $credits = $_POST['credits'];

    // คำสั่ง SQL สำหรับเพิ่มกิจกรรมใหม่
    $insert_sql = "INSERT INTO activity_participants (activity_id, student_id, registration_date, status, Credits) 
                   VALUES ('$activity_id', '$student_id', '$registration_date', '$status', '$credits')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('Activity added successfully'); window.location.href='admin.php?page=Manage_Credits';</script>";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
