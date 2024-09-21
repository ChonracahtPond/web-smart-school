<?php



// ตรวจสอบว่ามีการส่งคำขอ POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $student_id = $_POST['studentId'];
    $enrollment_id = $_POST['enrollmentId'];
    $exam_id = $_POST['examId'];
    $date_time = $_POST['dateTime'];

    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO eligible_students (student_id, enrollment_id, exam_id, created_at) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
    }

    // Binding parameters
    $stmt->bind_param("ssss", $student_id, $enrollment_id, $exam_id, $date_time);

    // Execute the query
    if ($stmt->execute()) {
        // echo "เพิ่มนักเรียนที่มีสิทธิสอบเรียบร้อยแล้ว";
        echo "<script>window.location.href='?page=eligible_students&status=1';</script>";
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->error;
        echo "<script>window.location.href='?page=eligible_students&status=0';</script>";
    }
}
