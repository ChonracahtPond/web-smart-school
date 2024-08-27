<?php
// Default sorting order
$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'item_name';
$orderDirection = isset($_GET['order_dir']) && $_GET['order_dir'] === 'desc' ? 'desc' : 'asc';

// Fetch all items with sorting
$sql = "SELECT * FROM items ORDER BY $orderBy $orderDirection";
$result = $conn->query($sql);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
?>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">จัดการ ครุภัณฑ์-วัสดุอุปกรณ์</h1>

    <!-- Buttons to open modals -->
    <button id="addItemBtn" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">+ เพิ่มรายการใหม่</button>
    <button id="filterBtn" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500">กรองรายการ</button>
    <button id="openselectpdf" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500">เลือกรายการเพื่อออกรายงาน</button>

    <!-- Table of items -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4 border-b border-gray-200 dark:border-gray-700">อุปกรณ์ที่มีอยู่</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=item_name&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'item_name' ? 'text-blue-600' : ''; ?>">ชื่อรายการ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=item_description&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'item_description' ? 'text-blue-600' : ''; ?>">คำอธิบาย</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=quantity&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'quantity' ? 'text-blue-600' : ''; ?>">ปริมาณ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=status&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'status' ? 'text-blue-600' : ''; ?>">สถานะ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php foreach ($items as $item): ?>
                        <?php
                        $quantity = (int)$item['quantity'];
                        $quantityClass = $quantity < 10 ? 'text-red-600' : ($quantity < 20 ? 'text-yellow-600' : 'text-green-600');
                        ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['item_description']); ?></td>
                            <td class="px-6 py-4 text-sm <?php echo $quantityClass; ?> dark:text-gray-100"><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['status']); ?></td>
                            <td class="px-6 py-4 text-sm font-medium flex space-x-4">
                                <a href="?page=edit_item&item_id=<?php echo htmlspecialchars($item['item_id']); ?>" class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">แก้ไข</a>
                                <a href="?page=delete_item&delete_item=<?php echo htmlspecialchars($item['item_id']); ?>" class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div id="filterModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 w-full max-w-md">
            <div class="flex justify-between items-center p-5 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">กรองรายการ</h3>
                <button id="closeFilterModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <span class="sr-only">Close modal</span>
                    &times;
                </button>
            </div>
            <div class="p-6">
                <form action="?page=equipment_management">
                    <div class="mb-4">
                        <label for="filterSelect" class="block text-sm font-medium text-gray-700 dark:text-gray-200">เลือกตัวกรอง</label>
                        <select id="filterSelect" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-300">
                            <option value="all">ทั้งหมด</option>
                            <option value="low_quantity">ปริมาณน้อยกว่า 10</option>
                            <option value="medium_quantity">ปริมาณระหว่าง 10-20</option>
                            <option value="high_quantity">ปริมาณมากกว่า 20</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">กรอง</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "modal/modals.php" ?>
<?php include "modal/script.php" ?>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = <?php echo json_encode($items); ?>;

        // เปิด modal สำหรับเพิ่มไอเท็ม
        document.getElementById('addItemBtn').addEventListener('click', function() {
            document.getElementById('addItemModal').classList.remove('hidden');
        });

        // ปิด modal สำหรับเพิ่มไอเท็ม
        document.getElementById('closeAddItemModal').addEventListener('click', function() {
            document.getElementById('addItemModal').classList.add('hidden');
        });

        // เปิด modal สำหรับการกรองรายการ
        document.getElementById('filterBtn').addEventListener('click', function() {
            document.getElementById('filterModal').classList.remove('hidden');
        });

        // ปิด modal สำหรับการกรองรายการ
        document.getElementById('closeFilterModal').addEventListener('click', function() {
            document.getElementById('filterModal').classList.add('hidden');
        });

        // เปิด modal สำหรับการเลือกรายการเพื่อออกรายงาน
        document.getElementById('openselectpdf').addEventListener('click', function() {
            document.getElementById('selectPdfModal').classList.remove('hidden');
            loadItems();
        });

        // ปิด modal สำหรับการเลือกรายการเพื่อออกรายงาน
        document.getElementById('closeSelectPdfModal').addEventListener('click', function() {
            document.getElementById('selectPdfModal').classList.add('hidden');
        });

        // ปิด modal เมื่อคลิกปุ่ม ยืนยัน
        document.getElementById('confirmSelection').addEventListener('click', function() {
            const selectedItems = Array.from(document.querySelectorAll('#itemList input[type="checkbox"]:checked'))
                .map(checkbox => checkbox.nextElementSibling.textContent);
            if (selectedItems.length > 0) {
                // สร้าง query string สำหรับข้อมูลที่เลือก
                const queryString = new URLSearchParams({
                    items: JSON.stringify(selectedItems)
                }).toString();

                // เปลี่ยนเส้นทางไปยัง URL ที่สร้าง PDF
                window.location.href = `../mpdf/equipment/equipment_pdf.php?${queryString}`;
                document.getElementById('selectPdfModal').classList.add('hidden');
            } else {
                alert('กรุณาเลือกอย่างน้อยหนึ่งรายการ');
            }
        });

        // ฟังก์ชันในการโหลดรายการ
        function loadItems() {
            let itemList = document.getElementById('itemList');
            itemList.innerHTML = ''; // Clear previous items

            items.forEach(item => {
                let itemDiv = document.createElement('label');
                itemDiv.className = 'inline-flex items-center mb-2 item';
                itemDiv.innerHTML = `
            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" />
            <span class="ml-2 text-gray-700 item-name">${item.item_name}</span>
        `;
                itemList.appendChild(itemDiv);
            });
        }
    });
</script> -->