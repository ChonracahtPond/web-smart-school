<?php
session_start(); // เริ่มต้นเซสชัน

// ล้างข้อมูลเซสชัน
session_unset();

// ทำลายเซสชัน
session_destroy();

// เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบ
header('Location: login.php');
exit;
