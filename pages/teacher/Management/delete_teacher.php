<?php

// if (isset($_GET['id'])) {
//     $id = intval($_GET['id']);

//     $sql = "DELETE FROM teachers WHERE id = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param('i', $id);

//     if ($stmt->execute()) {
//         echo "Teacher deleted successfully!";
//     } else {
//         echo "Error: " . $stmt->error;
//     }
// }


if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    // SQL query to delete the teacher record
    $sql = "DELETE FROM teachers WHERE teacher_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacher_id);

    if ($stmt->execute()) {
        // Redirect back to the teacher management page
        // header("Location: Teacher_Manage.php?msg=Teacher+Deleted+Successfully");
        echo "<script>window.location.href='?page=Teacher_Manage&status=1';</script>";
        exit();
    } else {
        // echo "Error deleting record: " . $conn->error;
        echo "<script>window.location.href='?page=Teacher_Manage&status=0';</script>";
    }

    $stmt->close();
} else {
    echo "Invalid request";
}

$conn->close();
