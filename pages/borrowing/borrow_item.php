<?php


// ดึงข้อมูลอุปกรณ์ที่สามารถยืมได้
$sql = "SELECT item_id, item_name FROM items WHERE quantity > 0";
$items_result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow'])) {
    // ดำเนินการยืมอุปกรณ์
    $item_id = $_POST['item_id'];
    $borrower_name = $_POST['borrower_name'];
    $quantity = $_POST['quantity'];
    $return_due_date = $_POST['return_due_date'];

    // บันทึกข้อมูลการยืม
    $sql = "INSERT INTO borrowings (item_id, borrower_name, quantity, return_due_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isis", $item_id, $borrower_name, $quantity, $return_due_date);
    $stmt->execute();

    // ปรับปรุงปริมาณของอุปกรณ์
    $sql = "UPDATE items SET quantity = quantity - ? WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $item_id);
    $stmt->execute();

    echo "Item borrowed successfully!";
}

$conn->close();
?>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">ยืมอุปกรณ์</h1>

    <!-- Borrowing Form -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="borrow_item.php" method="post">
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
</div>