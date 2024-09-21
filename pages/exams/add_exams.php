<?php
include "sql/sql.php";
?>

<div class="bg-white rounded-lg p-6 w-full flex flex-col justify-between">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 flex items-center">
        <i class="fas fa-plus-circle mr-2"></i> <!-- ไอคอนเพิ่ม -->
        เพิ่มข้อมูลการสอบ
    </h2>
    <form method="POST" id="courseForm" class="flex-grow">
        <div class="mb-4">
            <label for="course" class="block text-gray-700 font-medium mb-2">เลือกคอร์ส:</label>
            <select name="course" id="course" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                <option value="">-- เลือกคอร์ส --</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['course_id'] . "'" . (isset($course_id) && $course_id == $row['course_id'] ? ' selected' : '') . ">" . htmlspecialchars($row['course_id']) . " " . htmlspecialchars($row['course_name']) . "</option>";
                    }
                } else {
                    echo "<option value=''>ไม่มีคอร์ส</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="totalMarks" class="block">คะแนนเต็ม</label>
            <input type="number" name="totalMarks" id="totalMarks" placeholder='คะแนน' class="border rounded w-full p-2" required>
        </div>

        <p class="text-red-500">** เลือกกรอกอย่างใดอย่างหนึ่ง **</p>
        <div class="mb-4">
            <label for="passingCriteria" class="block">เกณฑ์การผ่าน (คะแนน)</label>
            <div class="flex">
                <input type="number" name="passingCriteria" id="passingCriteria" placeholder='คะแนน' class="border rounded w-full p-2 focus:outline-none" oninput="togglePercentage()">
                <span class="text-center mt-1 ml-2 text-2xl">คะแนน</span>
            </div>
        </div>
        <div class="mb-4">
            <label for="passingPercentage" class="block">เกณฑ์การผ่าน (เปอร์เซ็น) <span class="text-red-500">ไม่ต้องใส่สัญลักษณ์ %</span></label>
            <div class="flex">
                <input type="text" name="passingPercentage" id="passingPercentage" placeholder='เปอร์เซ็น' class="border rounded w-full p-2 focus:outline-none" oninput="toggleCriteria()">
                <span class="text-center mt-1 ml-2 text-2xl">%</span>
            </div>
        </div>

        <script>
            function togglePercentage() {
                const criteriaInput = document.getElementById('passingCriteria');
                const percentageInput = document.getElementById('passingPercentage');

                if (criteriaInput.value) {
                    percentageInput.value = ''; // Clear the percentage field
                    percentageInput.disabled = true; // Disable the percentage input
                    percentageInput.classList.remove('bg-white', 'text-black');
                    percentageInput.classList.add('bg-gray-200', 'text-gray-400'); // Tailwind classes for disabled
                } else {
                    percentageInput.disabled = false; // Enable the percentage input
                    percentageInput.classList.remove('bg-gray-200', 'text-gray-400');
                    percentageInput.classList.add('bg-white', 'text-black'); // Tailwind classes for enabled
                }
            }

            function toggleCriteria() {
                const criteriaInput = document.getElementById('passingCriteria');
                const percentageInput = document.getElementById('passingPercentage');

                if (percentageInput.value) {
                    criteriaInput.value = ''; // Clear the criteria field
                    criteriaInput.disabled = true; // Disable the criteria input
                    criteriaInput.classList.remove('bg-white', 'text-black');
                    criteriaInput.classList.add('bg-gray-200', 'text-gray-400'); // Tailwind classes for disabled
                } else {
                    criteriaInput.disabled = false; // Enable the criteria input
                    criteriaInput.classList.remove('bg-gray-200', 'text-gray-400');
                    criteriaInput.classList.add('bg-white', 'text-black'); // Tailwind classes for enabled
                }
            }
        </script>



        <table class="min-w-full bg-white border border-gray-300 mb-4">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-2 px-4 border">รหัสวิชา</th>
                    <th class="py-2 px-4 border">รหัสนักศึกษา</th>
                    <th class="py-2 px-4 border">ชื่อ-นามสกุล</th>
                    <th class="py-2 px-4 border">คะแนน</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $enrollmentData; ?>
            </tbody>
        </table>

        <div class="flex justify-end space-x-2 mt-4">
            <button type="button" id="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-lg" onclick="closeModal()">ยกเลิก</button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg">ยืนยัน</button>
        </div>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    function closeModal() {
        document.getElementById('addExamModal').classList.add('hidden');
    }
</script>