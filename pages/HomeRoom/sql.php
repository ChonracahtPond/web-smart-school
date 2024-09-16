<?php


// ตรวจสอบว่ามีการล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    // ถ้าไม่มีการล็อกอินให้แสดงข้อความและส่งผู้ใช้ไปยังหน้าหลัก
    echo "<script>alert('กรุณาล็อกอินก่อนดำเนินการ'); window.location.href='?page=Home_Room';</script>";
    exit;
}

// ดึงค่า user_id จากเซสชัน
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomName = $conn->real_escape_string($_POST['roomName']);
    $roomPassword = $_POST['roomPassword'];
    $roomKey = bin2hex(random_bytes(16)); // Generating a unique key for the room

    // Hash the password before storing it
    $hashedPassword = password_hash($roomPassword, PASSWORD_DEFAULT);

    $sql = "INSERT INTO homeroom_meetings (room_name, room_password, room_key, user_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $roomName, $hashedPassword, $roomKey, $user_id);

    if ($stmt->execute()) {
        // Redirect with roomKey included in the URL
        echo "<script>window.location.href='?page=Room&status=1&roomKey=" . urlencode($roomKey) . "';</script>";
        exit;
    } else {
        // Error handling
        echo "<script>window.location.href='?page=Home_Room&status=0';</script>";
    }
}

// ตรวจสอบการลบห้องเรียน
if (isset($_GET['room_key']) && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $roomKey = $conn->real_escape_string($_GET['room_key']);
    $user_id = $_SESSION['user_id'];
    
    // สร้างคำสั่ง SQL สำหรับการลบห้องเรียน
    $sql = "DELETE FROM homeroom_meetings WHERE room_key = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // การเตรียมคำสั่ง SQL ล้มเหลว
        echo "<script>alert('เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL'); window.location.href='?page=Home_Room&status=0';</script>";
        exit;
    }

    $stmt->bind_param('ss', $roomKey, $user_id);
    $success = $stmt->execute();
    
    if ($success && $stmt->affected_rows > 0) {
        // ลบข้อมูลสำเร็จ
        echo "<script>window.location.href='?page=Home_Room&status=1';</script>";
    } else {
        // ข้อมูลไม่ถูกลบ หรือห้องเรียนไม่พบ
        echo "<script>alert('ไม่สามารถลบห้องเรียนได้'); window.location.href='?page=Home_Room&status=0';</script>";
    }
} elseif (isset($_GET['room_key']) && isset($_GET['action']) && $_GET['action'] === 'edit') {
    // แสดงข้อมูลห้องเรียนใน modal แก้ไข
    $roomKey = $conn->real_escape_string($_GET['room_key']);
    $user_id = $_SESSION['user_id'];
    
    $sql = "SELECT room_name, room_password FROM homeroom_meetings WHERE room_key = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // การเตรียมคำสั่ง SQL ล้มเหลว
        echo "<script>alert('เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL'); window.location.href='?page=Home_Room&status=0';</script>";
        exit;
    }

    $stmt->bind_param('ss', $roomKey, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc();
    
    if ($room) {
        // Render edit form or modal with pre-filled data
        // (Implement this part in your HTML/JavaScript)
    } else {
        // ห้องเรียนไม่พบ
        echo "<script>alert('ไม่พบข้อมูลห้องเรียน'); window.location.href='?page=Home_Room&status=0';</script>";
    }
}


// ตรวจสอบการอัปเดตห้องเรียน
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $roomKey = $conn->real_escape_string($_POST['roomKey']);
    $roomName = $conn->real_escape_string($_POST['roomName']);
    $roomPassword = $_POST['roomPassword'];

    // ถ้ามีการเปลี่ยนแปลงรหัสผ่านให้แฮชรหัสผ่านใหม่
    if (!empty($roomPassword)) {
        $hashedPassword = password_hash($roomPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE homeroom_meetings SET room_name = ?, room_password = ? WHERE room_key = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $roomName, $hashedPassword, $roomKey, $user_id);
    } else {
        $sql = "UPDATE homeroom_meetings SET room_name = ? WHERE room_key = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $roomName, $roomKey, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>window.location.href='?page=Home_Room&status=1';</script>";
    } else {
        echo "<script>window.location.href='?page=Home_Room&status=0';</script>";
    }
}

// ดึงข้อมูลห้องเรียนที่สร้างในวันที่ปัจจุบัน
$today = date('Y-m-d');
$sql = "SELECT room_name, room_key, created_at FROM homeroom_meetings WHERE user_id = ? AND DATE(created_at) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();
