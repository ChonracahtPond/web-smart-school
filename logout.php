<?php
session_start(); // เริ่มต้นการใช้งานเซสชัน

// ลบข้อมูลเซสชันทั้งหมด
session_unset();

// ทำลายเซสชัน
session_destroy();

// รีไดเรกต์ผู้ใช้ไปยังหน้าล็อกอินพร้อมกับพารามิเตอร์สถานะ
header("Location: login.php?status=success");
exit();
