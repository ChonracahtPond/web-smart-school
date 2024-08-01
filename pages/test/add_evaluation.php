<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exercise_id = $_POST['exercise_id'];
    $evaluation_name = $_POST['evaluation_name'];
    $evaluation_type = $_POST['evaluation_type'];
    $max_score = $_POST['max_score'];

    $query = "INSERT INTO Evaluations (exercise_id, evaluation_name, evaluation_type, max_score) VALUES ('$exercise_id', '$evaluation_name', '$evaluation_type', '$max_score')";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_evaluations.php?id=" . $exercise_id);
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
        <h1 class="text-2xl font-bold mb-4">Add Evaluation</h1>
        <form action="add_evaluation.php" method="POST" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" name="exercise_id" value="<?php echo $_GET['exercise_id']; ?>">
            <div class="mb-4">
                <label for="evaluation_name" class="block text-gray-700">Evaluation Name</label>
                <input type="text" id="evaluation_name" name="evaluation_name" class="mt-1 block w-full border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="evaluation_type" class="block text-gray-700">Evaluation Type</label>
                <select id="evaluation_type" name="evaluation_type" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="multiple_choice">Multiple Choice</option>
                    <option value="true_false">True/False</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="max_score" class="block text-gray-700">Max Score</label>
                <input type="number" id="max_score" name="max_score" class="mt-1 block w-full border-gray-300 rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Evaluation</button>
        </form>
    </div>
</body>
</html>
