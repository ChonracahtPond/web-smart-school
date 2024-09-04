<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบบทบาทของผู้ใช้
if ($_SESSION['user_role'] !== 'admin') {
    echo "คุณไม่มีสิทธิ์เข้าถึงหน้านี้";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแรก - เว็บไซต์การเรียนออนไลน์</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <h1>ยินดีต้อนรับสู่เว็บไซต์การเรียนออนไลน์</h1>
        <p>เนื้อหาหลักของเว็บไซต์จะอยู่ที่นี่</p>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>

</html>