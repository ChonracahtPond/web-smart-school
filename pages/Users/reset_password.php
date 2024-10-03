<?php
// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $student_id = $_POST['student_id'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT); // เข้ารหัสรหัสผ่านใหม่

    // คำสั่ง SQL สำหรับอัพเดตรหัสผ่าน
    $sql = "UPDATE students SET password='$new_password' WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Password reset successfully'); window.location.href='?page=reset_password';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// คำสั่ง SQL สำหรับดึงข้อมูลผู้ใช้จากตาราง students
$students_sql = "SELECT student_id, fullname FROM students WHERE status IN (0, 2)";
$students_result = $conn->query($students_sql);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">รีเซ็ตรหัสผ่าน</h1>
    <form id="search-form" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ค้นหา:</label>
            <input type="text" id="search-input" class="mt-1 p-2 w-full border border-gray-300 rounded" placeholder="ค้นหา ชื่อ หรือ รหัสนักศึกษา">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">นักศึกษา:</label>
            <table id="student-table" class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 rounded">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="p-2 border border-gray-300">รหัสนักศึกษา</th>
                        <th class="p-2 border border-gray-300">ชื่อ-นามสกุล</th>
                        <th class="p-2 border border-gray-300">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $students_result->fetch_assoc()) : ?>
                        <tr>
                            <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($student['student_id']); ?></td>
                            <td class="p-2 border border-gray-300"><?php echo htmlspecialchars($student['fullname']); ?></td>
                            <td class="p-2 border border-gray-300">
                                <button type="button" class="select-btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" data-student-id="<?php echo htmlspecialchars($student['student_id']); ?>" data-student-name="<?php echo htmlspecialchars($student['fullname']); ?>">เลือก</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </form>
</div>

<!-- Modal for resetting password -->
<div id="password-reset-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg w-1/3">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">รีเซ็ตรหัสผ่าน</h2>
        <form id="reset-password-form" method="POST">
            <input type="hidden" name="student_id" id="modal-student-id">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">ชื่อ-นามสกุล นักศึกษา:</label>
                <input type="text" id="modal-student-name" class="mt-1 p-2 w-full border border-gray-300 rounded" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">รหัสผ่าน ใหม่!:</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new-password-input" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    <button type="button" id="toggle-password" class="absolute right-2 top-2 mt-1 text-gray-500 hover:text-gray-700">
                        <svg id="password-eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h.01M12 16h.01M17 12h.01M12 8h.01M5 12h.01M12 4h.01M12 20h.01M7 12h.01M9 9l-3 3 3 3M15 9l3 3-3 3"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button" id="close-modal" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">ยกเลิก</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 ml-2">ยืนยันการรีเซ็ตรหัสผ่าน</button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript for real-time search functionality
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const table = document.getElementById('student-table');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const studentId = row.cells[0].textContent.toLowerCase();
            const fullname = row.cells[1].textContent.toLowerCase();
            row.style.display = studentId.includes(searchQuery) || fullname.includes(searchQuery) ? '' : 'none';
        });
    });

    // JavaScript for handling row selection and modal display
    document.querySelectorAll('.select-btn').forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.getAttribute('data-student-id');
            const studentName = this.getAttribute('data-student-name');
            document.getElementById('modal-student-id').value = studentId;
            document.getElementById('modal-student-name').value = studentName;
            document.getElementById('password-reset-modal').classList.remove('hidden');
        });
    });

    // JavaScript for closing modal
    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('password-reset-modal').classList.add('hidden');
    });

    // JavaScript for toggling password visibility
    document.getElementById('toggle-password').addEventListener('click', function() {
        const passwordInput = document.getElementById('new-password-input');
        const passwordEyeIcon = document.getElementById('password-eye-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordEyeIcon.setAttribute('d', 'M15 12h.01M12 16h.01M17 12h.01M12 8h.01M5 12h.01M12 4h.01M12 20h.01M7 12h.01M9 9l-3 3 3 3M15 9l3 3-3 3'); // Eye icon
        } else {
            passwordInput.type = 'password';
            passwordEyeIcon.setAttribute('d', 'M15 12h.01M12 16h.01M17 12h.01M12 8h.01M5 12h.01M12 4h.01M12 20h.01M7 12h.01M9 9l-3 3 3 3M15 9l3 3-3 3'); // Eye with slash icon
        }
    });
</script>