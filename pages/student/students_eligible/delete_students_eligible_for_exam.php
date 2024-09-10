<?php

if (isset($_GET['id'])) {
    $delete_id = intval($_GET['id']);

    // Prepare the SQL statement
    $sql = "DELETE FROM students_eligible_for_exam WHERE eligible_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameter
        $stmt->bind_param('i', $delete_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect back to the main page after deletion
            echo "<script>window.location.href = '?page=students_eligible_for_exam&status=1';</script>";
        } else {
            // echo "<p class='text-red-500'>เกิดข้อผิดพลาดในการลบข้อมูล: " . htmlspecialchars($stmt->error) . "</p>";
            echo "<script>window.location.href = '?page=students_eligible_for_exam&status=1';</script>";
        }
        $stmt->close();
    } else {
        echo "<p class='text-red-500'>ไม่สามารถเตรียมคำสั่ง SQL ได้</p>";
        echo "<script>window.location.href = '?page=students_eligible_for_exam&status=0';</script>";
    }

    $conn->close();
} else {
    echo "<p class='text-red-500'>ไม่พบรหัสที่ต้องการลบ</p>";
    echo "<script>window.location.href = '?page=students_eligible_for_exam&status=0';</script>";
}
