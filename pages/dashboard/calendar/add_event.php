<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $title = $_POST['eventTitle'];
    $description = $_POST['eventDescription'];
    $start_date = $_POST['eventDate'];
    $end_date = null; // Optional, handle if needed

    // Sanitize input data
    $title = $conn->real_escape_string($title);
    $description = $conn->real_escape_string($description);
    $start_date = $conn->real_escape_string($start_date);

    // Insert event into database
    $sql = "INSERT INTO events (title, description, start_date, end_date)
            VALUES ('$title', '$description', '$start_date', '$end_date')";

    if ($conn->query($sql) === TRUE) {
        echo "New event created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
