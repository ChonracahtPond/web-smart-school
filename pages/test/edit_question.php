<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question_id = $_POST['question_id'];
    $question_text = $_POST['question_text'];
    $question_type = $_POST['question_type'];

    $query = "UPDATE Questions SET question_text='$question_text', question_type='$question_type' WHERE question_id=$question_id";
    if (mysqli_query($conn, $query)) {
        echo "<script>
        alert('Question updated successfully');
        window.location.href = '?page=manage_questions&id=" . $_POST['exercise_id'] . "';
    </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$question_id = $_GET['id'];
$exercise_id = $_GET['exercise_id'];
$query = "SELECT * FROM Questions WHERE question_id = $question_id";
$result = mysqli_query($conn, $query);
$question = mysqli_fetch_assoc($result);
?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Question</h1>
    <form action="" method="POST" class="bg-white p-6 rounded shadow-md">
        <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($question['question_id']); ?>">
        <input type="hidden" name="exercise_id" value="<?php echo htmlspecialchars($exercise_id); ?>">
        <div class="mb-4">
            <label for="question_text" class="block text-gray-700">Question Text</label>
            <textarea id="question_text" name="question_text" rows="4" class="mt-1 block w-full border-gray-300 rounded" required><?php echo htmlspecialchars($question['question_text']); ?></textarea>
        </div>
        <div class="mb-4">
            <label for="question_type" class="block text-gray-700">Question Type</label>
            <select id="question_type" name="question_type" class="mt-1 block w-full border-gray-300 rounded">
                <option value="text" <?php if ($question['question_type'] == 'text') echo 'selected'; ?>>Text</option>
                <option value="number" <?php if ($question['question_type'] == 'number') echo 'selected'; ?>>Number</option>
                <option value="image" <?php if ($question['question_type'] == 'image') echo 'selected'; ?>>Image</option>
                <option value="video" <?php if ($question['question_type'] == 'video') echo 'selected'; ?>>Video</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Question</button>
    </form>
    <div class="mt-4">
        <a href="?page=manage_answers&question_id=<?php echo htmlspecialchars($question_id); ?>&exercise_id=<?php echo htmlspecialchars($exercise_id); ?>" class="bg-green-500 text-white py-2 px-4 rounded">Add Answer</a>
    </div>
</div>