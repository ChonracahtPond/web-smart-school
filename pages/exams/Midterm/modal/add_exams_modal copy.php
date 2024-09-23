<!-- Modal -->
<div id="addExamModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
    <div class="bg-white rounded-lg p-4 w-96">
        <h2 class="text-xl mb-4">เพิ่มข้อมูลการสอบ</h2>
        <form id="addExamForm">
            <div class="mb-4">
                <label for="enrollmentId" class="block">Enrollment ID</label>
                <!-- แสดงค่า enrollment_id ที่ดึงมาจากฐานข้อมูล -->
                <input type="text" id="enrollmentId" class="border rounded w-full p-2" value="<?php echo $enrollmentId; ?>" required>
            </div>

            <div class="mb-4">
                <label for="examType" class="block">ประเภทการสอบ</label>
                <select id="examType" class="border rounded w-full p-2" required>
                    <option value="" disabled selected>เลือกประเภทการสอบ</option>
                    <option value="midterm">กลางภาค</option>
                    <option value="final">ปลายภาค</option>
                    <option value="quiz">การสอบย่อย</option>
                    <!-- เพิ่มตัวเลือกเพิ่มเติมตามต้องการ -->
                </select>
            </div>

            <div class="mb-4">
                <label for="examDate" class="block">วันที่สอบ</label>
                <input type="date" id="examDate" class="border rounded w-full p-2" required>
            </div>

            <div class="mb-4">
                <label for="duration" class="block">ระยะเวลา (นาที)</label>
                <input type="number" id="duration" class="border rounded w-full p-2" required>
            </div>

            <div class="mb-4">
                <label for="totalMarks" class="block">คะแนนเต็ม</label>
                <input type="number" id="totalMarks" class="border rounded w-full p-2" required>
            </div>

            <div class="mb-4">
                <label for="studentId" class="block">Student ID</label>
                <input type="text" id="studentId" class="border rounded w-full p-2" required>
            </div>

            <div class="mb-4">
                <label for="score" class="block">คะแนน</label>
                <input type="number" id="score" class="border rounded w-full p-2" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">บันทึก</button>
            <button type="button" id="closeModal" class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-2">ยกเลิก</button>
        </form>
    </div>
</div>