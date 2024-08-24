<?php
session_start();
include './includes/db_connect.php';

// รับข้อมูลจากฟอร์ม
$username = $_POST['username'];
$password = $_POST['password'];

// ตรวจสอบข้อมูลล็อกอิน
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // ตรวจสอบรหัสผ่าน
    if (password_verify($password, $user['password'])) {
        // ผู้ใช้ล็อกอินสำเร็จ
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role']; // เช่น 'admin', 'teacher', 'student'
        header("Location: pages/system.php");
        exit();
    } else {
        // ข้อมูลล็อกอินไม่ถูกต้อง
        echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
} else {
    // ข้อมูลล็อกอินไม่ถูกต้อง
    echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
}

$stmt->close();
$conn->close();
