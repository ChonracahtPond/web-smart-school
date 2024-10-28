<?php

// ตรวจสอบว่ามีการส่งข้อมูล POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $lesson_id = isset($_POST['lesson_id']) ? intval($_POST['lesson_id']) : 0;
    $meeting_link = isset($_POST['meeting_link']) ? trim($_POST['meeting_link']) : '';
    $meeting_date = isset($_POST['meeting_date']) ? $_POST['meeting_date'] : '';
    $meeting_time = isset($_POST['meeting_time']) ? $_POST['meeting_time'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : 'active';

    // ตรวจสอบและปรับค่า meeting_link
    $youtube_prefix = "https://www.youtube.com/watch?v=";
    if (strpos($meeting_link, $youtube_prefix) === 0) {
        $meeting_link = str_replace($youtube_prefix, '', $meeting_link);
    }

    // ตรวจสอบค่าที่ได้รับ
    if (empty($meeting_link) || empty($meeting_date) || empty($meeting_time)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');</script>";
    } else {
        // เตรียม SQL statement
        $stmt = $conn->prepare("INSERT INTO online_meetings (lesson_id, meeting_link, meeting_date, meeting_time, status) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("issss", $lesson_id, $meeting_link, $meeting_date, $meeting_time, $status);

            // ประมวลผล SQL statement
            if ($stmt->execute()) {
                echo "<script>window.location.href='?page=lesson_detail&id=$lesson_id&status=1';</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาด: " . htmlspecialchars($stmt->error) . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการเตรียม SQL: " . htmlspecialchars($conn->error) . "');</script>";
        }
    }
}
