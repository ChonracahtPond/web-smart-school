<?php


// ตรวจสอบว่ามีการส่ง ID ของนักเรียนที่ต้องการลบหรือไม่
if (isset($_GET['id'])) {
    $eligible_students_id = $_GET['id'];

    // ลบข้อมูลจากฐานข้อมูล
    $sql = "DELETE FROM eligible_students WHERE eligible_students_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eligible_students_id);

    if ($stmt->execute()) {
        // echo "<p class='text-center text-green-500'>ลบข้อมูลนักเรียนที่มีสิทธิสอบเรียบร้อยแล้ว</p>";
        echo "<script>window.location.href='?page=eligible_students_nnet&status=1';</script>";
    } else {
        echo "<p " . $conn->error . "</p>";
        echo "<script>window.location.href='?page=eligible_students_nnet&status=0';</script>";
    }

    $stmt->close();
}
