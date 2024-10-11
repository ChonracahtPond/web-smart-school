<?php include "sql/sql_questions.php"; ?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        let choiceCount = 1; // จำนวนตัวเลือกที่มีอยู่
        function showAnswerForm() {
            const questionType = document.getElementById("question_type").value;
            const answerForms = document.querySelectorAll(".answer-form");
            answerForms.forEach(form => form.style.display = "none"); // ซ่อนฟอร์มทั้งหมด

            // ใช้ switch-case เพื่อแสดงฟอร์มที่เกี่ยวข้อง
            switch (questionType) {
                case "single_choice":
                    document.getElementById("single_choice_form").style.display = "block";
                    break;
                case "multiple_choice":
                    document.getElementById("multiple_choice_form").style.display = "block";
                    break;
                case "true_false":
                    document.getElementById("true_false_form").style.display = "block";
                    break;
                case "text":
                    document.getElementById("text_form").style.display = "block";
                    break;
                default:
                    break;
            }
        }

        // โค้ดอื่น ๆ ตามที่คุณมีอยู่
    </script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Add a Question</h1>
        <?php echo $message; ?>
        <form method="POST" action="">
            <input type="hidden" name="exercise_id" value="<?php echo $exercise_id; ?>">

            <div class="mb-4">
                <label for="question_text" class="block text-gray-700">Question Text:</label>
                <textarea id="question_text" name="question_text" required class="border border-gray-300 p-2 w-full rounded"></textarea>
            </div>

            <div class="mb-4">
                <label for="media_url" class="block text-gray-700">Media URL (optional):</label>
                <input type="text" id="media_url" name="media_url" class="border border-gray-300 p-2 w-full rounded">
            </div>

            <div class="mb-4">
                <label for="score" class="block text-gray-700">Score:</label>
                <input type="number" id="score" name="score" required class="border border-gray-300 p-2 w-full rounded">
            </div>

            <div class="mb-4">
                <label for="question_type" class="block text-gray-700">Question Type:</label>
                <select id="question_type" name="question_type" class="border border-gray-300 p-2 w-full rounded" onchange="showAnswerForm()">
                    <option value="">-- เลือก --</option>
                    <option value="single_choice">Single Choice</option>
                    <option value="multiple_choice">Multiple Choice</option>
                    <option value="true_false">True/False</option>
                    <option value="text">Text</option>
                </select>
            </div>

            <input type="submit" value="Add Question" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
        </form>

        <!-- Include answers form -->

        <?php include "questions/multiple_choice.php"; ?>
        <?php include "questions/single_choice.php"; ?>
        <?php include "questions/text_form.php"; ?>
        <?php include "questions/True_False.php"; ?>
    </div>
</body>

</html>