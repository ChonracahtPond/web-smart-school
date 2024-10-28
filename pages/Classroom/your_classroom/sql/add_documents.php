<?php


// ตรวจสอบว่ามีการส่งข้อมูล POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $lesson_id = isset($_POST['lesson_id']) ? intval($_POST['lesson_id']) : 0;
    $document_name = isset($_POST['document_name']) ? trim($_POST['document_name']) : '';
    $document_type = isset($_POST['document_type']) ? trim($_POST['document_type']) : '';
    $file_size = isset($_POST['file_size']) ? intval($_POST['file_size']) : 0;
    $file_url = isset($_POST['file_url']) ? trim($_POST['file_url']) : '';

    // ตรวจสอบค่าที่ได้รับ
    if (empty($document_name) || empty($document_type) || empty($file_url) ) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วนๅๅๅๅ');</script>";
    } else {
        // เตรียม SQL statement
        $stmt = $conn->prepare("INSERT INTO documents (lesson_id, document_name, document_type, file_size, file_url, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        if ($stmt) {
            $stmt->bind_param("issis", $lesson_id, $document_name, $document_type, $file_size, $file_url);

            // ประมวลผล SQL statement
            if ($stmt->execute()) {
                echo "<script>window.location.href='?page=lesson_detail&id=$lesson_id&status=1';</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาด: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการเตรียม SQL: " . $conn->error . "');</script>";
        }
    }
}
