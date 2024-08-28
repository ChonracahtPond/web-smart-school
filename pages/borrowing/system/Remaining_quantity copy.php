<?php

// Fetch borrowings for returning
$sql = "SELECT b.borrowing_id, i.item_name, b.quantity, r.condition
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        LEFT JOIN returns r ON b.borrowing_id = r.borrowing_id
        WHERE b.returned_at IS NULL";
$borrowings_result = $conn->query($sql);
if (!$borrowings_result) {
    die("Error fetching borrowings: " . $conn->error);
}

// Fetch items for office supplies
$sql = "SELECT item_name, quantity FROM items";
$items_result = $conn->query($sql);
if (!$items_result) {
    die("Error fetching items: " . $conn->error);
}


?>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">คืนครุภัณฑ์ และ ระบบเบิกจ่ายวัสดุสำนักงาน</h1>

    <!-- Returning Items -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">คืนครุภัณฑ์</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">Item Name</th>
                    <th class="py-2 px-4 border-b">Quantity Returned</th>
                    <th class="py-2 px-4 border-b">Condition</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $borrowings_result->fetch_assoc()) {
                    // Determine the quantity class based on the quantity
                    $quantity_class = '';
                    if ($row['quantity'] < 10) {
                        $quantity_class = 'low-quantity';
                    } elseif ($row['quantity'] >= 10 && $row['quantity'] < 20) {
                        $quantity_class = 'medium-quantity';
                    } else {
                        $quantity_class = 'high-quantity';
                    }
                ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td class="py-2 px-4 border-b <?php echo htmlspecialchars($quantity_class); ?>">
                            <?php echo htmlspecialchars($row['quantity']); ?>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <!-- Use the condition value to display different conditions -->
                            <?php echo htmlspecialchars($row['condition']) === 'good' ? 'Good' : 'Damaged'; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Office Supplies -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">ระบบเบิกจ่ายวัสดุสำนักงาน</h2>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">Item Name</th>
                    <th class="py-2 px-4 border-b">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $items_result->fetch_assoc()) {
                    // Determine the quantity class based on the quantity
                    $quantity_class = '';
                    if ($row['quantity'] < 10) {
                        $quantity_class = 'low-quantity';
                    } elseif ($row['quantity'] >= 10 && $row['quantity'] < 20) {
                        $quantity_class = 'medium-quantity';
                    } else {
                        $quantity_class = 'high-quantity';
                    }
                ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td class="py-2 px-4 border-b <?php echo htmlspecialchars($quantity_class); ?>">
                            <?php echo htmlspecialchars($row['quantity']); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>