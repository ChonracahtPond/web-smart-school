<?php
require_once 'config.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ตรวจสอบว่ามีการส่ง ID มาหรือไม่
    if (isset($_POST['id'])) {
        $student_id = $_POST['id'];

        // สร้างคิวรี SQL สำหรับลบข้อมูล
        $query = "DELETE FROM nnet_scores WHERE student_id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("i", $student_id);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $stmt->close();
        $conn->close();

        // ส่งผู้ใช้กลับไปที่หน้าหลักพร้อมกับสถานะการลบ
        header('Location: ?page=scores_management&status=deleted');
        exit();
    } else {
        die("Invalid request");
    }
} else {
    die("Invalid request method");
}
