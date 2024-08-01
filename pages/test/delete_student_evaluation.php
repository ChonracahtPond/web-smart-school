<?php
require 'connection.php';

$id = $_GET['id'];
$query = "DELETE FROM Student_Evaluations WHERE id = $id";
if (mysqli_query($conn, $query)) {
    header("Location: manage_student_evaluations.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
