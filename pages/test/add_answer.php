<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question_id = $_POST['question_id'];
    $answer_text = $_POST['answer_text'];
    $is_correct = isset($_POST['is_correct']) ? 1 : 0;
    $answer_type = $_POST['answer_type'];

    $query = "INSERT INTO Answers (question_id, answer_text, is_correct, answer_type) VALUES ('$question_id', '$answer_text', '$is_correct', '$answer_type')";
    if (mysqli_query($conn, $query)) {
        // header("Location: manage_answers.php?id=" . $question_id);
        echo "<script>
        alert('Answers added successfully');
        window.location.href = '?page=manage_answers&question_id=" . $question_id . "';
    </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Add Answer</h1>
        <form action="" method="POST" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" name="question_id" value="<?php echo $_GET['question_id']; ?>">
            <div class="mb-4">
                <label for="answer_text" class="block text-gray-700">Answer Text</label>
                <input type="text" id="answer_text" name="answer_text" class="mt-1 block w-full border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="is_correct" class="inline-flex items-center">
                    <input type="checkbox" id="is_correct" name="is_correct" class="form-checkbox">
                    <span class="ml-2 text-gray-700">Is Correct</span>
                </label>
            </div>
            <div class="mb-4">
                <label for="answer_type" class="block text-gray-700">Answer Type</label>
                <select id="answer_type" name="answer_type" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="a-z">a-z</option>
                    <option value="1-100">1-100</option>
                    <option value="ก-ฮ">ก-ฮ</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Answer</button>
        </form>
    </div>