<?php


// Handle delete request
$question_id = $_GET['id'];
$exercise_id = $_GET['exercise_id'];
$sql = "DELETE FROM Questions WHERE question_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $question_id);

if ($stmt->execute()) {
    // header('Location: manage_questions.php');
    echo "<script>
    alert('Question added successfully');
    window.location.href = '?page=manage_questions&id=" . $exercise_id . "';
</script>";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
