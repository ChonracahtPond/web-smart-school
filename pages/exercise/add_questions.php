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

    <!-- <form method="post" action=""> -->
    <input type="hidden" name="exercise_id" value="<?php echo $exercise_id; ?>">

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
</div>