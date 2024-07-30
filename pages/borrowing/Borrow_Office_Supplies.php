<?php

// คำสั่ง SQL สำหรับดึงข้อมูลการเบิกวัสดุ
$sql = "SELECT * FROM permanent_borrowings";
$result = $conn->query($sql);

// คำสั่ง SQL สำหรับดึงข้อมูลวัสดุ
$items_sql = "SELECT item_id, item_name FROM items";
$items_result = $conn->query($items_sql);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Manage Borrowed Office Supplies</h1>

    <!-- ปุ่มเพิ่มการเบิกวัสดุ -->
    <button id="addBorrowingBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Add New Borrowing</button>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">Item Name</th>
                    <th class="px-4 py-2 border-b">Borrower Name</th>
                    <th class="px-4 py-2 border-b">Quantity</th>
                    <th class="px-4 py-2 border-b">Borrowed At</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b">
                                <?php
                                // หาชื่อวัสดุ
                                $item_sql = "SELECT item_name FROM items WHERE item_id = " . $row['item_id'];
                                $item_result = $conn->query($item_sql);
                                $item = $item_result->fetch_assoc();
                                echo htmlspecialchars($item['item_name']);
                                ?>
                            </td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['borrower_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['borrowed_at']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <!-- ปุ่มแก้ไข -->
                                <a href="?page=edit_borrowing&permanent_borrowing_id=<?php echo htmlspecialchars($row['permanent_borrowing_id']); ?>" class="text-blue-500 hover:underline">Edit</a> |
                                <!-- ปุ่มลบ -->
                                <a href="?page=delete_borrowing&permanent_borrowing_id=<?php echo htmlspecialchars($row['permanent_borrowing_id']); ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this borrowing record?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal สำหรับการเพิ่มการเบิกวัสดุ -->
    <div id="addBorrowingModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h2 class="text-xl font-semibold mb-4">Add New Borrowing</h2>
            <form method="post" action="?page=add_borrowing">
                <div class="mb-4">
                    <label for="item_id" class="block text-sm font-medium text-gray-700">Select Item</label>
                    <select id="item_id" name="item_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Select Item --</option>
                        <?php while ($item = $items_result->fetch_assoc()) { ?>
                            <option value="<?php echo $item['item_id']; ?>"><?php echo htmlspecialchars($item['item_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="borrower_name" class="block text-sm font-medium text-gray-700">Borrower Name</label>
                    <input type="text" id="borrower_name" name="borrower_name" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" id="quantity" name="quantity" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add Borrowing
                </button>
                <button type="button" id="closeAddBorrowingModal" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mt-2">
                    Close
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // เปิด modal สำหรับเพิ่มการเบิกวัสดุ
        document.getElementById('addBorrowingBtn').addEventListener('click', function() {
            document.getElementById('addBorrowingModal').classList.remove('hidden');
        });

        // ปิด modal สำหรับเพิ่มการเบิกวัสดุ
        document.getElementById('closeAddBorrowingModal').addEventListener('click', function() {
            document.getElementById('addBorrowingModal').classList.add('hidden');
        });
    });
</script>