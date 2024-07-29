<?php

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // คำสั่ง SQL สำหรับลบข้อมูล
    $sql = "DELETE FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        echo "<script>alert('courses delete successfully'); window.location.href='admin.php?page=Manage_courses';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
