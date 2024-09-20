<?php


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $sql = "DELETE FROM enrollments WHERE enrollment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "<script>window.location.href='?page=Manage_enrollments&status=1';</script>";
    } else {
        echo "Error: " . $stmt->error;
        echo "<script>window.location.href='?page=Manage_enrollments&status=0';</script>";
    }
} else {
    echo "Invalid ID.";
}
