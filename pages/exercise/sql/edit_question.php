<?php
// ตรวจสอบว่าเป็นการร้องขอแบบ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // เชื่อมต่อกับฐานข้อมูล

    // รับข้อมูลจากฟอร์ม
    $question_id = $_POST['question_id'];
    $question_text = $_POST['question_text'];
    $question_type = $_POST['question_type'];
    $score = $_POST['score'];

    // คำสั่ง SQL เพื่ออัปเดตข้อมูลคำถาม
    $sql = "UPDATE questions SET question_text = ?, question_type = ?, score = ? WHERE question_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $question_text, $question_type, $score, $question_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'คำถามถูกแก้ไขเรียบร้อยแล้ว']);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการแก้ไขคำถาม']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'การร้องขอไม่ถูกต้อง']);
}
