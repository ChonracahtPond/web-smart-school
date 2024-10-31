<!-- True/False Answer Form -->
<!-- <div id="true_false_form" class="answer-form mb-4"> -->
<form action="?page=save_True_False" method="POST">
    <input type="hidden" name="exercise_id" value="<?php echo htmlspecialchars($exercise_id); ?>">
    <div class="mb-4">
        <label class="block text-gray-700" for="question_text">ข้อความคำถาม:</label>
        <textarea id="question_text" name="question_text" required class="border border-gray-300 p-2 w-full rounded-lg focus:ring focus:ring-blue-300 transition duration-200"></textarea>
    </div>
    <div class="mb-4">
        <label for="media_url" class="block text-gray-700">URL สื่อ (ไม่บังคับ):</label>
        <input type="text" id="media_url" name="media_url" class="border border-gray-300 p-2 w-full rounded-lg focus:ring focus:ring-blue-300 transition duration-200">
    </div>
    <div class="mb-4">
        <label for="score" class="block text-gray-700">คะแนน:</label>
        <input type="number" id="score" name="score" required class="border border-gray-300 p-2 w-full rounded-lg focus:ring focus:ring-blue-300 transition duration-200">
    </div>

    <label class="block text-gray-700">เลือกคำตอบ:</label>
    <div class="inline-flex items-center">
        <input type="radio" id="true_answer" name="true_false_answer" value="true" class="mr-2" required>
        <label for="true_answer" class="mr-4">True</label>

        <input type="radio" id="false_answer" name="true_false_answer" value="false" class="mr-2" required>
        <label for="false_answer">False</label>
    </div>

    <input type="submit" value="เพิ่มคำตอบ" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">
</form>
<!-- </div> -->