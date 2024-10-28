<?php

// ตรวจสอบว่าแบบฟอร์มถูกส่งมา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า lesson_id และ course_id จากฟอร์ม
    if (isset($_POST['lesson_id']) && !empty($_POST['lesson_id']) && isset($_POST['course_id']) && !empty($_POST['course_id'])) {
        $lesson_id = $_POST['lesson_id'];
        $course_id = $_POST['course_id']; // รับค่า course_id

        // เตรียมคำสั่ง SQL เพื่อลบบทเรียน
        $sql = "DELETE FROM lessons WHERE lesson_id = ?";

        // เตรียมและ bind parameters
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $lesson_id);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<div class='bg-green-200 text-green-800 p-4 rounded'>ลบบทเรียนสำเร็จ!</div>";
                echo "<script>window.location.href='?page=detali_classroom&id=$course_id&status=1';</script>"; // เปลี่ยนเส้นทางไปยังหน้าหลักสูตร
                exit();
            } else {
                echo "<div class='bg-red-200 text-red-800 p-4 rounded'>เกิดข้อผิดพลาด: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
    } else {
        echo "<div class='bg-red-200 text-red-800 p-4 rounded'>ไม่พบรหัสบทเรียนหรือหลักสูตรที่ต้องการลบ!</div>";
    }
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
