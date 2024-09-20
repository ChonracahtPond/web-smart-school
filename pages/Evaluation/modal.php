<!-- Modal Structure -->
<!-- <div id="evaluationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 w-full max-w-lg">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-2">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">เพิ่ม/แก้ไขการประเมินผล</h2>
            <button id="closeModal" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">&times;</button>
        </div>
        <form method="post" action="" class="mt-4">
            <div class="mb-4">
                <label for="evaluation_name" class="block text-gray-700 dark:text-gray-400">ชื่อการประเมินผล</label>
                <input type="text" name="evaluation_name" id="evaluation_name" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="evaluation_date" class="block text-gray-700 dark:text-gray-400">วันที่ประเมิน</label>
                <input type="date" name="evaluation_date" id="evaluation_date" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="evaluation_score" class="block text-gray-700 dark:text-gray-400">คะแนนการประเมินผล</label>
                <input type="number" step="0.01" name="evaluation_score" id="evaluation_score" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="comments" class="block text-gray-700 dark:text-gray-400">ความคิดเห็น</label>
                <textarea name="comments" id="comments" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
            </div>
            <div class="mb-4">
                <label for="google_form_link" class="block text-gray-700 dark:text-gray-400">Google Form Link</label>
                <input type="url" name="google_form_link" id="google_form_link" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <input type="hidden" name="evaluation_id" value="<?php echo isset($_GET['edit']) ? htmlspecialchars($_GET['edit']) : ''; ?>">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">บันทึกการประเมินผล</button>
        </form>
    </div>
</div> -->




<!-- Modal Structure -->
<div id="evaluationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 w-full max-w-lg">
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-2">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">เพิ่ม/แก้ไขการประเมินผล</h2>
            <button id="closeModal" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">&times;</button>
        </div>
        <form id="evaluationForm" method="post" action="" class="mt-4">
            <div class="mb-4">
                <label for="evaluation_name" class="block text-gray-700 dark:text-gray-400">ชื่อการประเมินผล</label>
                <input type="text" name="evaluation_name" id="evaluation_name" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="evaluation_date" class="block text-gray-700 dark:text-gray-400">วันที่ประเมิน</label>
                <input type="date" name="evaluation_date" id="evaluation_date" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="evaluation_score" class="block text-gray-700 dark:text-gray-400">คะแนนการประเมินผล</label>
                <input type="number" step="0.01" name="evaluation_score" id="evaluation_score" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="comments" class="block text-gray-700 dark:text-gray-400">ความคิดเห็น</label>
                <textarea name="comments" id="comments" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
            </div>
            <div class="mb-4">
                <label for="google_form_link" class="block text-gray-700 dark:text-gray-400">Google Form Link</label>
                <input type="url" name="google_form_link" id="google_form_link" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <input type="hidden" name="evaluation_id" id="evaluation_id">
            <button type="submit" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                บันทึกการประเมินผล
            </button>
        </form>
    </div>
</div>