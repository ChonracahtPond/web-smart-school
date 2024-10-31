<?php
// ตรวจสอบว่าเป็นการร้องขอแบบ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // เชื่อมต่อกับฐานข้อมูล
    include 'db_connection.php'; // ปรับเปลี่ยนเส้นทางตามที่คุณต้องการ

    // รับ question_id ที่ต้องการลบ
    $question_id = $_POST['question_id'];

    // คำสั่ง SQL เพื่อลบคำถาม
    $sql = "DELETE FROM questions WHERE question_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $question_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'คำถามถูกลบเรียบร้อยแล้ว']);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบคำถาม']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'การร้องขอไม่ถูกต้อง']);
}
?>
