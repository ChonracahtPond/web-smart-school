<!-- Modal สำหรับการแก้ไข -->
<div id="editModal" class="fixed inset-0 hidden z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white rounded-lg w-1/3 p-6">
        <h2 class="text-2xl font-bold mb-4">แก้ไขข้อมูลผลการเรียน</h2>
        <form id="editForm" method="post" action="?page=update_enrollment">
            <input type="hidden" name="enrollment_id" id="enrollment_id">
            <input type="hidden" name="student_id" id="student_id">
            <div class="mb-4">
                <label for="course_id" class="block text-sm font-bold">รหัสหลักสูตร:</label>
                <input type="text" id="course_id" name="course_id" class="w-full border rounded px-3 py-2 bg-gray-300" readonly>
            </div>
            <div class="mb-4">
                <label for="course_name" class="block text-sm font-bold">ชื่อหลักสูตร:</label>
                <input type="text" id="course_name" name="course_name" class="w-full border rounded px-3 py-2 bg-gray-300" readonly>
            </div>
            <div class="mb-4">
                <label for="semester" class="block text-sm font-bold">เทอม:</label>
                <input type="text" id="semester" name="semester" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="academic_year" class="block text-sm font-bold">ปีการศึกษา:</label>
                <input type="text" id="academic_year" name="academic_year" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="grade" class="block text-sm font-bold">เกรด:</label>
                <input type="text" id="grade" name="grade" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-bold">สถานะ:</label>
                <input type="text" id="status" name="status" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="credits" class="block text-sm font-bold">หน่วยกิต:</label>
                <input type="text" id="credits" name="credits" class="w-full border rounded px-3 py-2 bg-gray-300" readonly>
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded mr-2" id="closeModal">ยกเลิก</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">บันทึก</button>
            </div>
        </form>

    </div>
</div>