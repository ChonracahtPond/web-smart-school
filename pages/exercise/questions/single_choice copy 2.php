<?php

$exercise_id = isset($_GET['exercise_id']) ? intval($_GET['exercise_id']) : 0;

// ตัวแปรสำหรับแสดงผล
$message = "";

// ตรวจสอบว่าแบบฟอร์มถูกส่งมา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['question_text'])) {
        // รับค่าและจัดเตรียมข้อมูลสำหรับคำถาม
        $question_text = trim($_POST['question_text']);
        $question_type = 'single_choice';
        $media_url = trim($_POST['media_url']);
        $score = intval($_POST['score']); // Ensure score is treated as an integer
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลคำถาม
        $sql = "INSERT INTO questions (exercise_id, question_text, created_at, updated_at, question_type, media_url, score) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        // เตรียมและ bind parameters
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isssssi", $exercise_id, $question_text, $created_at, $updated_at, $question_type, $media_url, $score);

            // Execute the statement
            if ($stmt->execute()) {
                // รับค่า question_id ที่เพิ่งเพิ่ม
                $question_id = $stmt->insert_id;
                $message = "<div class='bg-green-200 text-green-800 p-4 rounded'>Question added successfully!</div>";

                // แสดงฟอร์มสำหรับเพิ่มคำตอบ
                if ($question_type == 'multiple_choice') {
                    if (isset($_POST['answer_text']) && is_array($_POST['answer_text'])) {
                        foreach ($_POST['answer_text'] as $index => $answer_text) {
                            $is_correct = isset($_POST['is_correct'][$index]) ? 1 : 0; // กำหนดค่า is_correct

                            // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลคำตอบ
                            $sql_answer = "INSERT INTO answers (question_id, answer_text, is_correct, created_at, updated_at, answer_type, score) 
                                           VALUES (?, ?, ?, ?, ?, ?, ?)";

                            if ($stmt_answer = $conn->prepare($sql_answer)) {
                                $stmt_answer->bind_param("issssis", $question_id, $answer_text, $is_correct, $created_at, $updated_at, $question_type, $score);
                                if ($stmt_answer->execute()) {
                                    $message .= "<div class='bg-green-200 text-green-800 p-4 rounded'>Answer added successfully: {$answer_text}</div>";
                                } else {
                                    $message .= "<div class='bg-red-200 text-red-800 p-4 rounded'>Error adding answer: " . $stmt_answer->error . "</div>";
                                }
                                $stmt_answer->close();
                            } else {
                                $message .= "<div class='bg-red-200 text-red-800 p-4 rounded'>Error preparing answer statement: " . $conn->error . "</div>";
                            }
                        }
                    }
                } elseif (!empty($_POST['answer_text'])) { // สำหรับ single choice และคำถามประเภทอื่น
                    $answer_text = trim($_POST['answer_text']);
                    $is_correct = isset($_POST['is_correct']) ? 1 : 0; // กำหนดค่า is_correct

                    // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูลคำตอบ
                    $sql_answer = "INSERT INTO answers (question_id, answer_text, is_correct, created_at, updated_at, answer_type, score) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)";

                    if ($stmt_answer = $conn->prepare($sql_answer)) {
                        $stmt_answer->bind_param("issssis", $question_id, $answer_text, $is_correct, $created_at, $updated_at, $question_type, $score);
                        if ($stmt_answer->execute()) {
                            $message .= "<div class='bg-green-200 text-green-800 p-4 rounded'>Answer added successfully: {$answer_text}</div>";
                        } else {
                            $message .= "<div class='bg-red-200 text-red-800 p-4 rounded'>Error adding answer: " . $stmt_answer->error . "</div>";
                        }
                        $stmt_answer->close();
                    } else {
                        $message .= "<div class='bg-red-200 text-red-800 p-4 rounded'>Error preparing answer statement: " . $conn->error . "</div>";
                    }
                }
                $stmt->close();
            } else {
                $message = "<div class='bg-red-200 text-red-800 p-4 rounded'>Error adding question: " . $stmt->error . "</div>";
            }
        } else {
            $message = "<div class='bg-red-200 text-red-800 p-4 rounded'>Error preparing question statement: " . $conn->error . "</div>";
        }
    }
}

// ปิดการเชื่อมต่อฐานข้อมูลที่นี่
// $conn->close();
?>

<!-- ฟอร์มหลักสำหรับเพิ่มคำถาม -->
<form method="post" onsubmit="return validateForm()">
    <input type="hidden" name="exercise_id" value="<?php echo htmlspecialchars($exercise_id); ?>">

    <div id="single_choice_form" class="answer-form mb-4">
        <div class="mb-4">
            <label for="question_text" class="block text-gray-700 font-semibold">ข้อความคำถาม:</label>
            <textarea id="question_text" name="question_text" required class="border border-gray-300 p-2 w-full rounded-lg focus:ring focus:ring-blue-300 transition duration-200"></textarea>
        </div>
        <div class="flex">
            <div class="mb-4 w-[70%] mr-5">
                <label for="media_url" class="block text-gray-700 font-semibold">URL สื่อ (ไม่บังคับ):</label>
                <input type="text" id="media_url" name="media_url" class="border border-gray-300 p-2 w-full rounded-lg focus:ring focus:ring-blue-300 transition duration-200">
            </div>

            <div class="mb-4 w-[30%]">
                <label for="score" class="block text-gray-700 font-semibold">คะแนน:</label>
                <input type="number" id="score" name="score" value="0" required class="border border-gray-300 p-2 w-full rounded-lg focus:ring focus:ring-blue-300 transition duration-200">
            </div>
        </div>

        <h1 class="text-2xl font-bold mb-4">เพิ่มคำตอบตัวเลือกเดียว</h1>
        <label for="answer_text" class="block text-gray-700">ข้อความคำตอบ:</label>
        <textarea id="answer_text" name="answer_text[]" class="border border-gray-300 p-2 w-full rounded"></textarea>

        <div id="is_correct_container" class="mb-4">
            <label for="is_correct" class="inline-flex items-center">
                <input type="checkbox" id="is_correct_temp" name="is_correct[]" value="1" class="mr-2">
                <span class="text-gray-700">เป็นคำตอบที่ถูกต้อง?</span>
            </label>
        </div>

        <button type="button" onclick="addSingleChoice()" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">เพิ่มคำตอบ</button>
    </div>

    <div id="added_answers" class="mt-4">
        <h2 class="text-lg font-bold">คำตอบที่เพิ่มเข้ามา:</h2>
        <ul id="answer_list" class="list-disc pl-5"></ul>
    </div>

    <?php if ($message): ?>
        <div class="bg-green-200 text-green-700 p-4 rounded mt-4"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <!-- ปุ่มบันทึกข้อมูล -->
    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 mt-4">บันทึกข้อมูล</button>
</form>

<script>
    let hasCorrectAnswer = false;

    function addSingleChoice() {
        const answerText = document.getElementById('answer_text').value.trim();
        const isCorrect = document.getElementById('is_correct_temp').checked;

        if (answerText === '') {
            alert('กรุณากรอกข้อความคำตอบ');
            return;
        }

        const answerList = document.getElementById('answer_list');
        const listItem = document.createElement('li');
        listItem.textContent = `คำตอบ: ${answerText}, เป็นคำตอบที่ถูกต้อง: ${isCorrect ? 'ใช่' : 'ไม่ใช่'}`;

        // Create hidden inputs to store answers and correctness for form submission
        const answerInput = document.createElement('input');
        answerInput.type = 'hidden';
        answerInput.name = 'answer_text[]';
        answerInput.value = answerText;

        const isCorrectInput = document.createElement('input');
        isCorrectInput.type = 'hidden';
        isCorrectInput.name = 'is_correct[]';
        isCorrectInput.value = isCorrect ? 1 : 0;

        listItem.appendChild(answerInput);
        listItem.appendChild(isCorrectInput);

        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'ลบ';
        deleteButton.className = 'bg-red-500 text-white p-1 rounded ml-2 hover:bg-red-600';
        deleteButton.onclick = function() {
            answerList.removeChild(listItem);
            if (isCorrect) {
                updateHasCorrectAnswer(answerList);
            }
        };

        listItem.appendChild(deleteButton);
        answerList.appendChild(listItem);

        if (isCorrect) {
            hasCorrectAnswer = true;
        }

        toggleIsCorrectVisibility();
        clearAnswerForm();
    }

    function toggleIsCorrectVisibility() {
        const isCorrectContainer = document.getElementById('is_correct_container');
        isCorrectContainer.style.display = hasCorrectAnswer ? 'none' : 'block';
    }

    function updateHasCorrectAnswer(answerList) {
        hasCorrectAnswer = Array.from(answerList.querySelectorAll('li'))
            .some(item => item.querySelector('input[name="is_correct[]"]').value == 1);
        toggleIsCorrectVisibility();
    }

    function clearAnswerForm() {
        document.getElementById('answer_text').value = '';
        document.getElementById('is_correct_temp').checked = false;
    }

    function validateForm() {
        const answerList = document.getElementById('answer_list');
        if (answerList.children.length === 0) {
            alert("กรุณาเพิ่มคำตอบอย่างน้อยหนึ่งคำตอบก่อนบันทึก!");
            return false;
        }
        return true;
    }
</script>
