<?php
// Retrieve item for editing if item_id is present
if (isset($_GET['item_id'])) {
    $item_id = intval($_GET['item_id']);
    $sql = "SELECT * FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
} else {
    // Redirect to main page if no item_id is provided
    echo "<script>alert('Invalid item ID'); window.location.href='system.php?page=equipment_management';</script>";
    exit;
}

?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Item</h1>

    <form action="?page=update_item" method="POST">
        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>">

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="item_name" class="block text-gray-700">Item Name</label>
                <input type="text" id="item_name" name="item_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['item_name']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="item_description" class="block text-gray-700">Description</label>
                <input type="text" id="item_description" name="item_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['item_description']); ?>">
            </div>

            <div class="mb-4">
                <label for="category" class="block text-gray-700">Category</label>
                <input type="text" id="category" name="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['category']); ?>">
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="unit" class="block text-gray-700">Unit</label>
                <input type="text" id="unit" name="unit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['unit']); ?>">
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700">Location</label>
                <input type="text" id="location" name="location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['location']); ?>">
            </div>

            <div class="mb-4">
                <label for="purchase_date" class="block text-gray-700">Purchase Date</label>
                <input type="date" id="purchase_date" name="purchase_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['purchase_date']); ?>">
            </div>

            <div class="mb-4">
                <label for="supplier" class="block text-gray-700">Supplier</label>
                <input type="text" id="supplier" name="supplier" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['supplier']); ?>">
            </div>

            <div class="mb-4">
                <label for="purchase_price" class="block text-gray-700">Purchase Price</label>
                <input type="number" step="0.01" id="purchase_price" name="purchase_price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['purchase_price']); ?>">
            </div>

            <div class="mb-4 col-span-2">
                <label for="status" class="block text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="available" <?php echo $item['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
                    <option value="unavailable" <?php echo $item['status'] === 'unavailable' ? 'selected' : ''; ?>>Unavailable</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="warranty_expiry" class="block text-gray-700">Warranty Expiry</label>
                <input type="date" id="warranty_expiry" name="warranty_expiry" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['warranty_expiry']); ?>">
            </div>

            <div class="mb-4">
                <label for="last_maintenance_date" class="block text-gray-700">Last Maintenance Date</label>
                <input type="date" id="last_maintenance_date" name="last_maintenance_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['last_maintenance_date']); ?>">
            </div>

            <div class="mb-4">
                <label for="maintenance_due_date" class="block text-gray-700">Maintenance Due Date</label>
                <input type="date" id="maintenance_due_date" name="maintenance_due_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['maintenance_due_date']); ?>">
            </div>

            <div class="mb-4">
                <label for="barcode" class="block text-gray-700">Barcode</label>
                <input type="text" id="barcode" name="barcode" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['barcode']); ?>">
            </div>

            <div class="mb-4">
                <label for="condition" class="block text-gray-700">Condition</label>
                <input type="text" id="condition" name="condition" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['condition']); ?>">
            </div>

            <div class="mb-4 col-span-2">
                <label for="remarks" class="block text-gray-700">Remarks</label>
                <textarea id="remarks" name="remarks" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><?php echo htmlspecialchars($item['remarks']); ?></textarea>
            </div>

            <div class="mb-4">
                <label for="department" class="block text-gray-700">Department</label>
                <input type="text" id="department" name="department" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['department']); ?>">
            </div>

            <div class="mb-4">
                <label for="acquisition_type" class="block text-gray-700">Acquisition Type</label>
                <input type="text" id="acquisition_type" name="acquisition_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['acquisition_type']); ?>">
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save Item</button>
            <a href="system.php?page=equipment_management" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</a>
        </div>
    </form>
</div>