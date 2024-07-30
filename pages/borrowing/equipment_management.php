<?php
// ดึงข้อมูลครุภัณฑ์ทั้งหมด
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Manage Equipment</h1>

    <!-- Button to open Add Item Modal -->
    <button id="addItemBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition duration-150">Add New Item</button>

    <!-- Table of equipment -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4">Existing Equipment</h2>
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
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
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['item_description']); ?></td>
                        <td class="px-6 py-4 text-sm <?php echo $quantityClass; ?> dark:text-gray-100"><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['status']); ?></td>
                        <td class="px-6 py-4 text-sm font-medium flex space-x-4">
                            <a href="?page=edit_item&item_id=<?php echo htmlspecialchars($row['item_id']); ?>" class="text-blue-600 hover:text-blue-900">Edit</a>
                            <a href="?page=delete_item&delete_item=<?php echo htmlspecialchars($row['item_id']); ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for adding item -->
    <div id="addItemModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h2 class="text-lg font-semibold mb-4">Add New Item</h2>
                <form action="add_item.php" method="POST">
                    <div class="mb-4">
                        <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                        <input type="text" id="item_name" name="item_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-4">
                        <label for="item_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="item_description" name="item_description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" id="quantity" name="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-lg hover:bg-blue-700 transition duration-150">Add Item</button>
                        <button type="button" id="closeAddItemModal" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md shadow-lg hover:bg-gray-400 transition duration-150">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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