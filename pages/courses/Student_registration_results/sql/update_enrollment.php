<?php
// update_enrollment.php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $student_id = trim($_POST['student_id']); // รับค่า student_id
    $enrollment_id = $_POST['enrollment_id'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $grade = $_POST['grade'];
    $credits = $_POST['credits'];

    // Ensure the fields are not empty (you can add more validation if necessary)
    if (!empty($enrollment_id) && !empty($semester) && !empty($academic_year) && !empty($grade)) {
        // Prepare the SQL query to update the enrollment record
        $query = "UPDATE enrollments 
                  SET semester = ?, academic_year = ?, grade = ?, credits = ? 
                  WHERE enrollment_id = ?";

        if ($stmt = $conn->prepare($query)) {
            // Bind the parameters to the query
            $stmt->bind_param('ssssi', $semester, $academic_year, $grade, $credits, $enrollment_id);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect or send a success message
                // header('Location: enrollment_list.php?message=Enrollment updated successfully');
                echo "<script>window.location.href='?page=detail_Student_registration_results&id=$student_id&status=1';</script>";
            } else {
                // echo "Error updating record: " . $stmt->error;
                echo "<script>window.location.href='?page=detail_Student_registration_results&id=$student_id&status=0';</script>";

            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the query: " . $conn->error;
        }
    } else {
        echo "All fields are required.";
    }
}

// Close the database connection
$conn->close();
