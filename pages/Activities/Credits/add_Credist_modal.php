<!-- ฟอร์มการเพิ่มข้อมูลที่ซ่อนอยู่ -->
<div id="add-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">เพิ่มผู้เข้าร่วมกิจกรรม</h2>
        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="activity-select" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">กิจกรรม:</label>
                <select name="activity_id" id="activity-select" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <?php while ($activity = $activities_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($activity['activity_id']); ?>" data-credits="<?php echo htmlspecialchars($activity['activity_Credits']); ?>">
                            <?php echo htmlspecialchars($activity['activity_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label for="student-select" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">นักศึกษา:</label>
                <select name="student_id" id="student-select" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <?php while ($student = $students_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($student['student_id']); ?>">
                            <?php echo htmlspecialchars($student['fullname']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label for="registration_date" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">วันที่ลงทะเบียน:</label>
                <input type="date" name="registration_date" id="registration_date" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>
            <div>
                <label for="status-select" class="block text-gray-700 dark:text-gray-300 text-sm font-medium">สถานะ:</label>
                <select name="status" id="status-select" class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <option value="">-------- กรุณาเลือกสถานะ --------</option>
                    <option value="กำลังทำ">กำลังทำ</option>
                    <option value="สำเร็จ">สำเร็จ</option>
                    <option value="ไม่สำเร็จ">ไม่สำเร็จ</option>
                    <option value="พิจารณา">พิจารณา</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" name="add" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">+ เพิ่มผู้เข้าร่วม</button>
                <button type="button" onclick="closeAddModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">ยกเลิก</button>
            </div>
        </form>
    </div>
</div>