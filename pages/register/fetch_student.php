<?php

// Check if 'id' is provided in the query string (GET request)
if (!isset($_GET['id'])) {
    die("ID parameter is missing.");
}

$id = intval($_GET['id']); // Sanitize the input to prevent SQL injection

// Fetch student details from the database
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

$student = $result->fetch_assoc();
$stmt->close();
