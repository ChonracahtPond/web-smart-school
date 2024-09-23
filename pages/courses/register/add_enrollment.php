<?php
// Assume you have a database connection already established in $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {
    // Retrieve POST data
    $student_id = $_POST['student_id'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $selected_courses_data = json_decode($_POST['selected_courses_data'], true);

    // Check if the required data is available
    if (empty($student_id) || empty($semester) || empty($academic_year) || empty($selected_courses_data)) {
        die("Required data is missing.");
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        foreach ($selected_courses_data as $course) {
            $course_id = $course['id'];

            // Fetch the teacher_id from the courses table
            $teacher_query = $conn->prepare("SELECT teacher_id FROM courses WHERE course_id = ?");
            $teacher_query->bind_param("s", $course_id);
            $teacher_query->execute();
            $teacher_query->bind_result($teacher_id);
            $teacher_query->fetch();
            $teacher_query->close();

            // If teacher_id is NULL, handle as needed (e.g., set to 0 or skip the entry)
            if (empty($teacher_id)) {
                $teacher_id = NULL; // Or set a default value, e.g., $teacher_id = 0;
            }

            $default_grade = 0; // Setting default grade

            // Prepare SQL statement with teacher_id included
            $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id, semester, academic_year, grade, status, teacher_id) VALUES (?, ?, ?, ?, ?, '1', ?)");

            // Bind the parameters: student_id, course_id, semester, academic_year, grade, teacher_id
            $stmt->bind_param("ssssii", $student_id, $course_id, $semester, $academic_year, $default_grade, $teacher_id);

            // Execute the statement
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        }

        // Commit the transaction
        $conn->commit();
        // echo "Enrollment successful!";
        echo "<script> window.location.href='?page=Manage_enrollments&status=1';</script>";
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        echo "Error during enrollment: " . $e->getMessage();
        // echo "<script>alert('error'); window.location.href='?page=Manage_enrollments';</script>";
        echo "<script> window.location.href='?page=Manage_enrollments&status=0';</script>";

    }

    // Close statement
    $stmt->close();
}

// Optionally: close the database connection if it's not being used elsewhere
//$conn->close();
