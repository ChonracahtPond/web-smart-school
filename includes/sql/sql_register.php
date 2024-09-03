<?php

// Query to count new registrations
$sql = "SELECT COUNT(*) AS new_registrations FROM register WHERE status_register = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    $new_registrations = $row['new_registrations'];
} else {
    $new_registrations = 0;
}
