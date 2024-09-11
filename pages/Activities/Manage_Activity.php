<?php
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$filter_activity_type = isset($_GET['activity_type']) ? $conn->real_escape_string($_GET['activity_type']) : '';

$sql = "SELECT activity_id, activity_name, description, activity_credits, activity_hour, start_date, end_date, location, activity_type
        FROM activities
        WHERE (activity_name LIKE '%$search%' OR description LIKE '%$search%')";

if (!empty($filter_activity_type)) {
    $sql .= " AND activity_type = '$filter_activity_type'";
}

$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);

$type_sql = "SELECT DISTINCT activity_type FROM activities ORDER BY activity_type";
$type_result = $conn->query($type_sql);

?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">จัดการกิจกรรม กพช.</h1>

    <!-- ปุ่มเพิ่มกิจกรรมใหม่ -->
    <a href="?page=add_activity" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 inline-block">+ เพิ่มกิจกรรมใหม่</a>

    <!-- ฟอร์มค้นหา -->
    <form method="GET" action="" class="relative flex bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <input type="text" name="search" id="search-input" placeholder="ค้นหากิจกรรม..." class="px-4 py-2 border rounded-lg w-full mb-4 mr-5" value="<?php echo htmlspecialchars($search); ?>" />

        <!-- ฟิลเตอร์ประเภทกิจกรรม -->
        <select name="activity_type" class="px-4 py-2 border rounded-lg w-full mb-4">
            <option value="">-- เลือกประเภทกิจกรรม --</option>
            <?php while ($type_row = $type_result->fetch_assoc()) : ?>
                <option value="<?php echo htmlspecialchars($type_row['activity_type']); ?>" <?php if ($filter_activity_type == $type_row['activity_type']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($type_row['activity_type']); ?>
                </option>
            <?php endwhile; ?>
        </select>

    
    </form>
    
    <!-- ตารางแสดงข้อมูลกิจกรรม -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">รหัสกิจกรรม</th>
                    <th class="px-4 py-2 border-b">ชื่อกิจกรรม</th>
                    <th class="px-4 py-2 border-b">คำอธิบาย</th>
                    <th class="px-4 py-2 border-b">หน่วยกิต</th>
                    <th class="px-4 py-2 border-b">ชั่วโมง</th>
                    <th class="px-4 py-2 border-b">เริ่มวันที่</th>
                    <th class="px-4 py-2 border-b">สิ้นสุดวันที่</th>
                    <th class="px-4 py-2 border-b">สถานที่</th>
                    <th class="px-4 py-2 border-b">ประเภทกิจกรรม</th>
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
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_credits']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_hour']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['start_date']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['end_date']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['location']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_type']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <a href="?page=edit_activity&id=<?php echo htmlspecialchars($row['activity_id']); ?>" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i> Edit
                                </a> |
                                <a href="?page=delete_activity&id=<?php echo htmlspecialchars($row['activity_id']); ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('คุณแน่ใจที่จะลบกิจกรรมนี้ใช่หรือไม่?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="px-4 py-2 text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- <script>
    // ฟังก์ชั่นกรองการแสดงผลตารางตามคำค้นหา
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
</script> -->

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

    // ฟังก์ชันกรองตามประเภทกิจกรรม
    document.querySelector('select[name="activity_type"]').addEventListener('change', function() {
        const selectedType = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const typeCell = row.querySelector('td:nth-child(9)').textContent.toLowerCase(); // เปลี่ยนตามลำดับของคอลัมน์ประเภทกิจกรรม

            if (selectedType === '' || typeCell.includes(selectedType)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>