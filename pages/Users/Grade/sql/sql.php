<?php
// รวมไฟล์การเชื่อมต่อฐานข้อมูล

// รับข้อมูล student_id จากคำขอ
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

// ตรวจสอบว่ามีการส่งค่า student_id
if ($student_id <= 0) {
    die("Invalid student ID");
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูล
$sql = "
    SELECT
        e.enrollment_id,
        e.student_id,
        e.course_id,
        e.semester,
        e.academic_year,
        e.grade,
        e.status,
        e.teacher_id,
        s.student_name,
        c.course_name,
        t.teacher_name,
        e.class,
        e.credits 
    FROM enrollments e
    JOIN students s ON e.student_id = s.student_id
    JOIN courses c ON e.course_id = c.course_id
    JOIN teachers t ON e.teacher_id = t.teacher_id
    WHERE e.student_id = ?
";


// เตรียมและดำเนินการคำสั่ง SQL
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

$stmt->bind_param('i', $student_id);
$stmt->execute();

// ตรวจสอบผลลัพธ์
$result = $stmt->get_result();
if (!$result) {
    die("SQL execute failed: " . $stmt->error);
}

// ดึงข้อมูลจากคำสั่ง SQL
$grades = [];
while ($row = $result->fetch_assoc()) {
    $grades[] = $row;
}

function get_class_name($class)
{
    switch ($class) {
        case 0:
            return "ว่าง";
        case 1:
            return "ประถม";
        case 2:
            return "มัธยมต้น";
        case 3:
            return "มัธยมปลาย";
        default:
            return "ไม่ระบุ";
    }
}


?>