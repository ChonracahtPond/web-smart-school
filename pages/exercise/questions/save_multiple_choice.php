<?php
// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลคำถาม
    $exercise_id = $_POST['exercise_id'];
    $question_text = $_POST['question_text'];
    $media_url = $_POST['media_url'] ?? '';
    $score = $_POST['score'];
    $question_type = "multiple_choice";
    $answer_type = "multiple_choice";


    // ตรวจสอบว่ามีการส่งคำตอบและการกำหนดคำตอบที่ถูกต้องหรือไม่
    if (!isset($_POST['answer_text']) || !isset($_POST['is_correct'])) {
        echo 'ไม่มีข้อมูลคำตอบ กรุณาลองใหม่อีกครั้ง';
        exit;
    }

    // นับจำนวนคำตอบที่ถูกต้อง
    $is_corrects = $_POST['is_correct'];
    $correct_count = count(array_filter($is_corrects, fn($val) => $val === '1'));

    // ตรวจสอบว่ามีคำตอบที่ถูกต้องมากกว่า 0 ข้อ
    if ($correct_count === 0) {
        echo 'ต้องมีคำตอบที่ถูกต้องอย่างน้อย 1 ข้อ กรุณาตรวจสอบอีกครั้ง';
        exit;
    }

    // คำนวณคะแนนต่อคำตอบที่ถูกต้อง
    $score_per_correct_answer = $score / $correct_count;

    // บันทึกคำถามลงในฐานข้อมูล โดยกำหนด answer_type เป็น multiple_choice
    $stmt = $conn->prepare("INSERT INTO questions (exercise_id, question_text, media_url, score, question_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $exercise_id, $question_text, $media_url, $score, $question_type);

    if ($stmt->execute()) {
        // รับ question_id ที่เพิ่งบันทึกลงไป
        $question_id = $stmt->insert_id;

        // เตรียม statement สำหรับบันทึกคำตอบ
        $stmt = $conn->prepare("INSERT INTO answers (question_id, answer_text, is_correct, score , answer_type) VALUES (?, ?, ?, ? , ?)");

        // วนลูปบันทึกคำตอบทั้งหมด
        $answer_texts = $_POST['answer_text'];
        foreach ($answer_texts as $index => $answer_text) {
            $is_correct = isset($is_corrects[$index]) && $is_corrects[$index] === '1' ? 1 : 0;
            // กำหนดคะแนนต่อคำตอบถ้าคำตอบนั้นถูกต้อง
            $answer_score = $is_correct ? $score_per_correct_answer : 0;
            $stmt->bind_param("isids", $question_id, $answer_text, $is_correct, $answer_score, $answer_type);
            $stmt->execute();
        }

        $stmt->close();
        $conn->close();

        // ส่งกลับข้อความการบันทึกสำเร็จ
        $message = "บันทึกข้อมูลสำเร็จแล้ว!";
        echo "<script>window.location.href='?page=show_exam&exercise_id=$exercise_id&status=1';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }
}
