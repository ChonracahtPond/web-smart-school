<?php
// SQL query to fetch borrowing records and related user/item data
$sql = "SELECT p.*, u.first_name, u.last_name, i.item_name 
        FROM permanent_borrowings p
        JOIN users u ON p.user_id = u.user_id
        JOIN items i ON p.item_id = i.item_id";

$result = $conn->query($sql);

// SQL query to fetch items
$items_sql = "SELECT item_id, item_name FROM items";
$items_result = $conn->query($items_sql);
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">ระบบเบิกวัสดุ-อุปกรณ์ ไม่ต้องคืน</h1>

    <!-- Add Borrowing Button -->
    <button id="addBorrowingBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
        + เพิ่มรายการเบิก
    </button>

    <!-- Borrowing Records Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">ชื่อวัสดุ-อุปกรณ์</th>
                    <th class="px-4 py-2 border-b">ชื่อผู้เบิก</th>
                    <th class="px-4 py-2 border-b">จำนวนที่เบิก</th>
                    <th class="px-4 py-2 border-b">เบิกวันที่</th>
                    <th class="px-4 py-2 border-b">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b text-center"><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td class="px-4 py-2 border-b text-center"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                            <td class="px-4 py-2 border-b text-center"><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td class="px-4 py-2 border-b text-center"><?php echo htmlspecialchars($row['borrowed_at']); ?></td>
                            <td class="px-4 py-2 border-b text-center">
                                <!-- Edit Button -->
                                <a href="?page=edit_borrowing&permanent_borrowing_id=<?php echo htmlspecialchars($row['permanent_borrowing_id']); ?>" class="text-blue-500 hover:underline">แก้ไข</a> |
                                <!-- Delete Button -->
                                <a href="?page=delete_borrowing&permanent_borrowing_id=<?php echo htmlspecialchars($row['permanent_borrowing_id']); ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this borrowing record?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">ไม่มีข้อมูลการเบิกวัสดุ</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Borrowing Modal -->
    <div id="addBorrowingModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h2 class="text-xl font-semibold mb-4">+ เพิ่มรายการ เบิกวัสดุ-อุปกรณ์ใหม่</h2>
            <form method="post" action="?page=add_borrowing">
                <div class="mb-4">
                    <label for="item_id" class="block text-sm font-medium text-gray-700">เลือก วัสดุ-อุปกรณ์</label>
                    <select id="item_id" name="item_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Select Item --</option>
                        <?php while ($item = $items_result->fetch_assoc()) { ?>
                            <option value="<?php echo $item['item_id']; ?>"><?php echo htmlspecialchars($item['item_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700">ชื่อผู้เบิกวัสดุ-อุปกรณ์</label>
                    <select id="user_id" name="user_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Select User --</option>
                        <?php
                        // Fetch users for form options
                        $users_sql = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS user_name FROM users";
                        $users_result = $conn->query($users_sql);
                        while ($user = $users_result->fetch_assoc()) { ?>
                            <option value="<?php echo $user['user_id']; ?>"><?php echo htmlspecialchars($user['user_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">จำนวน</label>
                    <input type="number" id="quantity" name="quantity" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    เพิ่ม
                </button>
                <button type="button" id="closeAddBorrowingModal" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mt-2">
                    ปิด
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Open the modal for adding a new borrowing record
        document.getElementById('addBorrowingBtn').addEventListener('click', function() {
            document.getElementById('addBorrowingModal').classList.remove('hidden');
        });

        // Close the modal for adding a new borrowing record
        document.getElementById('closeAddBorrowingModal').addEventListener('click', function() {
            document.getElementById('addBorrowingModal').classList.add('hidden');
        });
    });
</script>