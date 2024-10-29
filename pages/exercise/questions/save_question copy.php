<?php

// รับค่าจากฟอร์ม
$exercise_id = isset($_POST['exercise_id']) ? intval($_POST['exercise_id']) : 0;
$question_text = isset($_POST['question_text']) ? trim($_POST['question_text']) : '';
$media_url = isset($_POST['media_url']) ? trim($_POST['media_url']) : '';
$score = isset($_POST['score']) ? intval($_POST['score']) : 0;
$answer_texts = isset($_POST['answer_text']) ? $_POST['answer_text'] : [];
$is_corrects = isset($_POST['is_correct']) ? $_POST['is_correct'] : [];

// ตัวแปรสำหรับแสดงผล
$message = "";

// กำหนดประเภทคำถาม
$question_type = 'single_choice'; // กำหนดประเภทคำถาม

// ตรวจสอบข้อมูลที่จำเป็น
if ($exercise_id > 0 && !empty($question_text) && !empty($answer_texts)) {
    // บันทึกคำถาม
    $sql_question = "INSERT INTO questions (exercise_id, question_text, media_url, score, question_type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_question);

    if ($stmt) {
        $stmt->bind_param("issis", $exercise_id, $question_text, $media_url, $score, $question_type);

        if ($stmt->execute()) {
            $question_id = $stmt->insert_id; // รับ ID ของคำถามที่เพิ่งเพิ่ม

            // บันทึกคำตอบ
            foreach ($answer_texts as $index => $answer_text) {
                // ตรวจสอบค่า is_correct ให้ถูกต้อง
                $is_correct = (isset($is_corrects[$index]) && $is_corrects[$index] == 1) ? 1 : 0; // ใช้ค่าจากฟอร์ม

                // SQL สำหรับบันทึกคำตอบ
                $sql_answer = "INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)";
                $stmt_answer = $conn->prepare($sql_answer);
                if ($stmt_answer) {
                    $stmt_answer->bind_param("ssi", $question_id, $answer_text, $is_correct);
                    $stmt_answer->execute();

                    // ตรวจสอบว่าการบันทึกคำตอบสำเร็จ
                    if ($stmt_answer->error) {
                        $message = "เกิดข้อผิดพลาดในการบันทึกคำตอบ: " . $stmt_answer->error;
                        break; // ออกจาก loop หากเกิดข้อผิดพลาด
                    }
                    $stmt_answer->close();
                } else {
                    $message = "เกิดข้อผิดพลาดในการเตรียม SQL สำหรับคำตอบ: " . $conn->error;
                    break;
                }
            }

            // ตรวจสอบว่ามีข้อความแสดงข้อผิดพลาดหรือไม่
            if (empty($message)) {
                // รีไดเร็กต์ไปยังหน้าแสดงผล
                echo "<script>window.location.href='?page=show_exam&exercise_id=$exercise_id&status=1';</script>";
                exit;
            }
        } else {
            // เก็บข้อความแสดงข้อผิดพลาดถ้าบันทึกไม่สำเร็จ
            $message = "เกิดข้อผิดพลาดในการบันทึกคำถาม: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "เกิดข้อผิดพลาดในการเตรียม SQL สำหรับคำถาม: " . $conn->error;
    }
} else {
    $message = "กรุณากรอกข้อมูลที่จำเป็นทั้งหมด";
}

// ปิดการเชื่อมต่อ
// $conn->close();

// แสดงข้อความผลลัพธ์
if (!empty($message)) {
    echo "<script>alert('" . addslashes($message) . "');</script>";
}
