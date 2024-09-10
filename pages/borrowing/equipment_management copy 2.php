<?php
// Default sorting order
$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'item_name';
$orderDirection = isset($_GET['order_dir']) && $_GET['order_dir'] === 'desc' ? 'desc' : 'asc';

// Default search term
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Build SQL query with search filter
$sql = "SELECT * FROM items WHERE item_name LIKE '%$search%' OR item_description LIKE '%$search%' OR status LIKE '%$search%' ORDER BY $orderBy $orderDirection";
$result = $conn->query($sql);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
?>


<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">จัดการ ครุภัณฑ์-วัสดุอุปกรณ์</h1>

    <!-- Buttons to open modals -->
    <!-- <div class="mb-6 flex space-x-4">
        <button id="addItemBtn" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">+ เพิ่มรายการใหม่</button>
        <button id="openselectpdf" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500">เลือกรายการเพื่อออกรายงาน</button>
        <button id="exportExcelBtn" class="px-6 py-3 bg-red-600 text-white rounded-lg shadow-lg hover:bg-red-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500">ส่งออกเป็น Excel</button>
    </div>
    <script>
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            window.location.href = '../exports/export_items.php'; // เปลี่ยนเป็นเส้นทางของไฟล์ PHP ที่คุณเก็บไว้
        });
    </script> -->

    <!-- Search and Filter Form -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mb-6 p-4">
        <div class="flex items-center space-x-4">
            <input type="text" id="search-input" placeholder="ค้นหา..." class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <!-- Category Filter -->
            <select id="category-filter" class="w-1/4 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">เลือกหมวดหมู่</option>
                <option value="electronics">อิเล็กทรอนิกส์</option>
                <option value="furniture">เฟอร์นิเจอร์</option>
            </select>

            <!-- Status Filter -->
            <select id="status-filter" class="w-1/4 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">เลือกสถานะ</option>
                <option value="available">พร้อมใช้งาน</option>
                <option value="in_maintenance">ซ่อมบำรุง</option>
                <option value="out_of_stock">หมดสต็อก</option>
            </select>
        </div>
    </div>
    <!-- Table of items -->
    <!-- <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4 border-b border-gray-200 dark:border-gray-700">อุปกรณ์ที่มีอยู่</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=item_name&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'item_name' ? 'text-blue-600' : ''; ?>">ชื่อรายการ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=item_description&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'item_description' ? 'text-blue-600' : ''; ?>">คำอธิบาย</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=category&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'category' ? 'text-blue-600' : ''; ?>">หมวดหมู่</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=quantity&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'quantity' ? 'text-blue-600' : ''; ?>">ปริมาณ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=unit&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'unit' ? 'text-blue-600' : ''; ?>">หน่วย</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=location&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'location' ? 'text-blue-600' : ''; ?>">ตำแหน่งที่เก็บ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=purchase_date&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'purchase_date' ? 'text-blue-600' : ''; ?>">วันที่ซื้อ</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=supplier&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'supplier' ? 'text-blue-600' : ''; ?>">ผู้จัดหา</a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            <a href="?order_by=purchase_price&order_dir=<?php echo $orderDirection === 'asc' ? 'desc' : 'asc'; ?>" class="hover:underline <?php echo $orderBy === 'purchase_price' ? 'text-blue-600' : ''; ?>">ราคาซื้อ</a>
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
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['category']); ?></td>
                            <td class="px-6 py-4 text-sm <?php echo $quantityClass; ?> dark:text-gray-100"><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['unit']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['location']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['purchase_date']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['supplier']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['purchase_price']); ?></td>
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
    </div> -->
    <!-- Table of items -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4 border-b border-gray-200 dark:border-gray-700">อุปกรณ์ที่มีอยู่</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            ชื่อรายการ
                        </th>
                        <!-- Add other columns here -->
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody id="item-table" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php foreach ($items as $item): ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <!-- Add other columns here -->
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

<?php include "modal/script.php"; ?>
<?php include "modal/modals.php"; ?>

<script>
    // ฟังก์ชันการค้นหาและกรองแบบเรียลไทม์
    function filterItems() {
        const searchQuery = document.getElementById('search-input').value.toLowerCase();
        const categoryFilter = document.getElementById('category-filter').value;
        const statusFilter = document.getElementById('status-filter').value;
        const rows = document.querySelectorAll('#item-table tr');

        rows.forEach(row => {
            const itemName = row.cells[0].textContent.toLowerCase();
            const category = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
            const status = row.cells[9] ? row.cells[9].textContent.toLowerCase() : '';

            const matchesSearch = itemName.includes(searchQuery);
            const matchesCategory = categoryFilter === '' || category.includes(categoryFilter);
            const matchesStatus = statusFilter === '' || status.includes(statusFilter);

            row.style.display = matchesSearch && matchesCategory && matchesStatus ? '' : 'none';
        });
    }

    document.getElementById('search-input').addEventListener('input', filterItems);
    document.getElementById('category-filter').addEventListener('change', filterItems);
    document.getElementById('status-filter').addEventListener('change', filterItems);
</script>