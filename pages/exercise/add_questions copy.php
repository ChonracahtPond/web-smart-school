<?php
include "sql/sql_questions.php";

// กำหนดตัวแปร $isCorrectCount ให้เป็น 0 ก่อน
$isCorrectCount = 0;

// SQL ดึงคำตอบทั้งหมดที่เกี่ยวข้องกับคำถามนี้
$sql_answers = "SELECT is_correct FROM answers WHERE question_id = ?";
if ($stmt_answers = $conn->prepare($sql_answers)) {
    $stmt_answers->bind_param("i", $question_id);
    $stmt_answers->execute();
    $result_answers = $stmt_answers->get_result();

    // นับจำนวนคำตอบที่ถูกต้อง
    while ($row = $result_answers->fetch_assoc()) {
        if ($row['is_correct'] == 1) {
            $isCorrectCount++;
        }
    }
    $stmt_answers->close();
}
?>

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

            // แสดงฟอร์มที่เกี่ยวข้องตามประเภทคำถาม
            if (questionType === "single_choice") {
                document.getElementById("single_choice_form").style.display = "block";
            } else if (questionType === "multiple_choice") {
                document.getElementById("multiple_choice_form").style.display = "block";
            } else if (questionType === "true_false") {
                document.getElementById("true_false_form").style.display = "block";
            } else if (questionType === "text") {
                document.getElementById("text_form").style.display = "block";
            }
        }

        function addChoice() {
            choiceCount++;
            const choiceContainer = document.getElementById("multiple_choice_choices");
            const newChoice = document.createElement("div");
            newChoice.className = "mb-4";
            newChoice.innerHTML = `
                <label for="answer_text_${choiceCount}" class="block text-gray-700">Choice ${choiceCount}:</label>
                <textarea id="answer_text_${choiceCount}" name="answer_text[]" required class="border border-gray-300 p-2 w-full rounded"></textarea>
                <div class="mb-4">
                    <label for="is_correct_${choiceCount}" class="inline-flex items-center">
                        <input type="checkbox" id="is_correct_${choiceCount}" name="is_correct[]" class="mr-2">
                        <span class="text-gray-700">Is Correct?</span>
                    </label>
                </div>
            `;
            choiceContainer.appendChild(newChoice);
        }
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

        <!-- Form for Adding Answers -->
        <h2 class="text-xl font-bold mt-6">Add Answers for Last Question</h2>

        <!-- Single Choice Answer Form -->
        <div id="single_choice_form" class="answer-form mb-4" style="display:none;">
            <label for="answer_text" class="block text-gray-700">Answer Text:</label>
            <textarea id="answer_text" name="answer_text" required class="border border-gray-300 p-2 w-full rounded"></textarea>
            <div class="mb-4">
                <?php
                // เช็คจำนวนคำตอบที่ถูกต้องในฐานข้อมูล
                if ($isCorrectCount > 0) {
                    echo "<p class='text-green-500'>มีคำตอบที่ถูกต้องแล้ว</p>";
                } else {
                    echo "
    <label for='is_correct' class='inline-flex items-center'>
        <input type='checkbox' id='is_correct' name='is_correct' class='mr-2'>
        <span class='text-gray-700'>Is Correct?</span>
    </label>";
                }
                ?>

            </div>
            <button type="button" onclick="addSingleChoice()" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">Add Answer</button>
        </div>

        <!-- Multiple Choice Answer Form -->
        <div id="multiple_choice_form" class="answer-form mb-4" style="display:none;">
            <div id="multiple_choice_choices">
                <label for="answer_text_1" class="block text-gray-700">Choice 1:</label>
                <textarea id="answer_text_1" name="answer_text[]" required class="border border-gray-300 p-2 w-full rounded"></textarea>
                <!-- <div class="mb-4">
                    <label for="is_correct_1" class="inline-flex items-center">
                        <input type="checkbox" id="is_correct_1" name="is_correct[]" class="mr-2">
                        <span class="text-gray-700">Is Correct?</span>
                    </label>
                </div> -->
            </div>
            <button type="button" onclick="addChoice()" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">เพิ่ม Choice</button>
            <button type="button" onclick="addMultipleChoice()" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">Add Answer</button>
        </div>

        <!-- Display Added Answers -->
        <div id="added_answers" class="mt-4">
            <h2 class="text-lg font-bold">Added Answers:</h2>
            <ul id="answer_list" class="list-disc pl-5"></ul>
        </div>

        <?php include "questions/True_False.php"; ?>
        <?php include "questions/text_form.php"; ?>
    </div>
    <script>
        function addSingleChoice() {
            const answerText = document.getElementById('answer_text').value;
            const isCorrect = document.getElementById('is_correct').checked ? 'Yes' : 'No';

            // แสดงคำตอบที่เพิ่ม
            const answerList = document.getElementById('answer_list');
            const listItem = document.createElement('li');
            listItem.textContent = `Answer: ${answerText}, Is Correct: ${isCorrect}`;

            // เพิ่มปุ่มลบในรายการ
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.className = 'bg-red-500 text-white p-1 rounded ml-2 hover:bg-red-600';
            deleteButton.onclick = function() {
                answerList.removeChild(listItem);
            };

            listItem.appendChild(deleteButton);
            answerList.appendChild(listItem);

            // ล้างค่า textarea
            document.getElementById('answer_text').value = '';
            document.getElementById('is_correct').checked = false;
        }

        function addMultipleChoice() {
            const answerTexts = document.getElementsByName('answer_text[]');
            const isCorrects = document.getElementsByName('is_correct[]');

            // Loop through all choices and add them to the answer list
            for (let i = 0; i < answerTexts.length; i++) {
                const answerText = answerTexts[i].value;
                const isCorrect = isCorrects[i].checked ? 'Yes' : 'No';

                const answerList = document.getElementById('answer_list');
                const listItem = document.createElement('li');
                listItem.textContent = `Choice ${i + 1}: ${answerText}, Is Correct: ${isCorrect}`;

                // เพิ่มปุ่มลบในรายการ
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.className = 'bg-red-500 text-white p-1 rounded ml-2 hover:bg-red-600';
                deleteButton.onclick = function() {
                    answerList.removeChild(listItem);
                };

                listItem.appendChild(deleteButton);
                answerList.appendChild(listItem);

                // Clear the textarea for each choice
                answerTexts[i].value = '';
                isCorrects[i].checked = false;
            }
        }

        function addChoice() {
            const choiceCount = document.querySelectorAll('#multiple_choice_choices textarea').length;
            const newChoiceDiv = document.createElement('div');

            newChoiceDiv.innerHTML = `
            <label for="answer_text_${choiceCount + 1}" class="block text-gray-700">Choice ${choiceCount + 1}:</label>
            <textarea id="answer_text_${choiceCount + 1}" name="answer_text[]" required class="border border-gray-300 p-2 w-full rounded"></textarea>
            <div class="mb-4">
                <label for="is_correct_${choiceCount + 1}" class="inline-flex items-center">
                    <input type="checkbox" id="is_correct_${choiceCount + 1}" name="is_correct[]" class="mr-2">
                    <span class="text-gray-700">Is Correct?</span>
                </label>
            </div>
        `;

            document.getElementById('multiple_choice_choices').appendChild(newChoiceDiv);
        }
    </script>
</body>

</html>