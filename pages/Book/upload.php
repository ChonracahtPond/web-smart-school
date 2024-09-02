<?php

if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $file = $_FILES['ebook_file'];

    // ตรวจสอบว่าไฟล์ถูกส่งมาหรือไม่
    if ($file['error'] === UPLOAD_ERR_OK) {
        // สร้างคีย์ใหม่ที่ไม่ซ้ำกัน
        $unique_key = bin2hex(random_bytes(8)); // สร้างคีย์ 16 ตัวอักษร

        // ชื่อไฟล์เดิม
        $original_file_name = pathinfo($file['name'], PATHINFO_FILENAME);
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // สร้างชื่อไฟล์ใหม่
        $new_file_name = $original_file_name . '_' . $unique_key . '.' . $file_extension;

        $upload_dir = __DIR__ . '/../../uploads/ebooks/';

        // สร้างไดเรกทอรีอัปโหลดถ้ายังไม่มี
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_path = $upload_dir . $new_file_name;

        // อัปโหลดไฟล์
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            $sql = "INSERT INTO ebooks (title, file_name) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $title, $new_file_name);
            $stmt->execute();
            $stmt->close();
            echo "<script>window.location.href='?page=ManageBook&status=1';</script>";
        } else {
            echo "<script>window.location.href='?page=ManageBook&status=0';</script>";
        }
    } else {
        // ตรวจสอบข้อผิดพลาดอื่นๆ เช่น ไม่มีไฟล์หรือข้อผิดพลาดการอัปโหลด
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            echo "<script>alert('กรุณาเลือกไฟล์ eBook');</script>";
        } else {
            echo "<script>window.location.href='?page=ManageBook&status=0';</script>";
        }
    }
}


