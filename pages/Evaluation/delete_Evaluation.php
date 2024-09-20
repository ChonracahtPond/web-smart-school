<?php

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ตรวจสอบว่ามี id ที่ต้องการลบหรือไม่
if ($id > 0) {
    // เริ่มต้น Transaction
    $conn->begin_transaction();

    try {
        // เตรียมคำสั่ง SQL สำหรับลบข้อมูลการลงทะเบียนจากตาราง `evaluations`
        $sql = "DELETE FROM evaluations WHERE evaluation_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        // ตรวจสอบว่าลบข้อมูลการลงทะเบียนสำเร็จหรือไม่
        if ($stmt->execute()) {
            // Commit Transaction เมื่อการลบสำเร็จ
            $conn->commit();
            echo "<script> window.location.href='?page=Evaluation_management&status=1';</script>";
        } else {
            // Rollback Transaction หากเกิดข้อผิดพลาดในการลบ
            $conn->rollback();
            echo "Error: " . $stmt->error;
            echo "<script> window.location.href='?page=Evaluation_management&status=0';</script>";
        }
    } catch (Exception $e) {
        // Rollback Transaction ในกรณีที่เกิดข้อผิดพลาด
        $conn->rollback();
        echo "Transaction failed: " . $e->getMessage();
        echo "<script> window.location.href='?page=Evaluation_management&status=0';</script>";
    }
} else {
    // หากไม่มี id ที่ถูกต้อง ให้เปลี่ยนเส้นทางไปที่หน้าจัดการการลงทะเบียนพร้อมกับส่งสถานะล้มเหลว
    echo "<script> window.location.href='?page=Evaluation_management&status=0';</script>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
