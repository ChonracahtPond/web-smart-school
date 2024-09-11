<?php
// ตรวจสอบว่ามีการส่งฟอร์มแบบ POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $nnet_scores_id = $_POST['nnet_scores_id'];  // เปลี่ยนจาก student_id เป็น nnet_scores_id
    $score = $_POST['score'];
    $exam_date = $_POST['exam_date'];

    // ตรวจสอบความถูกต้องของข้อมูล
    if (empty($nnet_scores_id) || empty($score) || empty($exam_date)) {
        die('กรุณากรอกข้อมูลให้ครบถ้วน');
    }

    // ตรวจสอบว่ามีการส่งค่า nnet_scores_id มาอย่างถูกต้อง
    if (!is_numeric($nnet_scores_id)) {
        die('ข้อมูล nnet_scores_id ไม่ถูกต้อง');
    }

    // อัปเดตข้อมูลคะแนนในฐานข้อมูล
    $query = "UPDATE nnet_scores 
              SET score = ?, exam_date = ? 
              WHERE nnet_scores_id = ?";  // เปลี่ยน student_id เป็น nnet_scores_id

    // เตรียมคำสั่ง
    if ($stmt = $conn->prepare($query)) {
        // ผูกค่าพารามิเตอร์
        $stmt->bind_param('dsi', $score, $exam_date, $nnet_scores_id);  // ผูกค่ากับ nnet_scores_id

        // รันคำสั่ง SQL
        if ($stmt->execute()) {
            // หลังจากอัปเดตเสร็จให้ redirect ไปยังหน้าแสดงข้อมูล
            echo "<script>window.location.href='?page=scores_management&status=1';</script>";
        } else {
            // แจ้งข้อผิดพลาดหากไม่สามารถรันคำสั่ง SQL ได้
            echo "Error: " . $stmt->error;
        }

        // ปิด statement
        $stmt->close();
    } else {
        // แจ้งข้อผิดพลาดหากไม่สามารถเตรียม statement ได้
        echo "Error: " . $conn->error;
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
} else {
    // ถ้าไม่ใช่การส่งแบบ POST ให้ redirect ไปยังหน้าแสดงข้อมูล
    echo "<script>window.location.href='?page=scores_management&status=1';</script>";
}
?>
