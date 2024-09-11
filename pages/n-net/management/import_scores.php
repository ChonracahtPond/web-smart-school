<?php
require_once 'db_connection.php';
require 'vendor/autoload.php'; // Composer autoload for PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($fileTmpPath);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    foreach ($data as $row) {
        $student_id = intval($row[0]);
        $exam_id = intval($row[1]);
        $score = floatval($row[2]);
        $exam_date = $row[3];

        $query = "INSERT INTO nnet_scores (student_id, exam_id, score, exam_date) VALUES (?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE score = VALUES(score), exam_date = VALUES(exam_date)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("iids", $student_id, $exam_id, $score, $exam_date);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: scores_management.php");
    exit();
}
?>
