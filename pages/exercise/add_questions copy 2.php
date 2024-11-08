<?php include "sql/sql_questions.php";

$message = ""; // ตัวแปรสำหรับเก็บข้อความสถานะ

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์ม
    if (isset($_POST['exercise_id']) && isset($_POST['question_id']) && isset($_POST['answer_text'])) {
        $exercise_id = $_POST['exercise_id'];
        $question_id = $_POST['question_id'];
        $answer_text = $_POST['answer_text'];
        $is_correct = isset($_POST['is_correct']) ? 1 : 0; // แปลงเป็น 1 หรือ 0

        // เตรียมคำสั่ง SQL
        $sql = "INSERT INTO answers (exercise_id, question_id, answer_text, is_correct) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisi", $exercise_id, $question_id, $answer_text, $is_correct);

        // ดำเนินการบันทึกข้อมูล
        if ($stmt->execute()) {
            $message = "บันทึกคำตอบเรียบร้อยแล้ว!";
        } else {
            $message = "เกิดข้อผิดพลาด: " . $stmt->error;
        }

        $stmt->close();
    }
}

?>

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
</script>

<div class=" p-6 ">
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

        <div class="bg-gray-200 border border-gray-300 shadow-md rounded-lg  p-2">
            <?php include "questions/multiple_choice.php"; ?>
            <?php include "questions/single_choice.php"; ?>
            <?php include "questions/text_form.php"; ?>
            <?php include "questions/True_False.php"; ?>
        </div>



        <div class="flex justify-center">
            <input type="submit" value="เพิ่มคำถาม" class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition duration-200 mt-5">
        </div>
    </form>

    <!-- รวมฟอร์มคำตอบ -->



</div>