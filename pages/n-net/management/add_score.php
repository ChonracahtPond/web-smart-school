<?php
// ตรวจสอบการตั้งค่าฟอร์ม
$required_fields = ['student_id', 'score', 'exam_date'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        die("Missing or empty form field: $field");
    }
}

// ดึงค่าจากฟอร์ม
$student_id = filter_var($_POST['student_id'], FILTER_SANITIZE_NUMBER_INT);
$score = filter_var($_POST['score'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$exam_date = filter_var($_POST['exam_date'], FILTER_SANITIZE_STRING);

// ตรวจสอบว่าคะแนนเป็นตัวเลขและวันที่เป็นรูปแบบที่ถูกต้อง
if (!is_numeric($score) || !strtotime($exam_date)) {
    die("Invalid score value or date");
}

// เตรียมการคิวรี
$query = "INSERT INTO nnet_scores (student_id, score, exam_date) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

// ผูกพารามิเตอร์
$stmt->bind_param("ids", $student_id, $score, $exam_date);

// ดำเนินการคิวรี
if (!$stmt->execute()) {
    die("Execute failed: " . htmlspecialchars($stmt->error));
}

// เปลี่ยนเส้นทางหลังจากดำเนินการเสร็จ
echo "<script>window.location.href='?page=scores_management&status=1';</script>";


?>

