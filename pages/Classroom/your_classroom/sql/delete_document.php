<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lesson_id = isset($_POST['lesson_id']) ? intval($_POST['lesson_id']) : 0;
    $document_id = isset($_POST['document_id']) ? intval($_POST['document_id']) : 0;

    // เตรียม SQL statement
    $stmt = $conn->prepare("DELETE FROM documents WHERE document_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $document_id);

        // ประมวลผล SQL statement
        if ($stmt->execute()) {
            // echo "<script>window.location.href='?page=lesson_detail&id=" . htmlspecialchars($lesson_id) . "&status=2';</script>";
            echo "<script>window.location.href='?page=lesson_detail&id=$lesson_id&status=1';</script>";

        } else {
            echo "<script>alert('เกิดข้อผิดพลาด: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการเตรียม SQL: " . $conn->error . "');</script>";
    }
}
