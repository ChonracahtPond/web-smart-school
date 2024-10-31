<?php
// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exercise_id = $_POST['exercise_id'];
    $question_text = $_POST['question_text'];
    $media_url = $_POST['media_url'] ?? '';
    $score = $_POST['score'];
    $question_type = "true/false";
    $answer_type = "true/false";

    // กำหนดว่าคำตอบไหนถูกต้อง
    $is_correct = ($_POST['true_false_answer'] === 'true') ? 1 : 0;

    // บันทึกคำถามลงในฐานข้อมูล
    $stmt = $conn->prepare("INSERT INTO questions (exercise_id, question_text, media_url, score, question_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $exercise_id, $question_text, $media_url, $score, $question_type);

    if ($stmt->execute()) {
        $question_id = $stmt->insert_id;

        // บันทึกคำตอบ True/False ลงในฐานข้อมูล
        $stmt_answer = $conn->prepare("INSERT INTO answers (question_id, answer_text, is_correct, score, answer_type) VALUES (?, ?, ?, ?, ?)");

        // กำหนดคำตอบ True/False
        $true_answer_text = "True";
        $false_answer_text = "False";

        // บันทึกคำตอบ True
        $stmt_answer->bind_param("isids", $question_id, $true_answer_text, $is_correct, $score, $answer_type);
        $stmt_answer->execute();

        // บันทึกคำตอบ False
        $is_correct_false = $is_correct === 1 ? 0 : 1; // ถ้าคำตอบ True ถูกต้อง ให้คำตอบ False ไม่ถูกต้อง
        $stmt_answer->bind_param("isids", $question_id, $false_answer_text, $is_correct_false, $score, $answer_type);
        $stmt_answer->execute();

        // ปิด statement
        $stmt_answer->close();
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error;
    }

    // ปิด statement และการเชื่อมต่อ
    $stmt->close();
    $conn->close();

    // ส่งกลับข้อความการบันทึกสำเร็จ
    echo "<script>window.location.href='?page=show_exam&exercise_id=$exercise_id';</script>";
    exit;
}
