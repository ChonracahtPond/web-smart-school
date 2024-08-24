<?php


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $sql = "DELETE FROM enrollments WHERE enrollment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "<script>alert('courses delete successfully'); window.location.href='system.php?page=Manage_enrollments';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid ID.";
}
