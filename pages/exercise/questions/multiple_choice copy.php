 <!-- Multiple Choice Answer Form -->
 <div id="multiple_choice_form" class="answer-form mb-4" style="display:none;">
     <div id="multiple_choice_choices">
         <label for="answer_text_1" class="block text-gray-700">Choice 1:</label>
         <textarea id="answer_text_1" name="answer_text[]" required class="border border-gray-300 p-2 w-full rounded"></textarea>
         <!-- <div class="mb-4">
                    <label for="is_correct_1" class="inline-flex items-center">
                        <input type="checkbox" id="is_correct_1" name="is_correct[]" class="mr-2">
                        <span class="text-gray-700">Is Correct?</span>
                    </label>
                </div> -->
     </div>
     <button type="button" onclick="addChoice()" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">เพิ่ม Choice</button>
     <button type="button" onclick="addMultipleChoice()" class="bg-green-500 text-white p-2 rounded hover:bg-green-600">Add Answer</button>
 </div>