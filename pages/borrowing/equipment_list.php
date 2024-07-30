<?php
// ดึงข้อมูลครุภัณฑ์ทั้งหมด
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Manage Equipment</h1>

    <!-- Button to open Add Item Modal -->
    <button id="addItemBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md mb-4">Add New Item</button>

    <!-- Table of equipment -->
    <h2 class="text-xl font-semibold mb-2">Existing Equipment</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlspecialchars($row['item_name']); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlspecialchars($row['item_description']); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlspecialchars($row['status']); ?></td>
                    <td class="px-6 py-4 text-sm font-medium">
                        <button class="text-blue-600 hover:text-blue-900 editBtn" data-id="<?php echo $row['item_id']; ?>">Edit</button>
                        <a href="delete_item.php?delete_item=<?php echo $row['item_id']; ?>" class="text-red-600 hover:text-red-900 ml-4">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Include modals -->
    <?php include 'modals.php'; ?>
</div>