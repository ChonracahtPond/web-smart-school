<!-- โมดอลสำหรับเพิ่มคะแนนใหม่ -->
<div id="addScoreModal" class="modal fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <div class="modal-header flex justify-between items-center border-b pb-2">
            <h5 class="text-xl font-semibold">เพิ่มคะแนนใหม่</h5>
            <button id="closeAddScoreModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <div class="modal-body mt-4">
            <form id="addScoreForm" method="POST" action="?page=add_score">
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700">รหัสนักเรียน</label>
                    <input type="text" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="student_id" name="student_id" required>
                </div>
                <div class="mb-4">
                    <label for="exam_id" class="block text-sm font-medium text-gray-700">รหัสการสอบ</label>
                    <input type="text" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="exam_id" name="exam_id" required>
                </div>
                <div class="mb-4">
                    <label for="score" class="block text-sm font-medium text-gray-700">คะแนน</label>
                    <input type="number" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="score" name="score" required>
                </div>
                <div class="mb-4">
                    <label for="exam_date" class="block text-sm font-medium text-gray-700">วันที่สอบ</label>
                    <input type="date" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="exam_date" name="exam_date" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">บันทึก</button>
            </form>
        </div>
    </div>
</div>