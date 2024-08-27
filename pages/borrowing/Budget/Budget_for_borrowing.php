<?php
// Default sorting order
$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'purchase_date';
$orderDirection = isset($_GET['order_dir']) && $_GET['order_dir'] === 'desc' ? 'desc' : 'asc';

// Default search term
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// SQL query to get total purchase price by year
$sql = "
    SELECT 
        YEAR(purchase_date) AS purchase_year,
        SUM(purchase_price) AS total_price
    FROM 
        items
    WHERE 
        item_name LIKE '%$search%' 
        OR item_description LIKE '%$search%' 
        OR status LIKE '%$search%'
    GROUP BY 
        YEAR(purchase_date)
    ORDER BY 
        purchase_year $orderDirection
";
$result = $conn->query($sql);

$annualBudgets = [];
while ($row = $result->fetch_assoc()) {
    $annualBudgets[] = $row;
}
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">งบประมาณสำหรับการยืม</h1>
    <!-- Table of annual budgets -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4 border-b border-gray-200 dark:border-gray-700">งบประมาณตามปี</h2>
        <div class="overflow-x-auto">
            <table class="border-collapse w-full">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            ปี
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            จำนวนงบประมาณ
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php foreach ($annualBudgets as $budget): ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($budget['purchase_year']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo number_format($budget['total_price'], 2); ?> บาท</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modals -->
    <!-- Add Item Modal -->
    <div id="addItemModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 id="addItemModalLabel" class="text-2xl font-bold text-gray-900 dark:text-white mb-4">เพิ่มรายการใหม่</h2>
            <!-- Add Item Form -->
            <form method="POST" action="add_item.php">
                <div class="mb-4">
                    <label for="item_name" class="block text-sm font-medium text-gray-900 dark:text-gray-100">ชื่อรายการ</label>
                    <input type="text" id="item_name" name="item_name" required class="mt-1 block w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <!-- Other form fields -->
                <div class="flex justify-end mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">บันทึก</button>
                    <button type="button" id="closeAddItemModal" class="ml-4 px-4 py-2 bg-gray-600 text-white rounded-lg shadow-lg hover:bg-gray-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500">ปิด</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Filter Modal -->
    <div id="filterModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 id="filterModalLabel" class="text-2xl font-bold text-gray-900 dark:text-white mb-4">กรองรายการ</h2>
            <!-- Filter Form -->
            <form method="GET" action="?page=Budget_for_borrowing">
                <!-- Filter fields -->
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-900 dark:text-gray-100">หมวดหมู่</label>
                    <input type="text" id="category" name="category" class="mt-1 block w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <!-- Other filter fields -->
                <div class="flex justify-end mt-4">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500">กรอง</button>
                    <button type="button" id="closeFilterModal" class="ml-4 px-4 py-2 bg-gray-600 text-white rounded-lg shadow-lg hover:bg-gray-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500">ปิด</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript to handle modals -->
    <script>
        document.getElementById('addItemBtn').addEventListener('click', () => {
            document.getElementById('addItemModal').classList.remove('hidden');
        });
        document.getElementById('filterBtn').addEventListener('click', () => {
            document.getElementById('filterModal').classList.remove('hidden');
        });
        document.getElementById('generateReportBtn').addEventListener('click', () => {
            // Handle report generation
        });

        document.getElementById('closeAddItemModal').addEventListener('click', () => {
            document.getElementById('addItemModal').classList.add('hidden');
        });
        document.getElementById('closeFilterModal').addEventListener('click', () => {
            document.getElementById('filterModal').classList.add('hidden');
        });
    </script>
</div>