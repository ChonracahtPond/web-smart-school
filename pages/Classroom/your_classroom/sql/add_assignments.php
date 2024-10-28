<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $lesson_id = $_POST['lesson_id'];
    $assignment_title = $_POST['assignment_title'];
    $assignment_description = $_POST['assignment_description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];


    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare("INSERT INTO assignments (lesson_id, assignment_title, assignment_description, due_date, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $lesson_id, $assignment_title, $assignment_description, $due_date, $status);

    // รันคำสั่ง SQL
    if ($stmt->execute()) {
        // echo "บันทึกการบ้านเรียบร้อยแล้ว!";
        echo "<script>window.location.href='?page=lesson_detail&id=$lesson_id&status=1';</script>";
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }
}
?>



