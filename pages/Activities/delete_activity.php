<?php

// รับ activity_id จาก URL
$activity_id = $_GET['id'];

// คำสั่ง SQL สำหรับลบกิจกรรม
$sql = "DELETE FROM activities WHERE activity_id='$activity_id'";

if ($conn->query($sql) === TRUE) {
    echo "<script> window.location.href='?page=Manage_Activity&status=1';</script>";
} else {
    // echo "Error: " . $sql . "<br>" . $conn->error;
    echo "<script> window.location.href='?page=Manage_Activity&status=0';</script>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
