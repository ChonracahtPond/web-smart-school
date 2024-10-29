<?php
include "sql/sql_questions.php";

$message = ""; // ตัวแปรสำหรับเก็บข้อความสถานะ

function insertQuestion($conn, $exercise_id, $question_text, $question_type, $media_url, $score)
{
    $sql = "INSERT INTO questions (exercise_id, question_text, question_type, media_url, score) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi", $exercise_id, $question_text, $question_type, $media_url, $score);
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        throw new Exception("เกิดข้อผิดพลาด: " . $stmt->error);
    }
}

function insertAnswer($conn, $exercise_id, $question_id, $answer_text, $is_correct)
{
    $sql = "INSERT INTO answers (exercise_id, question_id, answer_text, is_correct) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $exercise_id, $question_id, $answer_text, $is_correct);
    if (!$stmt->execute()) {
        throw new Exception("เกิดข้อผิดพลาดในการเพิ่มคำตอบ: " . $stmt->error);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['question_text']) && !empty($_POST['question_type'])) {
        $exercise_id = $_POST['exercise_id'];
        $question_text = $_POST['question_text'];
        $question_type = $_POST['question_type'];
        $media_url = $_POST['media_url'] ?? null;
        $score = $_POST['score'] ?? 0;

        try {
            $question_id = insertQuestion($conn, $exercise_id, $question_text, $question_type, $media_url, $score);
            $message = "เพิ่มคำถามสำเร็จ!";

            if ($question_type === "single_choice") {
                if (!empty($_POST['answer_text'])) {
                    $answer_text = $_POST['answer_text'][0]; // รับคำตอบตัวเลือกเดียว
                    $is_correct = isset($_POST['is_correct']) ? 1 : 0; // เช็คว่าถูกต้องไหม
                    insertAnswer($conn, $exercise_id, $question_id, $answer_text, $is_correct);
                }
            } elseif ($question_type === "multiple_choice") {
                if (!empty($_POST['answer_options'])) {
                    foreach ($_POST['answer_options'] as $index => $option) {
                        $is_correct = isset($_POST['is_correct'][$index]) ? 1 : 0; // เช็คว่าถูกต้องไหม
                        insertAnswer($conn, $exercise_id, $question_id, $option, $is_correct);
                    }
                }
            } elseif ($question_type === "true_false") {
                if (isset($_POST['answer_true_false'])) {
                    $answer_text = $_POST['answer_true_false'];
                    $is_correct = ($answer_text == 'true') ? 1 : 0;
                    insertAnswer($conn, $exercise_id, $question_id, $answer_text, $is_correct);
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
    } else {
        $message = "กรุณากรอกข้อมูลในช่องคำถามและเลือกประเภทคำถามก่อนบันทึก!";
    }
}
?>

<script>
    let choiceCount = 1; // จำนวนตัวเลือกที่มีอยู่
    function showAnswerForm() {
        const questionType = document.getElementById("question_type").value;
        const answerForms = document.querySelectorAll(".answer-form");
        answerForms.forEach(form => form.style.display = "none"); // Hide all forms

        // Show relevant form based on selected question type
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
</script>

<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">เพิ่มคำถาม</h1>
    <?php if (!empty($message)): ?>
        <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <input type="hidden" name="exercise_id" value="<?php echo $exercise_id; ?>">

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
                <input type="number" id="score" name="score" required class="border border-gray-300 p-2 w-full rounded-lg focus:ring focus:ring-blue-300 transition duration-200">
            </div>
        </div>
        <div class="mb-4">
            <label for="question_type" class="block text-gray-700 font-semibold">ประเภทคำถาม:</label>
            <select id="question_type" name="question_type" class="border border-gray-300 p-2 w-full rounded-lg focus:ring focus:ring-blue-300 transition duration-200" onchange="showAnswerForm()">
                <option value="">-- เลือก --</option>
                <option value="single_choice">ตัวเลือกเดียว</option>
                <option value="multiple_choice">หลายตัวเลือก</option>
                <option value="true_false">จริง/เท็จ</option>
                <option value="text">ข้อความ</option>
            </select>
        </div>

        <div class="bg-gray-200 border border-gray-300 shadow-md rounded-lg p-2">
            <?php include "questions/multiple_choice.php"; ?>
            <?php include "questions/single_choice.php"; ?>
            <?php include "questions/text_form.php"; ?>
            <?php include "questions/True_False.php"; ?>
        </div>

        <div class="flex justify-center">
            <input type="submit" value="เพิ่มคำถาม" class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition duration-200 mt-5">
        </div>
    </form>
</div>