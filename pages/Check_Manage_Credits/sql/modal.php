<?php



// ดึงข้อมูลจากตาราง activity
$activities_sql = "SELECT activity_id, activity_name FROM activities";
$activities_result = $conn->query($activities_sql);

// ดึงข้อมูลจากตาราง students ที่มีสถานะ 0
$students_sql = "SELECT student_id, fullname FROM students WHERE status = 0";
$students_result = $conn->query($students_sql);
?>



<!-- Modal -->
<div id="addFormModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative shadow-xl">
        <button onclick="toggleAddForm()" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">เพิ่มผู้เข้าร่วมกิจกรรม</h2>

        <form action="?page=save_credits" method="POST" enctype="multipart/form-data"> <!-- เพิ่ม enctype สำหรับอัพโหลดไฟล์ -->
            <input type="hidden" name="action" value="add">

            <!-- Dropdown สำหรับเลือก activity -->
            <div class="mb-4">
                <label for="activity_id" class="block text-gray-700">รหัสกิจกรรม:</label>
                <select id="activity_id" name="activity_id" required class="border w-full px-3 py-2 rounded">
                    <option value="">เลือกกิจกรรม</option>
                    <?php while ($activity = $activities_result->fetch_assoc()) : ?>
                        <option value="<?php echo $activity['activity_id']; ?>">
                            <?php echo htmlspecialchars($activity['activity_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Dropdown สำหรับเลือก student -->
            <div class="mb-4">
                <label for="student_id" class="block text-gray-700">รหัสนักศึกษา:</label>
                <select id="student_id" name="student_id" required class="border w-full px-3 py-2 rounded">
                    <option value="">เลือกนักศึกษา</option>
                    <?php while ($student = $students_result->fetch_assoc()) : ?>
                        <option value="<?php echo $student['student_id']; ?>">
                            <?php echo htmlspecialchars($student['fullname']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="registration_date" class="block text-gray-700">วันที่ลงทะเบียน:</label>
                <input type="date" id="registration_date" name="registration_date" required class="border w-full px-3 py-2 rounded">
            </div>

            <div class="mb-4">
                <label for="credits" class="block text-gray-700">เครดิตกิจกรรม:</label>
                <input type="number" id="credits" name="credits" required class="border w-full px-3 py-2 rounded">
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700">อัพโหลดภาพ:</label>
                <input type="file" id="image" name="image" accept="image/*" required class="border w-full px-3 py-2 rounded">
            </div>

            <button type="submit" class="w-full mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-150 ease-in-out">
                บันทึก
            </button>
        </form>
    </div>
</div>



<script>
    function toggleAddForm() {
        const modal = document.getElementById('addFormModal');
        modal.classList.toggle('hidden');
    }
</script>