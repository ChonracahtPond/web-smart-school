<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exercise_id = mysqli_real_escape_string($conn, $_POST['exercise_id']);
    $question_text = mysqli_real_escape_string($conn, $_POST['question_text']);
    $question_type = mysqli_real_escape_string($conn, $_POST['question_type']);

    $query = "INSERT INTO Questions (exercise_id, question_text, question_type) VALUES ('$exercise_id', '$question_text', '$question_type')";
    if (mysqli_query($conn, $query)) {
        echo "<script>
            alert('Question added successfully');
            window.location.href = '?page=manage_questions&id=" . $exercise_id . "';
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add Question</h1>
        <form action="" method="POST" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" name="exercise_id" value="<?php echo htmlspecialchars($_GET['exercise_id']); ?>">
            <div class="mb-4">
                <label for="question_text" class="block text-gray-700">Question Text</label>
                <textarea id="question_text" name="question_text" rows="4" class="mt-1 block w-full border-gray-300 rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label for="question_type" class="block text-gray-700">Question Type</label>
                <select id="question_type" name="question_type" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="image">Image</option>
                    <option value="video">Video</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Question</button>
        </form>
    </div>