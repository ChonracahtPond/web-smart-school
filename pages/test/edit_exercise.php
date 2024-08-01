<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exercise_id = mysqli_real_escape_string($conn, $_POST['exercise_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "UPDATE Exercises SET title='$title', description='$description' WHERE exercise_id='$exercise_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_exercises.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$exercise_id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM Exercises WHERE exercise_id = '$exercise_id'";
$result = mysqli_query($conn, $query);
$exercise = mysqli_fetch_assoc($result);
?>


<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Exercise</h1>
        <form action="" method="POST" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" name="exercise_id" value="<?php echo htmlspecialchars($exercise['exercise_id']); ?>">
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-300 rounded" value="<?php echo htmlspecialchars($exercise['title']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded"><?php echo htmlspecialchars($exercise['description']); ?></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Exercise</button>
        </form>
        <a href="?page=add_questions&exercise_id=<?php echo htmlspecialchars($exercise['exercise_id']); ?>" class="mt-4 inline-block bg-green-500 text-white py-2 px-4 rounded">Add Questions</a>
    </div>

