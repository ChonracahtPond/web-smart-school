<?php

// รับ activity_id จาก URL
$activity_id = $_GET['id'];

// คำสั่ง SQL สำหรับลบกิจกรรม
$sql = "DELETE FROM activities WHERE activity_id='$activity_id'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Activity deleted successfully'); window.location.href='admin.php?page=Manage_Activity';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
