<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $evaluation_id = $_POST['evaluation_id'];
    $student_id = $_POST['student_id'];
    $score = $_POST['score'];

    $query = "INSERT INTO Student_Evaluations (evaluation_id, student_id, score) VALUES ('$evaluation_id', '$student_id', '$score')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_student_evaluations.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Evaluation</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add Student Evaluation</h1>
        <form action="add_edit.php" method="POST" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="student_id" class="block text-gray-700">Student ID</label>
                <input type="text" id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="evaluation_id" class="block text-gray-700">Evaluation ID</label>
                <input type="text" id="evaluation_id" name="evaluation_id" class="mt-1 block w-full border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="score" class="block text-gray-700">Score</label>
                <input type="number" id="score" name="score" class="mt-1 block w-full border-gray-300 rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Evaluation</button>
        </form>
    </div>
</body>
</html>
