    <!-- True/False Answer Form -->
    <div id="true_false_form" class="answer-form mb-4" style="display:none;">
        <label class="block text-gray-700">Select Answer:</label>
        <div class="inline-flex items-center">
            <input type="radio" id="true_answer" name="true_false_answer" value="true" class="mr-2">
            <label for="true_answer" class="mr-4">True</label>

            <input type="radio" id="false_answer" name="true_false_answer" value="false" class="mr-2">
            <label for="false_answer">False</label>
        </div>
        <div class="mb-4">
            <label for="is_correct_true_false" class="inline-flex items-center">
                <input type="checkbox" id="is_correct_true_false" name="is_correct_true_false" class="mr-2">
                <span class="text-gray-700">Is Correct?</span>
            </label>
        </div>
        <input type="submit" value="Add Answer" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">
    </div>