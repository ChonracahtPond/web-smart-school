<?php
require_once 'db_connection.php';

// รับค่าจากฟอร์ม
$student_id = $_POST['student_id'];
$exam_id = $_POST['exam_id'];
$score = $_POST['score'];
$exam_date = $_POST['exam_date'];

// แทรกข้อมูลลงในฐานข้อมูล
$query = "INSERT INTO nnet_scores (student_id, exam_id, score, exam_date) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("iids", $student_id, $exam_id, $score, $exam_date);
$stmt->execute();
$stmt->close();

header("Location: scores_management.php");
exit();
