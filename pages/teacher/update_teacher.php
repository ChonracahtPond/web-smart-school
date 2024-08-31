<?php
// ตรวจสอบว่าข้อมูลถูกส่งมาจริงหรือไม่
$teacher_id = isset($_POST['teacher_id']) ? $conn->real_escape_string($_POST['teacher_id']) : '';
$fname = isset($_POST['Fname']) ? $conn->real_escape_string($_POST['Fname']) : '';
$lname = isset($_POST['Lname']) ? $conn->real_escape_string($_POST['Lname']) : '';
$rank = isset($_POST['Rank']) ? $conn->real_escape_string($_POST['Rank']) : '';
$position = isset($_POST['position']) ? $conn->real_escape_string($_POST['position']) : '';
$address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : '';
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
$images = isset($_POST['images']) ? $conn->real_escape_string($_POST['images']) : '';
$phone = isset($_POST['phone']) ? (int)$_POST['phone'] : 0;
$gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : '';
$teacher_name = isset($_POST['teacher_name']) ? $conn->real_escape_string($_POST['teacher_name']) : '';


// เตรียมคำสั่ง SQL สำหรับอัปเดตข้อมูล
$sql = "UPDATE teachers SET 
        Fname='$fname', 
        Lname='$lname', 
        Rank='$rank', 
        position='$position', 
        address='$address', 
        email='$email', 
        username='$username', 
        images='$images', 
        phone='$phone', 
        gender='$gender', 
        teacher_name='$teacher_name' 
        WHERE teacher_id='$teacher_id'";

// ดำเนินการคำสั่ง SQL
if ($conn->query($sql) === TRUE) {
    // echo "ข้อมูลบุคลากรถูกอัปเดตเรียบร้อยแล้ว";
    echo "<script>window.location.href='?page=Teacher_Manage&status=1';</script>";
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}
