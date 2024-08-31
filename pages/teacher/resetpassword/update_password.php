<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // คำสั่ง SQL สำหรับอัปเดตรหัสผ่าน
    $sql = "UPDATE teachers SET password = ? WHERE teacher_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_password, $teacher_id);

    if ($stmt->execute()) {
        echo "<script>window.location.href='?page=reset_password&status=1';</script>";
    } else {
        // echo "เกิดข้อผิดพลาด: " . $stmt->error;
        echo "<script>window.location.href='?page=reset_password&status=0';</script>";
    }

    $stmt->close();
}

$conn->close();
