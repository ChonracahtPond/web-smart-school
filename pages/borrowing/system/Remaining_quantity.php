<?php

// Fetch users for borrower dropdown
$sql_users = "SELECT user_id, first_name, last_name FROM users";
$users_result = $conn->query($sql_users);

// Fetch borrowings for returning including the borrower's name and aggregate borrowings by user_id
$sql_borrowings = "SELECT u.user_id, u.first_name, u.last_name, GROUP_CONCAT(i.item_name SEPARATOR ', ') AS items, SUM(b.quantity) AS total_quantity
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        JOIN users u ON b.user_id = u.user_id
        WHERE b.returned_at IS NULL
        GROUP BY u.user_id, u.first_name, u.last_name";
$borrowings_result = $conn->query($sql_borrowings);

// Make sure to close the connection after all queries are executed
// $conn->close();
?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">รายการการยืมอุปกรณ์</h2>

    <!-- ค้นหาผู้ยืม -->
    <div class="mb-4">
        <label for="search_borrower" class="block text-sm font-medium text-gray-700">ค้นหาผู้ยืม:</label>
        <input type="text" id="search_borrower" name="search_borrower" class="form-input mt-1 block w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="ค้นหาชื่อผู้ยืม...">
    </div>

    <!-- ตารางแสดงรายการยืม -->
    <table class="min-w-full bg-white border rounded-md">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b">ชื่อผู้ยืม</th>
                <th class="py-2 px-4 border-b">ชื่ออุปกรณ์</th>
                <th class="py-2 px-4 border-b">จำนวนที่ยืมรวม</th>
                <th class="py-2 px-4 border-b">การดำเนินการ</th>
            </tr>
        </thead>
        <tbody id="borrowings_table">
            <?php while ($row = $borrowings_result->fetch_assoc()) { ?>
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b "><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($row['items'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($row['total_quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="py-2 px-4 border-b text-center">
                        <a href="?page=BorrowingDetails&user_id=<?php echo htmlspecialchars($row['user_id'], ENT_QUOTES, 'UTF-8'); ?>" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">ดูรายละเอียด</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    // ฟังก์ชันค้นหาผู้ยืม
    document.getElementById('search_borrower').addEventListener('input', function() {
        var searchValue = this.value.toLowerCase();
        var rows = document.getElementById('borrowings_table').getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var borrowerName = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
            if (borrowerName.includes(searchValue) || searchValue === '') {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });
</script>