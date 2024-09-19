<!-- Modal สำหรับการเพิ่มการเบิกวัสดุ -->
<div id="addBorrowingModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
        <h2 class="text-xl font-semibold mb-4">+ เพิ่ม รายการเบิกวัสดุ-อุปกรณ์ใหม่</h2>
        <form method="post" action="?page=add_borrowing">
            <div class="mb-4">
                <label for="item_id" class="block text-sm font-medium text-gray-700">เลือก วัสดุ-อุปกรณ์</label>
                <select id="item_id" name="item_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">-- เลือก --</option>
                    <?php while ($item = $items_result->fetch_assoc()) { ?>
                        <option value="<?php echo $item['item_id']; ?>"><?php echo htmlspecialchars($item['item_name']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">ชื่อผู้เบิกวัสดุ-อุปกรณ์</label>
                <select id="user_id" name="user_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">-- เลือก --</option>
                    <?php
                    // ดึงข้อมูลผู้ใช้เพื่อเลือกในฟอร์ม
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