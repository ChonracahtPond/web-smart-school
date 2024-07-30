<?php

// Handle form submissions for borrowing and returning items
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['borrow'])) {
        // Handle borrowing
        $item_id = $_POST['item_id'];
        $borrower_name = $_POST['borrower_name'];
        $quantity = $_POST['quantity'];
        $return_due_date = $_POST['return_due_date'];

        // Insert borrowing record
        $sql = "INSERT INTO borrowings (item_id, borrower_name, quantity, return_due_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isis", $item_id, $borrower_name, $quantity, $return_due_date);
        $stmt->execute();

        // Update item quantity
        $sql = "UPDATE items SET quantity = quantity - ? WHERE item_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $item_id);
        $stmt->execute();

        echo "Item borrowed successfully!";
    } elseif (isset($_POST['return'])) {
        // Handle returning
        $borrowing_id = $_POST['borrowing_id'];
        $quantity = $_POST['quantity'];
        $condition = $_POST['condition'];

        // Insert return record
        $sql = "INSERT INTO returns (borrowing_id, quantity, condition) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $borrowing_id, $quantity, $condition);
        $stmt->execute();

        // Update borrowing record
        $sql = "UPDATE borrowings SET returned_at = NOW() WHERE borrowing_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $borrowing_id);
        $stmt->execute();

        // Update item quantity
        $sql = "UPDATE items SET quantity = quantity + ? WHERE item_id = (SELECT item_id FROM borrowings WHERE borrowing_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $borrowing_id);
        $stmt->execute();

        echo "Item returned successfully!";
    }
}

// Fetch items for borrowing
$sql = "SELECT item_id, item_name FROM items WHERE quantity > 0";
$items_result = $conn->query($sql);

// Fetch borrowings for returning
$sql = "SELECT b.borrowing_id, i.item_name, b.quantity
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        WHERE b.returned_at IS NULL";
$borrowings_result = $conn->query($sql);

$conn->close();
?>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">ระบบยืม-คืนครุภัณฑ์ และ ระบบเบิกจ่ายวัสดุสำนักงาน</h1>

    <!-- Borrowing Form -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">ยืมอุปกรณ์</h2>
        <form action="system_for_borrowing_and_returning_equipment.php" method="post">
            <div class="mb-4">
                <label for="item_id" class="block text-gray-700">Select Item:</label>
                <select id="item_id" name="item_id" class="form-select mt-1 block w-full">
                    <?php while ($row = $items_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['item_id']; ?>"><?php echo $row['item_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="borrower_name" class="block text-gray-700">Borrower's Name:</label>
                <input type="text" id="borrower_name" name="borrower_name" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="form-input mt-1 block w-full" min="1" required>
            </div>
            <div class="mb-4">
                <label for="return_due_date" class="block text-gray-700">Return Due Date:</label>
                <input type="date" id="return_due_date" name="return_due_date" class="form-input mt-1 block w-full" required>
            </div>
            <button type="submit" name="borrow" class="bg-blue-500 text-white px-4 py-2 rounded">Borrow</button>
        </form>
    </div>

    <!-- Returning Form -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">อุปกรณ์ส่งคืน</h2>
        <form action="system_for_borrowing_and_returning_equipment.php" method="post">
            <div class="mb-4">
                <label for="borrowing_id" class="block text-gray-700">Select Borrowing Record:</label>
                <select id="borrowing_id" name="borrowing_id" class="form-select mt-1 block w-full">
                    <?php while ($row = $borrowings_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['borrowing_id']; ?>"><?php echo $row['item_name'] . " - " . $row['quantity']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="return_quantity" class="block text-gray-700">Quantity Returned:</label>
                <input type="number" id="quantity" name="quantity" class="form-input mt-1 block w-full" min="1" required>
            </div>
            <div class="mb-4">
                <label for="condition" class="block text-gray-700">Condition:</label>
                <select id="condition" name="condition" class="form-select mt-1 block w-full" required>
                    <option value="good">Good</option>
                    <option value="damaged">Damaged</option>
                </select>
            </div>
            <button type="submit" name="return" class="bg-green-500 text-white px-4 py-2 rounded">Return</button>
        </form>
    </div>
</div>