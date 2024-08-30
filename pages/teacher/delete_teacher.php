<?php
// delete_teacher.php
require 'db_connection.php'; // เชื่อมต่อฐานข้อมูล

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM teachers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "Teacher deleted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
