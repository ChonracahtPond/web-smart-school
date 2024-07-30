<?php
// ดึงข้อมูลการยืมที่ยังไม่คืน
$sql = "SELECT b.borrowing_id, i.item_name, b.quantity
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        WHERE b.returned_at IS NULL";
$borrowings_result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return'])) {
    // ดำเนินการคืนอุปกรณ์
    $borrowing_id = $_POST['borrowing_id'];
    $quantity = $_POST['quantity'];
    $condition = $_POST['condition'];

    // บันทึกข้อมูลการคืน
    $sql = "INSERT INTO returns (borrowing_id, quantity, condition) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $borrowing_id, $quantity, $condition);
    $stmt->execute();

    // ปรับปรุงสถานะการยืม
    $sql = "UPDATE borrowings SET returned_at = NOW() WHERE borrowing_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $borrowing_id);
    $stmt->execute();

    // ปรับปรุงปริมาณของอุปกรณ์
    $sql = "UPDATE items SET quantity = quantity + ? WHERE item_id = (SELECT item_id FROM borrowings WHERE borrowing_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $borrowing_id);
    $stmt->execute();

    echo "Item returned successfully!";
}

$conn->close();
?>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">คืนอุปกรณ์</h1>

    <!-- Returning Form -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="return_item.php" method="post">
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