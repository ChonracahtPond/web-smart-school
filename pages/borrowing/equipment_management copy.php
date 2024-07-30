<?php

// การเพิ่มข้อมูลครุภัณฑ์
if (isset($_POST['add_item'])) {
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    $sql = "INSERT INTO items (item_name, item_description, quantity, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssis', $item_name, $item_description, $quantity, $status);
    $stmt->execute();
}

// การลบข้อมูลครุภัณฑ์
if (isset($_GET['delete_item'])) {
    $item_id = $_GET['delete_item'];

    $sql = "DELETE FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
}

// การอัพเดตข้อมูลครุภัณฑ์
if (isset($_POST['update_item'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    $sql = "UPDATE items SET item_name = ?, item_description = ?, quantity = ?, status = ? WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisi', $item_name, $item_description, $quantity, $status, $item_id);
    $stmt->execute();
}

// ดึงข้อมูลครุภัณฑ์ทั้งหมด
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Manage Equipment</h1>

    <!-- Form for adding new equipment -->
    <form action="" method="POST" class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Add New Equipment</h2>
        <div class="mb-4">
            <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
            <input type="text" name="item_name" id="item_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-4">
            <label for="item_description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="item_description" id="item_description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"></textarea>
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
        </div>
        <button type="submit" name="add_item" class="px-4 py-2 bg-blue-500 text-white rounded-md">Add Item</button>
    </form>

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
                        <a href="admin.php?page=equipment_management.php?edit_item=<?php echo $row['item_id']; ?>" class="text-blue-600 hover:text-blue-900">Edit</a>
                        <a href="admin.php?page=equipment_management.php?delete_item=<?php echo $row['item_id']; ?>" class="text-red-600 hover:text-red-900 ml-4">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php if (isset($_GET['edit_item'])) : ?>
        <?php
        $item_id = $_GET['edit_item'];
        $sql = "SELECT * FROM items WHERE item_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $item_id);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();
        ?>
        <!-- Form for editing existing equipment -->
        <form action="equipment_management.php" method="POST" class="mt-6">
            <h2 class="text-xl font-semibold mb-2">Edit Equipment</h2>
            <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
            <div class="mb-4">
                <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
                <input type="text" name="item_name" id="item_name" value="<?php echo htmlspecialchars($item['item_name']); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="item_description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="item_description" id="item_description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"><?php echo htmlspecialchars($item['item_description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="available" <?php if ($item['status'] === 'available') echo 'selected'; ?>>Available</option>
                    <option value="unavailable" <?php if ($item['status'] === 'unavailable') echo 'selected'; ?>>Unavailable</option>
                </select>
            </div>
            <button type="submit" name="update_item" class="px-4 py-2 bg-green-500 text-white rounded-md">Update Item</button>
        </form>
    <?php endif; ?>
</div>