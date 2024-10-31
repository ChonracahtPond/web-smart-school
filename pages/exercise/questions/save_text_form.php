<?php

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exercise_id = $_POST['exercise_id'];
    $question_text = $_POST['question_text'];
    $media_url = $_POST['media_url'] ?? '';
    $score = $_POST['score'];
    $question_type = "text";
    $answer_type = "text";

    // บันทึกคำถามลงในฐานข้อมูล
    $stmt = $conn->prepare("INSERT INTO questions (exercise_id, question_text, media_url, score, question_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $exercise_id, $question_text, $media_url, $score, $question_type);

    if ($stmt->execute()) {
        $question_id = $stmt->insert_id;

        // บันทึกคำตอบแบบข้อความ
        $answer_text = $_POST['answer_text_text']; // รับข้อความคำตอบ
        $is_correct = 0; // เนื่องจากคำตอบแบบข้อความอาจไม่ต้องการการกำหนดว่าถูกหรือผิด

        // บันทึกคำตอบลงในฐานข้อมูล
        $stmt_answer = $conn->prepare("INSERT INTO answers (question_id, answer_text, is_correct, score, answer_type) VALUES (?, ?, ?, ?, ?)");
        $stmt_answer->bind_param("isids", $question_id, $answer_text, $is_correct, $score, $answer_type);
        $stmt_answer->execute();

        // ปิด statement
        $stmt_answer->close();
        $stmt->close();
        $conn->close();

        // ส่งกลับข้อความการบันทึกสำเร็จ
        echo "<script>window.location.href='?page=show_exam&exercise_id=$exercise_id';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error;
    }

    // ปิดการเชื่อมต่อ
    $stmt->close();
    $conn->close();
}
