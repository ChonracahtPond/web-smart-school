<?php
// ตรวจสอบว่าแบบฟอร์มถูกส่งมา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า course_id, lesson_title, lesson_content, lesson_date จากฟอร์ม
    $course_id = $_POST['course_id'];
    $lesson_title = $_POST['lesson_title'];
    $lesson_content = $_POST['lesson_content'];
    $lesson_date = $_POST['lesson_date'];
    $status = '1'; // กำหนดค่าเริ่มต้นให้สถานะบทเรียนเป็น 1 หรือเปลี่ยนแปลงตามเงื่อนไขของระบบ

    // เตรียมคำสั่ง SQL เพื่อเพิ่มบทเรียนใหม่ในฐานข้อมูล
    $sql = "INSERT INTO lessons (course_id, lesson_title, lesson_content, lesson_date, status) 
            VALUES (?, ?, ?, ?, ?)";

    // เตรียมและ bind parameters
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("issss", $course_id, $lesson_title, $lesson_content, $lesson_date, $status);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<div class='bg-green-200 text-green-800 p-4 rounded'>เพิ่มบทเรียนสำเร็จ!</div>";
            echo "<script>window.location.href='?page=lesson_detail&id=$course_id&status=1';</script>"; // เปลี่ยนเส้นทางไปที่หน้าหลักสูตร
            exit();
        } else {
            echo "<div class='bg-red-200 text-red-800 p-4 rounded'>เกิดข้อผิดพลาด: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}
