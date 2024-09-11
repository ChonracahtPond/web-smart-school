<!-- โมดัลแก้ไขข้อมูล -->
<div id="edit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">แก้ไขผู้เข้าร่วมกิจกรรม</h2>
        <form action="" method="POST" class="space-y-4">
            <input type="hidden" id="edit-participant-id" name="participant_id">
            <div>
                <label for="edit-credits" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">เครดิต:</label>
                <input type="number" id="edit-credits" name="credits" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>
            <div>
                <label for="edit-status" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">สถานะ:</label>
                <select id="edit-status" name="status" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <option value="">-------- กรุณาเลือกสถานะ --------</option>
                    <option value="กำลังทำ">กำลังทำ</option>
                    <option value="สำเร็จ">สำเร็จ</option>
                    <option value="ไม่สำเร็จ">ไม่สำเร็จ</option>
                    <option value="พิจารณา">พิจารณา</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">บันทึกการเปลี่ยนแปลง</button>
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">ยกเลิก</button>
            </div>
        </form>
    </div>
</div>
