<?php
// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง students
$sql = "SELECT student_id, grade_level, section, username, fullname, nicknames, email, phone_number, date_of_birth, gender FROM students";
$result = $conn->query($sql);
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">หน่วยกิต นักเรียน-นักศึกษา</h1>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <!-- ช่องค้นหา -->
        <div class="mb-6">
            <label for="search-input" class="block text-gray-700 dark:text-gray-300 text-lg font-medium mb-2">ค้นหา:</label>
            <input type="text" id="search-input" class="p-3 w-full border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500" placeholder="ค้นหาด้วย รหัสนักศึกษา, ชื่อ, หรือ เบอร์โทร">
        </div>

        <table id="students-table" class="w-full border-collapse bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                <tr class="text-left">
                    <th class="px-6 py-3 border-b">รหัสนักศึกษา</th>
                    <th class="px-6 py-3 border-b">ชื่อ-นามสกุล นักศึกษา</th>
                    <th class="px-6 py-3 border-b">ชั้น</th>
                    <th class="px-6 py-3 border-b">ห้อง</th>
                    <th class="px-6 py-3 border-b">อีเมล</th>
                    <th class="px-6 py-3 border-b">เบอร์โทร</th>
                    <th class="px-6 py-3 border-b">วันเกิด</th>
                    <th class="px-6 py-3 border-b">เพศ</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 dark:text-gray-200">
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors" onclick="window.location.href='system.php?page=creditList&student_id=<?php echo htmlspecialchars($row['student_id']); ?>'">
                            <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['grade_level']); ?></td>
                            <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['section']); ?></td>
                            <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['phone_number']); ?></td>
                            <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                            <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['gender']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // JavaScript สำหรับการค้นหาแบบเรียลไทม์
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const table = document.getElementById('students-table');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const studentId = row.cells[0].textContent.toLowerCase();
            const fullname = row.cells[1].textContent.toLowerCase();
            const username = row.cells[3].textContent.toLowerCase();
            row.style.display = studentId.includes(searchQuery) || fullname.includes(searchQuery) || username.includes(searchQuery) ? '' : 'none';
        });
    });
</script>