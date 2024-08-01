<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answer_id = $_POST['answer_id'];
    $answer_text = $_POST['answer_text'];
    $is_correct = isset($_POST['is_correct']) ? 1 : 0;
    $answer_type = $_POST['answer_type'];

    $query = "UPDATE Answers SET answer_text='$answer_text', is_correct='$is_correct', answer_type='$answer_type' WHERE answer_id=$answer_id";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_answers.php?id=" . $_POST['question_id']);
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$answer_id = $_GET['id'];
$query = "SELECT * FROM Answers WHERE answer_id = $answer_id";
$result = mysqli_query($conn, $query);
$answer = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Answer</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Answer</h1>
        <form action="edit_answer.php" method="POST" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" name="answer_id" value="<?php echo $answer['answer_id']; ?>">
            <input type="hidden" name="question_id" value="<?php echo $_GET['question_id']; ?>">
            <div class="mb-4">
                <label for="answer_text" class="block text-gray-700">Answer Text</label>
                <input type="text" id="answer_text" name="answer_text" class="mt-1 block w-full border-gray-300 rounded" value="<?php echo $answer['answer_text']; ?>" required>
            </div>
            <div class="mb-4">
                <label for="is_correct" class="inline-flex items-center">
                    <input type="checkbox" id="is_correct" name="is_correct" class="form-checkbox" <?php if ($answer['is_correct']) echo 'checked'; ?>>
                    <span class="ml-2 text-gray-700">Is Correct</span>
                </label>
            </div>
            <div class="mb-4">
                <label for="answer_type" class="block text-gray-700">Answer Type</label>
                <select id="answer_type" name="answer_type" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="a-z" <?php if ($answer['answer_type'] == 'a-z') echo 'selected'; ?>>a-z</option>
                    <option value="1-100" <?php if ($answer['answer_type'] == '1-100') echo 'selected'; ?>>1-100</option>
                    <option value="ก-ฮ" <?php if ($answer['answer_type'] == 'ก-ฮ') echo 'selected'; ?>>ก-ฮ</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Answer</button>
        </form>
    </div>
</body>
</html>
