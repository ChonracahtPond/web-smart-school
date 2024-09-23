<?php

// ตรวจสอบว่ามีการส่ง exam_id มาไหม
if (isset($_GET['id'])) {
    $exam_id = $_GET['id'];

    // เตรียม statement สำหรับการลบ
    $deleteSQL = "DELETE FROM exams WHERE exam_id = ?";
    $stmt = $conn->prepare($deleteSQL);
    $stmt->bind_param("i", $exam_id);

    // ลบข้อมูล
    if ($stmt->execute()) {
        echo "<script>window.location.href='?page=Manage_exam_Final&status=1';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // ปิด statement
    $stmt->close();
} else {
    echo "<script>window.location.href='?page=Manage_exam_Final&status=0';</script>";
}
