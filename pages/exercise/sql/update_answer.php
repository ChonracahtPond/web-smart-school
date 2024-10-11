<?php
// include "../../includes/db_connect.php";

$exercise_id = 4; // สมมุติว่าค่านี้เป็นค่าที่คุณต้องการใช้

// ตรวจสอบว่ามีการส่งข้อมูล POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $answer_id = $_POST['answer_id'];
    $answer_text = $_POST['answer_text'];
    $score = $_POST['score'];
    $is_correct = isset($_POST['is_correct']) ? ($_POST['is_correct'] === 'true' ? 1 : 0) : 0; // แปลงค่าเป็น 1 หรือ 0

    // สร้างคำสั่ง SQL สำหรับการอัปเดต
    $sql = "UPDATE answers SET answer_text=?, score=?, is_correct=? WHERE answer_id=?";

    // เตรียมคำสั่ง
    $stmt = $conn->prepare($sql);

    if ($stmt) { // ตรวจสอบว่าเตรียมคำสั่งได้สำเร็จ
        $stmt->bind_param("siis", $answer_text, $score, $is_correct, $answer_id);

        // ตรวจสอบและดำเนินการอัปเดต
        if ($stmt->execute()) {
            // ใช้ JavaScript เพื่อเปลี่ยนเส้นทาง
            echo '<script>
                    window.location.href="?page=show_exam&exercise_id=' . $exercise_id . '&status=1";
                  </script>';
            exit; // หยุดการทำงานของสคริปต์
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }

        // ปิดการเตรียมคำสั่ง
        $stmt->close();
    } else {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error;
    }
}

// ปิดการเชื่อมต่อ
$conn->close();
