<!-- Text Answer Form -->
<div id="text_form" class="answer-form mb-4">
    <form action="?page=save_text_form" method="POST">
        <input type="hidden" name="exercise_id" value="<?php echo htmlspecialchars($exercise_id); ?>">
        <div class="mb-4">
            <label class="block text-gray-700" for="question_text">ข้อความคำถาม:</label>
            <textarea id="question_text" name="question_text" required class="border border-gray-300 p-2 w-full rounded"></textarea>
        </div>
        <div class="mb-4">
            <label for="media_url" class="block text-gray-700">URL สื่อ (ไม่บังคับ):</label>
            <input type="text" id="media_url" name="media_url" class="border border-gray-300 p-2 w-full rounded">
        </div>
        <div class="mb-4">
            <label for="score" class="block text-gray-700">คะแนน:</label>
            <input type="number" id="score" name="score" required class="border border-gray-300 p-2 w-full rounded">
        </div>

        <label for="answer_text_text" class="block text-gray-700">Answer Text:</label>
        <textarea id="answer_text_text" name="answer_text_text" required class="border border-gray-300 p-2 w-full rounded"></textarea>
        <input type="submit" value="Add Answer" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">
    </form>
</div>