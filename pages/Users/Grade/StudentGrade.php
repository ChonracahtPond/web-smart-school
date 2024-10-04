<?php
// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง students
$sql = "SELECT student_id, grade_level, section, username, fullname, nicknames, email, phone_number, date_of_birth, gender FROM students WHERE  status IN ( 0 ,2)";
$result = $conn->query($sql);
?>

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">ดูข้อมูลเกรด นักเรียน-นักศึกษา</h1>

    <!-- ช่องค้นหา -->
    <div class="mb-6">
        <label for="search-input" class="block text-gray-700 dark:text-gray-300 text-lg font-medium mb-2">ค้นหา:</label>
        <input type="text" id="search-input" class="p-3 w-full border border-gray-300 rounded-lg dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500" placeholder="ค้นหาด้วย รหัสนักศึกษา, ชื่อ, หรือ เบอร์โทร">
    </div>
    <p class="text-red-500 text-1xl">**คลิกที่ชื่อเพื่อดูเกรดของนักศึกษา**</p>
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
                <th class="px-6 py-3 border-b">จัดการ</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 dark:text-gray-200">
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['grade_level']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['section']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['phone_number']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td class="px-6 py-4 border-b">
                            <form action="" method="get">
                                <input type="hidden" name="page" value="GradeList">
                                <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($row['student_id']); ?>">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition flex">
                                    <svg class="h-5 w-5 mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <circle cx="12" cy="12" r="2" />
                                        <path d="M2 12l1.5 2a11 11 0 0 0 17 0l1.5 -2" />
                                        <path d="M2 12l1.5 -2a11 11 0 0 1 17 0l1.5 2" />
                                    </svg>

                                    ดูข้อมูล
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">ไม่พบข้อมูล</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
            <tr class="text-left">
                <th class="px-6 py-3 border-b">รหัสนักศึกษา</th>
                <th class="px-6 py-3 border-b">ชื่อ-นามสกุล นักศึกษา</th>
                <th class="px-6 py-3 border-b">ชั้น</th>
                <th class="px-6 py-3 border-b">ห้อง</th>
                <th class="px-6 py-3 border-b">อีเมล</th>
                <th class="px-6 py-3 border-b">เบอร์โทร</th>
                <th class="px-6 py-3 border-b">วันเกิด</th>
                <th class="px-6 py-3 border-b">เพศ</th>
                <th class="px-6 py-3 border-b">จัดการ</th>
            </tr>
        </tfoot>
    </table>

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