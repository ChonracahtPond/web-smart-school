<?php

// ตรวจสอบว่ามีการส่ง meeting_id มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['meeting_id'])) {
    // รับค่า meeting_id
    $lesson_id = isset($_POST['lesson_id']) ? intval($_POST['lesson_id']) : 0;
    $meeting_id = intval($_POST['meeting_id']);

    // ตรวจสอบว่า meeting_id ไม่เป็นค่าว่างหรือไม่ถูกต้อง
    if ($meeting_id > 0) {
        // เตรียมคำสั่ง SQL สำหรับลบข้อมูล
        $stmt = $conn->prepare("DELETE FROM online_meetings WHERE meeting_id = ?");

        // ตรวจสอบว่าคำสั่ง SQL เตรียมสำเร็จหรือไม่
        if ($stmt) {
            $stmt->bind_param("i", $meeting_id);

            // ประมวลผลคำสั่ง SQL
            if ($stmt->execute()) {
                // echo "<script>alert('ลบข้อมูลการประชุมสำเร็จ'); window.location.href='?page=lesson_detail&id=" . $_GET['lesson_id'] . "';</script>";
                echo "<script>window.location.href='?page=lesson_detail&id=$lesson_id&status=1';</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาด: ไม่สามารถลบข้อมูลการประชุมได้');</script>";
            }

            // ปิดคำสั่ง SQL
            $stmt->close();
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL');</script>";
        }
    } else {
        echo "<script>alert('ID ของการประชุมไม่ถูกต้อง');</script>";
    }
} else {
    echo "<script>alert('ไม่มีข้อมูลการประชุมที่ต้องการลบ');</script>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
