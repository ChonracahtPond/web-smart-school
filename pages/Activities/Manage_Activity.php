<?php
// คำสั่ง SQL สำหรับค้นหาข้อมูลจากตาราง activities
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT activity_id, activity_name, description, activity_Credits, activity_hour, start_date, end_date, location, created_at, updated_at
        FROM activities
        WHERE activity_name LIKE '%$search%' OR description LIKE '%$search%'
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>



<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">จัดการกิจกรรม</h1>



    <!-- ตารางแสดงข้อมูลกิจกรรม -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <a href="admin.php?page=add_activity" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 inline-block">+เพิ่มกิจกรรมใหม่</a>
        <!-- ฟอร์มค้นหา -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
            <input type="text" id="search-input" placeholder="ค้นหากิจกรรม..." class="px-4 py-2 border rounded-lg w-full">
        </div>
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">รหัสกิจกรรม</th>
                    <th class="px-4 py-2 border-b">ชื่อกิจกรรม</th>
                    <th class="px-4 py-2 border-b">คำอธิบาย</th>
                    <th class="px-4 py-2 border-b">กิจกรรม ชั่วโมง</th>
                    <th class="px-4 py-2 border-b">หน่อวยกิต</th>
                    <th class="px-4 py-2 border-b">เริ่มวันที่</th>
                    <th class="px-4 py-2 border-b">สิ้นสุด</th>
                    <th class="px-4 py-2 border-b">สถานที่</th>
                    <th class="px-4 py-2 border-b">สร้างเมื่อ</th>
                    <th class="px-4 py-2 border-b">อัปเดตเมื่อ</th>
                    <th class="px-4 py-2 border-b">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['description']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_hour']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_Credits']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['start_date']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['end_date']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['location']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['updated_at']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <a href="admin.php?page=edit_activity&id=<?php echo htmlspecialchars($row['activity_id']); ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                                |
                                <a href="admin.php?page=delete_activity&id=<?php echo htmlspecialchars($row['activity_id']); ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this activity?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11" class="px-4 py-2 text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let isMatch = false;

            cells.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(searchQuery)) {
                    isMatch = true;
                }
            });

            row.style.display = isMatch ? '' : 'none';
        });
    });
</script>