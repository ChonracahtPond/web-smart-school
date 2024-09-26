<?php



// // ตรวจสอบว่ามีการส่งคำขอ POST
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // รับค่าจากฟอร์ม
//     $student_id = $_POST['studentId'];
//     $enrollment_id = $_POST['enrollmentId'];
//     $exam_id = $_POST['examId'];
//     $date_time = $_POST['dateTime'];
//     $eligible_type = "nnet";

//     // เตรียมคำสั่ง SQL
//     $sql = "INSERT INTO eligible_students (student_id, enrollment_id, exam_id, created_at , eligible_type) VALUES (?, ?, ?, ? ,?)";
//     $stmt = $conn->prepare($sql);

//     if (!$stmt) {
//         die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
//     }

//     // Binding parameters
//     $stmt->bind_param("ssss", $student_id, $enrollment_id, $exam_id, $date_time , $eligible_type);

//     // Execute the query
//     if ($stmt->execute()) {
//         // echo "เพิ่มนักเรียนที่มีสิทธิสอบเรียบร้อยแล้ว";
//         echo "<script>window.location.href='?page=eligible_students_nnet&status=1';</script>";
//     } else {
//         echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->error;
//         echo "<script>window.location.href='?page=eligible_students_nnet&status=0';</script>";
//     }
// }

// ตรวจสอบว่ามีการส่งคำขอ POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $selected_students = $_POST['selected_students'] ?? []; // รับค่าจากฟอร์ม

    // ตรวจสอบว่ามีการส่ง enrollmentId และ dateTime มาหรือไม่
    $enrollment_id = $_POST['enrollmentId'] ?? null; // ถ้าไม่มีให้กำหนดค่าเป็น null
    $date_time = $_POST['dateTime'] ?? null; // ถ้าไม่มีให้กำหนดค่าเป็น null
    $eligible_type = "nnet";

    // ตรวจสอบว่ามีการกรอกข้อมูลที่จำเป็นหรือไม่
    if (empty($selected_students) || !$enrollment_id || !$date_time) {
        die("กรุณาเลือกนักเรียนและกรอกข้อมูล enrollmentId และ dateTime");
    }

    // เตรียมคำสั่ง SQL
    $sql = "INSERT INTO eligible_students (student_id, enrollment_id, created_at, eligible_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error);
    }

    // Binding parameters
    $stmt->bind_param("isss", $student_id, $enrollment_id, $date_time, $eligible_type);

    // เริ่มทำการแทรกข้อมูล
    foreach ($selected_students as $student_id) {
        // Execute the query for each student
        if (!$stmt->execute()) {
            echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลนักเรียน ID $student_id: " . $stmt->error;
        }
    }

    // ปิด statement
    $stmt->close();

    // Redirect or show success message
    echo "<script>window.location.href='?page=eligible_students_nnet&status=1';</script>";
} else {
    // ถ้าไม่ใช่ POST method ให้ redirect หรือแสดงข้อความผิดพลาด
    echo "<script>window.location.href='?page=eligible_students_nnet&status=0';</script>";
}

