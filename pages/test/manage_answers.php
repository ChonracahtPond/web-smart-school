<?php

$question_id = $_GET['question_id'];


// Handle delete request
if (isset($_GET['delete_id'])) {
    $answer_id = $_GET['delete_id'];
    $sql = "DELETE FROM Answers WHERE answer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $answer_id);
    if ($stmt->execute()) {
        echo "<script>
        alert('Answer deleted successfully');
        window.location.href = '?question_id=" . $question_id . "&exercise_id=" . $exercise_id . "';
    </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle add or edit request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answer_id = $_POST['answer_id'] ?? null;
    $answer_text = $_POST['answer_text'];
    $is_correct = $_POST['is_correct'] ?? 0;

    if ($answer_id) {
        // Update existing answer
        $sql = "UPDATE Answers SET answer_text = ?, is_correct = ? WHERE answer_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $answer_text, $is_correct, $answer_id);
    } else {
        // Insert new answer
        $sql = "INSERT INTO Answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $question_id, $answer_text, $is_correct);
    }

    if ($stmt->execute()) {
        echo "<script>
        alert('Answer saved successfully');
        window.location.href = '?question_id=" . $question_id . "&exercise_id=" . $exercise_id . "';
    </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// ดึงรายการคำตอบจากฐานข้อมูล
$query = "SELECT * FROM Answers WHERE question_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $question_id);
$stmt->execute();
$result = $stmt->get_result();
$answers = $result->fetch_all(MYSQLI_ASSOC);
?>


<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Manage Answers for Question ID <?php echo htmlspecialchars($question_id); ?></h1>
    <a href="?page=add_answer&question_id=<?php echo htmlspecialchars($question_id); ?>&exercise_id=<?php echo htmlspecialchars($exercise_id); ?>" class="bg-green-500 text-white py-2 px-4 rounded mb-4 inline-block">Add Answer</a>

    <!-- Form for adding/editing answers -->
    <?php if (isset($_GET['edit_id'])) : ?>
        <?php
        $edit_id = $_GET['edit_id'];
        $query = "SELECT * FROM Answers WHERE answer_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $edit_result = $stmt->get_result();
        $edit_answer = $edit_result->fetch_assoc();
        ?>
        <h2 class="text-xl font-bold mb-4">Edit Answer</h2>
    <?php else : ?>
        <h2 class="text-xl font-bold mb-4">Add Answer</h2>
    <?php endif; ?>

    <form action="" method="POST" class="bg-white p-6 rounded shadow-md">
        <input type="hidden" name="answer_id" value="<?php echo htmlspecialchars($edit_answer['answer_id'] ?? ''); ?>">
        <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($question_id); ?>">
        <input type="hidden" name="exercise_id" value="<?php echo htmlspecialchars($exercise_id); ?>">
        <div class="mb-4">
            <label for="answer_text" class="block text-gray-700">Answer Text</label>
            <textarea id="answer_text" name="answer_text" rows="4" class="mt-1 block w-full border-gray-300 rounded" required><?php echo htmlspecialchars($edit_answer['answer_text'] ?? ''); ?></textarea>
        </div>
        <div class="mb-4">
            <label for="is_correct" class="block text-gray-700">Is Correct</label>
            <select id="is_correct" name="is_correct" class="mt-1 block w-full border-gray-300 rounded">
                <option value="0" <?php echo (isset($edit_answer) && $edit_answer['is_correct'] == 0) ? 'selected' : ''; ?>>No</option>
                <option value="1" <?php echo (isset($edit_answer) && $edit_answer['is_correct'] == 1) ? 'selected' : ''; ?>>Yes</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Save Answer</button>
    </form>

    <!-- Display answers -->
    <table class="min-w-full bg-white border border-gray-300 rounded shadow-md mt-6">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Answer ID</th>
                <th class="py-2 px-4 border-b">Answer Text</th>
                <th class="py-2 px-4 border-b">Is Correct</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($answers) : ?>
                <?php foreach ($answers as $index => $answer) : ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($answer['answer_id']); ?></td>
                        <td class="py-2 px-4 border-b <?php echo $answer['is_correct'] == 1 ? 'bg-green-100' : ''; ?>">
                            <?php echo ($index + 1) . '. ' . htmlspecialchars($answer['answer_text']); ?>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <?php echo $answer['is_correct'] == 1 ? 'Yes' : 'No'; ?>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="?edit_id=<?php echo htmlspecialchars($answer['answer_id']); ?>&question_id=<?php echo htmlspecialchars($question_id); ?>&exercise_id=<?php echo htmlspecialchars($exercise_id); ?>" class="text-blue-500 hover:underline">Edit</a>
                            <a href="?question_id=<?php echo htmlspecialchars($question_id); ?>&exercise_id=<?php echo htmlspecialchars($exercise_id); ?>&delete_id=<?php echo htmlspecialchars($answer['answer_id']); ?>" class="text-red-500 hover:underline ml-4" onclick="return confirm('Are you sure you want to delete this answer?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="py-2 px-4 border-b text-center">No answers found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>