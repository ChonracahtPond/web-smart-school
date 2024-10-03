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

<div class="p-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">จัดการกิจกรรม กพช.</h1>

    <!-- ปุ่มเพิ่มกิจกรรมใหม่ -->
    <a href="?page=add_activity" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 inline-block">+ เพิ่มกิจกรรมใหม่</a>
    <div class="bg-gray-200 w-full h-0.5 my-5"></div>

    <!-- ฟอร์มค้นหา -->
    <form method="GET" action="" class="relative flex mt-4">
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

    <!-- ตารางข้อมูลกิจกรรม -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <table id="activityTable" class="stripe hover w-full" style="width:100%;">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th>รหัสกิจกรรม</th>
                    <th>ชื่อกิจกรรม</th>
                    <th>คำอธิบาย</th>
                    <th>หน่วยกิต</th>
                    <th>ชั่วโมง</th>
                    <th>เริ่มวันที่</th>
                    <th>สิ้นสุดวันที่</th>
                    <th>สถานที่</th>
                    <th>ประเภทกิจกรรม</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['activity_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['activity_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['activity_credits']); ?></td>
                            <td><?php echo htmlspecialchars($row['activity_hour']); ?></td>
                            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><?php echo htmlspecialchars($row['activity_type']); ?></td>
                            <td class="flex">
                                <a href="?page=edit_activity&id=<?php echo htmlspecialchars($row['activity_id']); ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-150 ease-in-out inline-flex items-center">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                        <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg>
                                    <span class="hidden sm:inline">แก้ไข</span>
                                </a>
                                <a href="?page=delete_activity&id=<?php echo htmlspecialchars($row['activity_id']); ?>" class="ml-2 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-150 ease-in-out inline-flex items-center" onclick="return confirm('คุณแน่ใจที่จะลบกิจกรรมนี้ใช่หรือไม่?')">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        <line x1="10" y1="11" x2="10" y2="17" />
                                        <line x1="14" y1="11" x2="14" y2="17" />
                                    </svg>
                                    <span class="hidden sm:inline">ลบ</span>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th>รหัสกิจกรรม</th>
                    <th>ชื่อกิจกรรม</th>
                    <th>คำอธิบาย</th>
                    <th>หน่วยกิต</th>
                    <th>ชั่วโมง</th>
                    <th>เริ่มวันที่</th>
                    <th>สิ้นสุดวันที่</th>
                    <th>สถานที่</th>
                    <th>ประเภทกิจกรรม</th>
                    <th>การดำเนินการ</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<!-- DataTables initialization -->
<script>
    $(document).ready(function() {
        $('#activityTable').DataTable({
            responsive: true
        });
    });
</script>





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