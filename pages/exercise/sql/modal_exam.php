<!-- Modal สำหรับการแก้ไขคำถาม -->
<div id="edit-question-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-5 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">แก้ไขคำถาม</h2>
        <input type="hidden" id="question-id" />
        <label for="question-text" class="block text-gray-700">คำถาม:</label>
        <input type="text" id="question-text" class="border border-gray-300 rounded-md p-2 w-full mb-4" />
        <label for="question-score" class="block text-gray-700">คะแนน:</label>
        <input type="number" id="question-score" class="border border-gray-300 rounded-md p-2 w-full mb-4" />
        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="updateQuestion()">บันทึก</button>
        <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 ml-2" onclick="closeModal('edit-question-modal')">ยกเลิก</button>
    </div>
</div>

<!-- Modal สำหรับแก้ไขคำตอบ -->
<div id="editAnswerModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">แก้ไขคำตอบ</h2>
    <form id="editAnswerForm" method="POST" action="?page=update_answer">
      <input type="hidden" id="editAnswerId" name="answer_id">
      <div class="mb-4">
        <label for="answerText" class="block text-gray-700">คำตอบ</label>
        <input type="text" id="answerText" name="answer_text" class="border border-gray-300 p-2 w-full rounded" required>
      </div>
      <div class="mb-4">
        <label for="answerScore" class="block text-gray-700">คะแนน</label>
        <input type="number" id="answerScore" name="score" class="border border-gray-300 p-2 w-full rounded" required>
      </div>
      <div class="mb-4">
        <label for="isCorrect" class="block text-gray-700">ถูกต้องหรือไม่</label>
        <select id="isCorrect" name="is_correct" class="border border-gray-300 p-2 w-full rounded">
          <option value="true">ถูกต้อง</option>
          <option value="false">ไม่ถูกต้อง</option>
        </select>
      </div>
      <div class="flex justify-end">
        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2" onclick="closeModal()">ยกเลิก</button>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">บันทึก</button>
      </div>
    </form>
  </div>
</div>
