<?php
include "sql/sql.php";
?>

<div class="bg-white rounded-lg p-6 w-full flex flex-col justify-between">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 flex items-center">
        <i class="fas fa-plus-circle mr-2"></i> <!-- ไอคอนเพิ่ม -->
        เพิ่มข้อมูลการสอบ
    </h2>
    <form method="POST" id="courseForm" class="flex-grow bg-white p-6 ">
        <div class="mb-6">
            <label for="course" class="block text-gray-700 font-medium mb-2 ">เลือกรหัสวิชาหรือรายวิชา:</label>
            <div class="relative ">
                <select name="course" id="course" class="w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" onchange="this.form.submit()">
                    <option value="" class="text-gray-400 ">-- เลือกรหัสวิชาหรือรายวิชา --</option>
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
        </div>

        <div class="flex gap-4 mb-6">
            <div class="w-1/3">
                <label for="exam_date" class="block text-gray-700">วันที่สอบ</label>
                <input type="date" name="exam_date" id="exam_date" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="w-1/3">
                <label for="term" class="block text-gray-700">เทอม</label>
                <input type="number" name="term" id="term" placeholder="เทอม" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="w-1/3">
                <label for="year" class="block text-gray-700">ปีการศึกษา</label>
                <input type="number" name="year" id="year" placeholder="ปีการศึกษา" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-400" required>
            </div>
        </div>

        <div class="mb-6">
            <label for="totalMarks" class="block text-gray-700">คะแนนเต็ม</label>
            <input type="number" name="totalMarks" id="totalMarks" placeholder="คะแนน" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-400" required>
        </div>

        <p class="text-red-500 font-semibold mb-2">** เลือกกรอกอย่างใดอย่างหนึ่ง **</p>

        <div class="flex gap-4 mb-6">
            <div class="w-1/2">
                <label for="passingCriteria" class="block text-gray-700">เกณฑ์การผ่าน (คะแนน)</label>
                <div class="flex">
                    <input type="number" name="passingCriteria" id="passingCriteria" placeholder="คะแนน" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-400" oninput="togglePercentage()">
                    <span class="ml-2 self-center text-xl">คะแนน</span>
                </div>
            </div>
            <div class="w-1/2">
                <label for="passingPercentage" class="block text-gray-700">เกณฑ์การผ่าน (เปอร์เซ็น) <span class="text-red-500">ไม่ต้องใส่สัญลักษณ์ %</span></label>
                <div class="flex">
                    <input type="number" name="passingPercentage" id="passingPercentage" placeholder="เปอร์เซ็น" class="border border-gray-300 rounded-lg w-full p-3 focus:ring-2 focus:ring-blue-400" oninput="toggleCriteria()">
                    <span class="ml-2 self-center text-xl">%</span>
                </div>
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

        <table class="min-w-full bg-white border border-gray-300 mb-6">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="py-3 px-4 border">รหัสวิชา</th>
                    <th class="py-3 px-4 border">รหัสนักศึกษา</th>
                    <th class="py-3 px-4 border">ชื่อ-นามสกุล</th>
                    <th class="py-3 px-4 border">คะแนน</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $enrollmentData; ?>
            </tbody>
        </table>

        <div class="flex justify-end mt-6">
            <a href="?page=Manage_exam_Midterm" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-3 px-6 rounded-lg">ยกเลิก</a>
            <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg">ยืนยัน</button>
        </div>
    </form>

</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    function closeModal() {
        document.getElementById('addExamModal').classList.add('hidden');
    }
</script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Apply Select2 to the select element
        $('#course').select2({
            placeholder: "-- เลือกรหัสวิชาหรือรายวิชา --",
            allowClear: true
        });
    });
</script>