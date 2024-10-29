<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignment_id'])) {
    $lesson_id = isset($_POST['lesson_id']) ? intval($_POST['lesson_id']) : 0;
    $assignment_id = intval($_POST['assignment_id']);

    if ($assignment_id > 0) {
        $stmt = $conn->prepare("DELETE FROM assignments WHERE assignment_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $assignment_id);
            if ($stmt->execute()) {
                // echo "<script>alert('ลบการบ้านสำเร็จ'); window.location.href='?page=assignments';</script>";
                echo "<script>window.location.href='?page=lesson_detail&id=$lesson_id&status=1';</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการลบการบ้าน');</script>";
            }
            $stmt->close();
        }
    }
}
$conn->close();
