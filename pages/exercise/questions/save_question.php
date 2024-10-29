<?php

// รับข้อมูลจากฟอร์ม
$exercise_id = $_POST['exercise_id'];
$question_text = $_POST['question_text'];
$media_url = $_POST['media_url'];
$score = $_POST['score'];

// กำหนดเวลาสร้างและอัปเดต
$current_time = date('Y-m-d H:i:s');

// บันทึกข้อมูลลงในตาราง questions
$sql_question = "INSERT INTO questions (exercise_id, question_text, created_at, updated_at, question_type, media_url, score) 
VALUES (?, ?, ?, ?, 'single_choice', ?, ?)";

$stmt_question = $conn->prepare($sql_question);
$stmt_question->bind_param("issssi", $exercise_id, $question_text, $current_time, $current_time, $media_url, $score);

if ($stmt_question->execute()) {
    // รับ question_id ที่ถูกสร้าง
    $question_id = $stmt_question->insert_id;

    // บันทึกคำตอบที่ถูกส่งมาจากฟอร์ม
    if (!empty($_POST['answer_text'])) {
        foreach ($_POST['answer_text'] as $index => $answer_text) {
            $is_correct = isset($_POST['is_correct'][$index]) ? 1 : 0; // เช็คว่าคำตอบนั้นถูกต้องหรือไม่
            $sql_answer = "INSERT INTO answers (question_id, answer_text, is_correct, created_at, updated_at, answer_type, score) 
            VALUES (?, ?, ?, ?, ?, 'single_choice', ?)";

            $stmt_answer = $conn->prepare($sql_answer);
            $stmt_answer->bind_param("isissi", $question_id, $answer_text, $is_correct, $current_time, $current_time, $score);
            $stmt_answer->execute();
        }
    }

    // echo "บันทึกข้อมูลเรียบร้อยแล้ว!";
    echo "<script>window.location.href='?page=show_exam&exercise_id=$exercise_id&status=1';</script>";
} else {
    // echo "เกิดข้อผิดพลาด: " . $stmt_question->error;
    echo "<script>window.location.href='?page=show_exam&exercise_id=$exercise_id&status=0';</script>";
}

// ปิดการเชื่อมต่อ
$stmt_question->close();
$stmt_answer->close();
$conn->close();
