<?php
header('Content-Type: application/json');

// Execute SQL query
$sql = "SELECT event_id, title, description, start_date AS start, IF(end_date = '0000-00-00', NULL, end_date) AS end FROM events";
$result = $conn->query($sql);

// Check for SQL query errors
if ($result === false) {
    echo json_encode(array('error' => 'SQL query failed: ' . $conn->error));
    $conn->close();
    exit;
}

// Fetch and encode data
if ($result->num_rows > 0) {
    $events = array();
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    echo json_encode($events);
} else {
    echo json_encode(array());
}

// Close connection
$conn->close();
