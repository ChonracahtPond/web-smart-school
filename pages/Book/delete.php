<?php

if (isset($_GET['delete'])) {
    $ebook_id = intval($_GET['delete']); // ตรวจสอบและทำให้เป็นจำนวนเต็ม

    // ดึงชื่อไฟล์จากฐานข้อมูล
    $sql = "SELECT file_name FROM ebooks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ebook_id);
    $stmt->execute();
    $stmt->bind_result($file_name);
    $stmt->fetch();
    $stmt->close();

    // ลบไฟล์จากเซิร์ฟเวอร์
    $file_path = __DIR__ . '/../../uploads/ebooks/' . $file_name;
    if (unlink($file_path)) {
        // ลบข้อมูลจากฐานข้อมูล
        $sql = "DELETE FROM ebooks WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ebook_id);
        $stmt->execute();
        $stmt->close();
        // ส่งผู้ใช้กลับไปที่หน้า ManageBook พร้อมสถานะสำเร็จ
        echo "<script>window.location.href='?page=ManageBook&status=1';</script>";
    } else {
        // ส่งผู้ใช้กลับไปที่หน้า ManageBook พร้อมสถานะข้อผิดพลาด
        echo "<script>window.location.href='?page=ManageBook&status=0';</script>";
    }
}
