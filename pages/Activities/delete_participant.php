<?php


// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $participant_id = $_POST['participant_id'];

    // คำสั่ง SQL สำหรับลบข้อมูล
    $delete_sql = "DELETE FROM activity_participants WHERE participant_id='$participant_id'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Activity deleted successfully'); window.location.href='admin.php?page=Manage_Credits';</script>";
    } else {
        echo "Error: " . $delete_sql . "<br>" . $conn->error;
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
