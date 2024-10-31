<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $exercise_id = $_POST['exercise_id'];
    $question_text = $_POST['question_text'];
    $media_url = isset($_POST['media_url']) ? $_POST['media_url'] : null;
    $score = $_POST['score'];
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');
    $question_type = 'single_choice'; // กำหนดประเภทคำถามเป็น single_choice

    // ตรวจสอบว่ามีเพียงคำตอบเดียวที่มี is_correct เป็น 1
    $is_correct_values = array_count_values($_POST['is_correct']);
    if (isset($is_correct_values['1']) && $is_correct_values['1'] > 1) {
        die('ข้อผิดพลาด: ต้องมีคำตอบที่ถูกต้องเพียงข้อเดียว');
    }

    // บันทึกข้อมูลลงในตาราง questions
    $stmt = $conn->prepare("INSERT INTO questions (exercise_id, question_text, created_at, updated_at, question_type, media_url, score) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssi", $exercise_id, $question_text, $created_at, $updated_at, $question_type, $media_url, $score);

    if ($stmt->execute()) {
        // รับ ID ของคำถามที่เพิ่มล่าสุด
        $question_id = $conn->insert_id;

        // บันทึกคำตอบลงในตาราง answers
        $answers = $_POST['answer_text'];
        $is_corrects = $_POST['is_correct'];

        foreach ($answers as $index => $answer_text) {
            $is_correct = $is_corrects[$index];
            $answer_type = 'single_choice'; // ตั้งค่าประเภทคำตอบเป็น single_choice
            $answer_score = $is_correct == '1' ? $score : 0; // ให้คะแนนเฉพาะคำตอบที่ถูกต้อง

            $stmt = $conn->prepare("INSERT INTO answers (question_id, answer_text, is_correct, created_at, updated_at, answer_type, score) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isisssi", $question_id, $answer_text, $is_correct, $created_at, $updated_at, $answer_type, $answer_score);
            $stmt->execute();
        }

        // ปิดการเชื่อมต่อ
        $stmt->close();
        $conn->close();

        // ส่งกลับไปยังหน้าแรกพร้อมข้อความ
        // header('Location: index.php?message=คำถามและคำตอบถูกบันทึกเรียบร้อยแล้ว');
        echo "<script>window.location.href='?page=show_exam&exercise_id=$exercise_id&status=1';</script>";

        exit;
    } else {
        die('ข้อผิดพลาดในการบันทึกข้อมูลคำถาม: ' . $stmt->error);
    }
}
