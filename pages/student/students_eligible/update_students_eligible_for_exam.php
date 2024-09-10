<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eligible_id = intval($_POST['eligible_id']);
    $student_id = intval($_POST['student_id']);
    $grade_level = $_POST['grade_level'];
    $exam_status = $_POST['exam_status'];
    $exam_date = $_POST['exam_date'];
    $term = $_POST['term']; // New field for term
    $academic_year = $_POST['academic_year']; // New field for academic_year

    // Update SQL query to include term and academic_year
    $sql = "UPDATE students_eligible_for_exam 
            SET student_id = ?, grade_level = ?, exam_status = ?, exam_date = ?, term = ?, academic_year = ?
            WHERE eligible_id = ?";

    $stmt = $conn->prepare($sql);

    // Bind parameters including the new fields
    $stmt->bind_param('isssssi', $student_id, $grade_level, $exam_status, $exam_date, $term, $academic_year, $eligible_id);

    if ($stmt->execute()) {
        echo "<script>window.location.href = '?page=students_eligible_for_exam&status=1';</script>";
    } else {
        echo "<script>window.location.href = '?page=students_eligible_for_exam&status=0';</script>";
    }

    $stmt->close();
}
?>
