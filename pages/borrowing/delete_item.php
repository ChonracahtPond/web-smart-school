<?php


// ตรวจสอบว่ามี `delete_item` ใน URL หรือไม่
if (isset($_GET['delete_item'])) {
    $item_id = $_GET['delete_item'];

    // ลบข้อมูลของไอเท็ม
    $sql = "DELETE FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $item_id);
    $stmt->execute();

    // ส่งกลับไปยังหน้าหลัก
    echo "<script>alert('equipment delete successfully'); window.location.href='admin.php?page=equipment_management';</script>";
} else {
    // ถ้าไม่มี `delete_item` ส่งกลับไปยังหน้าหลักหรือแสดงข้อผิดพลาด
    echo "<script>alert('equipment delete successfully'); window.location.href='admin.php?page=equipment_management';</script>";
}
