<?php

// Get current year
$currentYear = date('Y');

// Set default dates to the beginning and end of the current year
$start_date = '01/01/' . $currentYear;
$end_date = '31/12/' . $currentYear;
$year = $currentYear;

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า start_date, end_date และ year จากฟอร์ม
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
    $year = isset($_POST['year']) ? $_POST['year'] : null;

    // Prepare SQL query
    $query = "SELECT * FROM register WHERE status_register IN (0, 1, 3)";

    if ($start_date && $end_date) {
        // แปลงวันที่ให้เป็นรูปแบบที่ฐานข้อมูลรองรับ
        $start_date = date('Y-m-d', strtotime(str_replace('/', '-', $start_date)));
        $end_date = date('Y-m-d', strtotime(str_replace('/', '-', $end_date)));
        $query .= " AND registration_date BETWEEN ? AND ?";
    } elseif ($year) {
        $query .= " AND YEAR(registration_date) = ?";
    }

    // Prepare statement
    $stmt = $conn->prepare($query);

    // Bind parameters
    if ($start_date && $end_date) {
        $stmt->bind_param('ss', $start_date, $end_date);
    } elseif ($year) {
        $stmt->bind_param('i', $year);
    }

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();
    $students = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

    // Calculate student counts
    $total_students = count($students);
    $Waiting_students = array_filter($students, fn($s) => $s['status_register'] == 0);
    $accepted_students = array_filter($students, fn($s) => $s['status_register'] == 1);
    $rejected_students = array_filter($students, fn($s) => $s['status_register'] == 3);
    $Waiting_count = count($Waiting_students);
    $accepted_count = count($accepted_students);
    $rejected_count = count($rejected_students);
}

// Get distinct years for dropdown
$year_stmt = $conn->prepare("SELECT DISTINCT YEAR(registration_date) AS year FROM register ORDER BY year DESC");
$year_stmt->execute();
$year_result = $year_stmt->get_result();
$years = $year_result->num_rows > 0 ? $year_result->fetch_all(MYSQLI_ASSOC) : [];
