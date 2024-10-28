<?php
// Default sorting order
$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'item_name';
$orderDirection = isset($_GET['order_dir']) && $_GET['order_dir'] === 'desc' ? 'desc' : 'asc';

// Default search term
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Fetch categories
$sql_categories = "SELECT DISTINCT category FROM items";
$result_categories = $conn->query($sql_categories);

$categories = [];
while ($row = $result_categories->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Fetch status
$sql_status = "SELECT DISTINCT status FROM items";
$result_status = $conn->query($sql_status);

$status1 = [];
while ($row = $result_status->fetch_assoc()) {
    $status1[] = $row['status'];
}

// Build SQL query with search filter
$sql = "SELECT * FROM items WHERE item_name LIKE '%$search%' OR item_description LIKE '%$search%' OR status LIKE '%$search%' ORDER BY $orderBy $orderDirection";
$result = $conn->query($sql);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

$conn->close();
?>


<div class=" mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">จัดการ ครุภัณฑ์-วัสดุอุปกรณ์</h1>


    <!-- Buttons to open modals -->
    <div class="mb-6 flex space-x-4">
        <button id="addItemBtn" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">+ เพิ่มรายการใหม่</button>
        <!-- Dropdown Button -->
        <div class="relative inline-block text-left ">
            <div>
                <button type="button" class="ml-3 flex px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150 shadow-sm ring-1 ring-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" id="dropdownButton" aria-expanded="true" aria-haspopup="true">
                    รายงาน
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <div id="dropdownMenu" class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-gray-300 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="dropdownButton">
                <div class="p-1" role="none">
                    <a href="../mpdf/equipment/equipment_pdf.php" id="exportAllReports" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">ออกรายงานทั้งหมด</a>
                    <a href="#" id="selectReports" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">เลือกรายการเพื่อออกรายงาน</a>
                </div>
            </div>
        </div>
        <p id="openselectpdf"></p>
        <!-- <button id="openselectpdf" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500">เลือกรายการเพื่อออกรายงาน</button> -->
        <button id="exportExcelBtn" class="px-6 py-3 bg-red-600 text-white rounded-lg shadow-lg hover:bg-red-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500">ส่งออกเป็น Excel</button>
    </div>
    <script>
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            window.location.href = '../exports/export_items.php'; // เปลี่ยนเป็นเส้นทางของไฟล์ PHP ที่คุณเก็บไว้
        });
    </script>


    <!-- Search and Filter Form -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mb-6 p-4">
        <div class="flex items-center space-x-4">
            <input type="text" id="search-input" placeholder="ค้นหา..." class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <!-- Category Filter -->
            <select id="category-filter" class="w-1/4 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">เลือกหมวดหมู่</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Status Filter -->
            <select id="status-filter" class="w-1/4 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">เลือกสถานะ</option>

                <?php foreach ($status1 as $status): ?>
                    <option value="<?php echo htmlspecialchars($status); ?>"><?php echo htmlspecialchars($status); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

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
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            คำอธิบาย
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            หมวดหมู่
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            จำนวน
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            หน่วย
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            ตำแหน่งที่เก็บ
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            วันที่ซื้อ
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            ผู้จัดหา
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            ราคาซื้อ
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            สถานะ
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody id="item-table" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php foreach ($items as $item): ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['item_name']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['item_description']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['category']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($item['quantity']); ?></td>
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
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const selectReportsButton = document.getElementById('selectReports');
        const exportAllReportsButton = document.getElementById('exportAllReports');

        // Toggle dropdown menu
        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        // Handle "Select Reports" button click
        selectReportsButton.addEventListener('click', () => {
            dropdownMenu.classList.add('hidden');
            // Show the select PDF modal
            document.getElementById('selectPdfModal').classList.remove('hidden');
        });

        // Handle "Export All Reports" button click
        exportAllReportsButton.addEventListener('click', () => {
            dropdownMenu.classList.add('hidden');
            // Add your logic to export all reports here
            console.log('Export All Reports clicked');
        });

        // Hide dropdown if clicked outside
        document.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>


<script>
    function filterItems() {
        const searchQuery = document.getElementById('search-input').value.toLowerCase();
        const categoryFilter = document.getElementById('category-filter').value.toLowerCase();
        const statusFilter = document.getElementById('status-filter').value.toLowerCase();
        const rows = document.querySelectorAll('#item-table tr');

        rows.forEach(row => {
            const itemName = row.cells[0].textContent.toLowerCase(); // คอลัมน์ชื่อรายการ
            const category = row.cells[2] ? row.cells[2].textContent.toLowerCase() : ''; // คอลัมน์หมวดหมู่
            const status = row.cells[9] ? row.cells[9].textContent.toLowerCase() : ''; // คอลัมน์สถานะ

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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchItem');
        const itemList = document.getElementById('itemList');

        // Fetch items from PHP
        const items = <?php echo json_encode($items); ?>;

        // Object to store checkbox states
        const checkboxStates = {};

        // Function to display items
        function displayItems(filteredItems) {
            itemList.innerHTML = ''; // Clear existing items
            filteredItems.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.classList.add('py-2', 'px-4', 'border-b', 'border-gray-200', 'cursor-pointer', 'hover:bg-gray-100');

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = `item-${item.id}`;
                checkbox.checked = checkboxStates[item.id] || false;
                checkbox.addEventListener('change', () => {
                    checkboxStates[item.id] = checkbox.checked;
                });

                const label = document.createElement('label');
                label.htmlFor = checkbox.id;
                label.textContent = item.item_name; // Adjust based on your field names
                label.classList.add('ml-2');

                itemElement.appendChild(checkbox);
                itemElement.appendChild(label);
                itemList.appendChild(itemElement);
            });
        }

        // Initial display of all items
        displayItems(items);

        // Event listener for real-time search
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const filteredItems = items.filter(item => item.item_name.toLowerCase().includes(query));
            displayItems(filteredItems);
        });

        // Modal open and close functionality
        document.getElementById('closeSelectPdfModal').addEventListener('click', () => {
            document.getElementById('selectPdfModal').classList.add('hidden');
        });

        document.getElementById('confirmSelection').addEventListener('click', () => {
            // Handle confirmation (e.g., submit selected item)
            document.getElementById('selectPdfModal').classList.add('hidden');
        });
    });
</script>



<?php include "modal/script.php"; ?>
<?php include "modal/modals.php"; ?>