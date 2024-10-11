<div id="single_choice_form" class="answer-form mb-4" style="display:none;">
    <label for="answer_text" class="block text-gray-700">Answer Text:</label>
    <textarea id="answer_text" name="answer_text" required class="border border-gray-300 p-2 w-full rounded"></textarea>
    <div id="is_correct_container" class="mb-4">
        <label for='is_correct' class='inline-flex items-center'>
            <input type='checkbox' id='is_correct' name='is_correct' class='mr-2'>
            <span class='text-gray-700'>Is Correct?</span>
        </label>
    </div>
    <button type="button" onclick="addSingleChoice()" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">Add Answer</button>
</div>

<div id="added_answers" class="mt-4">
    <h2 class="text-lg font-bold">Added Answers:</h2>
    <ul id="answer_list" class="list-disc pl-5"></ul>
</div>

<script>
    let hasCorrectAnswer = false; // ตัวแปรสำหรับเก็บสถานะการมีคำตอบที่ถูกต้อง

    function addSingleChoice() {
        const answerText = document.getElementById('answer_text').value.trim();
        const isCorrect = document.getElementById('is_correct').checked;

        // ตรวจสอบว่า answerText ไม่ว่าง
        if (answerText === '') {
            alert('Please enter an answer text.'); // ข้อความเตือนเมื่อไม่กรอกข้อมูล
            return;
        }

        // แสดงคำตอบที่เพิ่ม
        const answerList = document.getElementById('answer_list');
        const listItem = document.createElement('li');
        listItem.textContent = `Answer: ${answerText}, Is Correct: ${isCorrect ? 'Yes' : 'No'}`;

        // เพิ่มปุ่มลบในรายการ
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
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
            if (item.textContent.includes('Is Correct: Yes')) {
                hasCorrectAnswer = true; // ถ้ามีคำตอบที่ถูกต้องอีก ก็ไม่ต้องรีเซ็ต
            }
        });
        toggleIsCorrectVisibility(); // อัปเดตสถานะการแสดงผล
    }
</script>
