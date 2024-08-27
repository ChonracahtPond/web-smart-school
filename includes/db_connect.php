<?php
$servername = "localhost";
$username = "root"; // ใช้ชื่อผู้ใช้ฐานข้อมูลของคุณ
$password = ""; // รหัสผ่านที่กำหนดใน Hostinger
$dbname = "datatest";



// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}
