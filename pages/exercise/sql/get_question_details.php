<?php
include "../../../includes/db_connect.php";
// รับ question_id จาก URL
$question_id = isset($_GET['question_id']) ? intval($_GET['question_id']) : 0;

// คิวรีข้อมูลคำถามจากฐานข้อมูล
$sql = "SELECT * FROM questions WHERE question_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $question_id);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบผลลัพธ์คำถาม
$questionData = [];
if ($result->num_rows > 0) {
    $questionData = $result->fetch_assoc();
}

// คิวรีข้อมูลคำตอบที่สัมพันธ์กับคำถาม
$answers_sql = "SELECT * FROM answers WHERE question_id = ?";
$answers_stmt = $conn->prepare($answers_sql);
$answers_stmt->bind_param("i", $question_id);
$answers_stmt->execute();
$answers_result = $answers_stmt->get_result();

$answersData = [];
if ($answers_result->num_rows > 0) {
    while ($answer = $answers_result->fetch_assoc()) {
        $answersData[] = $answer; // เก็บข้อมูลคำตอบในอาร์เรย์
    }
}

// รวมข้อมูลคำถามและคำตอบ
$response = [
    'question' => $questionData,
    'answers' => $answersData
];

// ส่งคืนข้อมูลในรูปแบบ JSON
echo json_encode($response);

// ปิดการเชื่อมต่อฐานข้อมูล
$answers_stmt->close();
$stmt->close();
$conn->close();
