<?php
// ดึงข้อมูลครุภัณฑ์ทั้งหมด
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">จัดการ ครุภัณฑ์-วัสดุอุปกรณ์</h1>

    <!-- Button to open Add Item Modal -->
    <button id="addItemBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition duration-150">+ เพิ่มรายการใหม่</button>

    <!-- Table of equipment -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4">อุปกรณ์ที่มีอยู่</h2>
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อรายการ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">คำอธิบาย</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ปริมาณ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">การดำเนินการ</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <?php
                    // กำหนดคลาสตามค่า quantity
                    $quantity = (int)$row['quantity'];
                    if ($quantity < 10) {
                        $quantityClass = 'text-red-600';
                    } elseif ($quantity >= 10 && $quantity < 20) {
                        $quantityClass = 'text-yellow-600';
                    } else {
                        $quantityClass = 'text-green-600';
                    }
                    ?>
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['item_description']); ?></td>
                        <td class="px-6 py-4 text-sm <?php echo $quantityClass; ?> dark:text-gray-100"><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['status']); ?></td>
                        <td class="px-6 py-4 text-sm font-medium flex space-x-4">
                            <a href="?page=edit_item&item_id=<?php echo htmlspecialchars($row['item_id']); ?>" class="text-blue-600 hover:text-blue-900 transition duration-150">แก้ไข</a>
                            <a href="?page=delete_item&delete_item=<?php echo htmlspecialchars($row['item_id']); ?>" class="text-red-600 hover:text-red-900 transition duration-150" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?')">ลบ</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "modals.php" ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // เปิด modal สำหรับเพิ่มไอเท็ม
        document.getElementById('addItemBtn').addEventListener('click', function() {
            document.getElementById('addItemModal').classList.remove('hidden');
        });

        // ปิด modal สำหรับเพิ่มไอเท็ม
        document.getElementById('closeAddItemModal').addEventListener('click', function() {
            document.getElementById('addItemModal').classList.add('hidden');
        });
    });
</script>
