<?php
// กำหนดค่าเริ่มต้นให้กับ $message
$message = isset($message) ? $message : '';
?>

<form id="question_form" action="?page=save_question" method="POST" onsubmit="return showConfirmation(event);">
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
                <input type="number" id="score" name="score" required class="border border-gray-300 p-2 w-full rounded-lg focus:ring focus:ring-blue-300 transition duration-200">
            </div>
        </div>

        <h1 class="text-2xl font-bold mb-4">เพิ่มคำตอบตัวเลือกเดียว</h1>
        <label for="answer_text" class="block text-gray-700">ข้อความคำตอบ:</label>
        <textarea id="answer_text" class="border border-gray-300 p-2 w-full rounded"></textarea>
        <div id="is_correct_container" class="mb-4">
            <label for='is_correct' class='inline-flex items-center'>
                <input type='checkbox' id='is_correct' class='mr-2'>
                <span class='text-gray-700'>เป็นคำตอบที่ถูกต้อง?</span>
            </label>
        </div>

        <button type="button" onclick="addSingleChoice()" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">เพิ่มคำตอบ</button>
    </div>

    <div id="added_answers" class="mt-4">
        <h2 class="text-lg font-bold">คำตอบที่เพิ่มเข้ามา:</h2>
        <ul id="answer_list" class="list-disc pl-5"></ul>
    </div>

    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 mt-4 ">บันทึกข้อมูล</button>

    <?php if ($message): ?>
        <div class="bg-green-200 text-green-700 p-4 rounded mt-4"><?php echo $message; ?></div>
    <?php endif; ?>
</form>

<script>
    let isCorrectSelected = false;

    function addSingleChoice() {
        const answerText = document.getElementById('answer_text').value.trim();
        const isCorrectChecked = document.getElementById('is_correct').checked;

        if (answerText === '') {
            alert('กรุณากรอกข้อความคำตอบ');
            return;
        }

        // ตรวจสอบว่ามีการเลือกคำตอบที่ถูกต้องอยู่แล้วหรือไม่
        if (isCorrectSelected && isCorrectChecked) {
            alert('สามารถเลือกคำตอบที่ถูกต้องได้เพียงข้อเดียว');
            return;
        }

        // ถ้าเลือกคำตอบที่ถูกต้องตั้งค่า flag isCorrectSelected เป็น true
        const isCorrect = isCorrectChecked ? '1' : '0';
        if (isCorrectChecked) {
            isCorrectSelected = true;
            document.getElementById('is_correct').style.display = 'none'; // ซ่อน checkbox
        }

        // สร้างคำตอบใหม่ และตั้งค่า is_correct ตามการเลือก
        const answerList = document.getElementById('answer_list');
        const listItem = document.createElement('li');
        listItem.innerHTML = `
            คำตอบ: <input type="hidden" name="answer_text[]" value="${answerText}">${answerText}
            <input type="hidden" name="is_correct[]" value="${isCorrect}">
            เป็นคำตอบที่ถูกต้อง: <span class="correct-label">${isCorrect === '1' ? 'ใช่' : 'ไม่ใช่'}</span>
        `;

        // ปุ่มลบสำหรับคำตอบ
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'ลบ';
        deleteButton.className = 'bg-red-500 text-white p-1 rounded ml-2 hover:bg-red-600';
        deleteButton.onclick = function() {
            answerList.removeChild(listItem);
            // ถ้าลบคำตอบที่ถูกต้อง ให้แสดง checkbox สำหรับ is_correct อีกครั้ง
            if (isCorrect === '1') {
                isCorrectSelected = false;
                document.getElementById('is_correct').style.display = 'inline-block';
            }
        };

        listItem.appendChild(deleteButton);
        answerList.appendChild(listItem);

        // รีเซ็ตค่าในฟอร์ม
        document.getElementById('answer_text').value = '';
        document.getElementById('is_correct').checked = false;
    }
</script>