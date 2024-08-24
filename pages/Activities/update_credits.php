<?php

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $participant_id = $_POST['participant_id'];
    $new_credits = $_POST['credits'];

    // คำสั่ง SQL สำหรับอัพเดตเครดิต
    $update_sql = "UPDATE activity_participants SET Credits='$new_credits' WHERE participant_id='$participant_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Credits updated successfully'); window.location.href='system.php?page=Manage_Credits';</script>";
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
