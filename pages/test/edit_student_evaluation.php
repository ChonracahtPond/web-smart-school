<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $evaluation_id = $_POST['evaluation_id'];
    $score = $_POST['score'];

    $query = "UPDATE Student_Evaluations SET student_id='$student_id', evaluation_id='$evaluation_id', score='$score' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_student_evaluations.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$id = $_GET['id'];
$query = "SELECT * FROM Student_Evaluations WHERE id = $id";
$result = mysqli_query($conn, $query);
$evaluation = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Evaluation</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Student Evaluation</h1>
        <form action="edit_student_evaluation.php" method="POST" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" name="id" value="<?php echo $evaluation['id']; ?>">
            <div class="mb-4">
                <label for="student_id" class="block text-gray-700">Student ID</label>
                <input type="text" id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 rounded" value="<?php echo $evaluation['student_id']; ?>" required>
            </div>
            <div class="mb-4">
                <label for="evaluation_id" class="block text-gray-700">Evaluation ID</label>
                <input type="text" id="evaluation_id" name="evaluation_id" class="mt-1 block w-full border-gray-300 rounded" value="<?php echo $evaluation['evaluation_id']; ?>" required>
            </div>
            <div class="mb-4">
                <label for="score" class="block text-gray-700">Score</label>
                <input type="number" id="score" name="score" class="mt-1 block w-full border-gray-300 rounded" value="<?php echo $evaluation['score']; ?>" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Evaluation</button>
        </form>
    </div>
</body>
</html>
