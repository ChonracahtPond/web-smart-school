<?php
// กำหนดค่าเริ่มต้นให้กับ $message
$message = isset($message) ? $message : ''; // หรือ $message = ''; 
?>

<form id="question_form" action="?page=save_question" method="POST" onsubmit="return showConfirmation(event);">
    <input type="hidden" name="exercise_id" value="<?php echo htmlspecialchars($exercise_id); ?>">
    <div id="single_choice_form" class="answer-form mb-4" style="display:none;">
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
        <textarea id="answer_text" name="answer_text[]" class="border border-gray-300 p-2 w-full rounded"></textarea>
        <div id="is_correct_container" class="mb-4">
            <label for='is_correct' class='inline-flex items-center'>
                <input type='checkbox' id='is_correct' name='is_correct' class='mr-2'>
                <span class='text-gray-700'>เป็นคำตอบที่ถูกต้อง?</span>
            </label>
        </div>

        <button type="button" onclick="addSingleChoice()" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">เพิ่มคำตอบ</button>
    </div>

    <div id="added_answers" class="mt-4">
        <h2 class="text-lg font-bold">คำตอบที่เพิ่มเข้ามา:</h2>
        <ul id="answer_list" class="list-disc pl-5"></ul>
    </div>

    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 mt-4">บันทึกข้อมูล</button>

    <?php if ($message): ?>
        <div class="bg-green-200 text-green-700 p-4 rounded mt-4"><?php echo $message; ?></div>
    <?php endif; ?>
</form>

<script>
    let hasCorrectAnswer = false; // ตัวแปรสำหรับเก็บสถานะการมีคำตอบที่ถูกต้อง

    function addSingleChoice() {
        const answerText = document.getElementById('answer_text').value.trim();
        const isCorrect = document.getElementById('is_correct').checked;

        // ตรวจสอบว่า answerText ไม่ว่าง
        if (answerText === '') {
            alert('กรุณากรอกข้อความคำตอบ'); // ข้อความเตือนเมื่อไม่กรอกข้อมูล
            return;
        }

        // แสดงคำตอบที่เพิ่ม
        const answerList = document.getElementById('answer_list');
        const listItem = document.createElement('li');
        listItem.textContent = `คำตอบ: ${answerText ? answerText : 'ไม่มีคำตอบ'}, เป็นคำตอบที่ถูกต้อง: ${isCorrect ? 'ใช่' : 'ไม่ใช่'}`;

        // เพิ่มปุ่มลบในรายการ
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'ลบ';
        deleteButton.className = 'bg-red-500 text-white p-1 rounded ml-2 hover:bg-red-600';
        deleteButton.onclick = function() {
            answerList.removeChild(listItem);
            // เช็คคำตอบที่ถูกต้องในรายการ หากไม่มีคำตอบที่ถูกต้องให้เปลี่ยนสถานะ
            if (isCorrect) {
                updateHasCorrectAnswer(answerList);
            }
        };

        listItem.appendChild(deleteButton);
        answerList.appendChild(listItem);

        // ตรวจสอบคำตอบที่ถูกต้องหลังจากเพิ่มคำตอบใหม่
        if (isCorrect) {
            hasCorrectAnswer = true;
        }

        // ปิดการแสดง <label> ถ้ามีคำตอบที่ถูกต้องแล้ว
        toggleIsCorrectVisibility();

        // ล้างค่า textarea และ checkbox
        document.getElementById('answer_text').value = '';
        document.getElementById('is_correct').checked = false;
    }

    function toggleIsCorrectVisibility() {
        const isCorrectContainer = document.getElementById('is_correct_container');
        if (hasCorrectAnswer) {
            isCorrectContainer.style.display = 'none'; // ซ่อน <label> ถ้ามีคำตอบที่ถูกต้อง
        } else {
            isCorrectContainer.style.display = 'block'; // แสดง <label> ถ้าไม่มีคำตอบที่ถูกต้อง
        }
    }

    function updateHasCorrectAnswer(answerList) {
        hasCorrectAnswer = false; // รีเซ็ตสถานะเป็น false
        const items = answerList.querySelectorAll('li');
        items.forEach(item => {
            if (item.textContent.includes('เป็นคำตอบที่ถูกต้อง: ใช่')) {
                hasCorrectAnswer = true; // ถ้ามีคำตอบที่ถูกต้องอีก ก็ไม่ต้องรีเซ็ต
            }
        });
        toggleIsCorrectVisibility(); // อัปเดตสถานะการแสดงผล
    }

    function showConfirmation(event) {
        event.preventDefault(); // ป้องกันการส่งฟอร์มทันที

        const questionText = document.getElementById('question_text').value.trim();
        const mediaUrl = document.getElementById('media_url').value.trim();
        const score = document.getElementById('score').value.trim();
        const answerList = document.getElementById('answer_list');

        // สร้างข้อความยืนยัน
        let confirmationMessage = `คุณต้องการบันทึกข้อมูลต่อไปนี้หรือไม่?\n\n`;
        confirmationMessage += `ข้อความคำถาม: ${questionText}\n`;
        confirmationMessage += `URL สื่อ: ${mediaUrl ? mediaUrl : 'ไม่มี'}\n`;
        confirmationMessage += `คะแนน: ${score}\n`;
        confirmationMessage += `คำตอบที่เพิ่มเข้ามา:\n`;

        // ตรวจสอบและแสดงคำตอบที่เพิ่ม
        if (answerList.children.length === 0) {
            confirmationMessage += `ไม่มีคำตอบที่เพิ่ม\n`;
        } else {
            answerList.querySelectorAll('li').forEach(item => {
                confirmationMessage += `- ${item.textContent}\n`;
            });
        }

        // แสดงข้อความยืนยัน
        if (confirm(confirmationMessage)) {
            document.getElementById('question_form').submit(); // ส่งฟอร์มเมื่อผู้ใช้ยืนยัน
        }
    }
</script>