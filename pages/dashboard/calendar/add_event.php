<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datatest"; // เปลี่ยนชื่อฐานข้อมูลของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการส่งข้อมูลผ่าน POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $title = $_POST['eventTitle'];
    $description = $_POST['eventDescription'];
    $start_date = $_POST['eventStartDate'];
    $end_date = $_POST['eventEndDate'] ?? null; // ใช้ null หากไม่มีวันสิ้นสุด

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare("INSERT INTO events (title, description, start_date, end_date, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssss", $title, $description, $start_date, $end_date);

    // ดำเนินการคำสั่ง SQL
    if ($stmt->execute()) {
        echo "Event created successfully";
        //  echo "<script>window.location.href='system.php?page=equipment_management&status=1';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // ปิดการเชื่อมต่อ
    $stmt->close();
    $conn->close();
}
