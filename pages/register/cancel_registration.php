<?php
// Check if 'id' is provided in the POST request
if (!isset($_POST['id'])) {
    die("ID parameter is missing.");
}

$id = intval($_POST['id']); // Sanitize the input to prevent SQL injection

// Check if the record exists in the register table
$sql = "SELECT * FROM register WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No record found.");
}

// Update the register table to set status_register to 3 (for cancelled)
$updateSql = "UPDATE register SET status_register = 1 WHERE id = ?";
$updateStmt = $conn->prepare($updateSql);
if (!$updateStmt) {
    die("Error preparing update statement: " . $conn->error);
}
$updateStmt->bind_param('i', $id);

if ($updateStmt->execute()) {
    // echo "Registration cancelled successfully.";
    echo "<script>window.location.href='?page=New_student_registration_system&status=1';</script>";
} else {
    // echo "Error cancelling registration: " . $updateStmt->error;
    echo "<script>window.location.href='?page=New_student_registration_system&status=0';</script>";
}

$updateStmt->close();
$stmt->close();
$conn->close();
