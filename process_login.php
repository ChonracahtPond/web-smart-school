<?php
session_start();
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน.";
        exit();
    }

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];

            // Set status and redirect with a script
            echo "<script>
                localStorage.setItem('status', 'success');
                window.location.href = 'pages/system.php';
            </script>";
            exit();
        } else {
            echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }

    $stmt->close();
} else {
    echo "ไม่สามารถเข้าถึงหน้านี้โดยตรงได้.";
}

$conn->close();
