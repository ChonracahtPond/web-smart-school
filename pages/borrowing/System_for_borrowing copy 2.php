<?php


// ดึงข้อมูลอุปกรณ์ที่สามารถยืมได้
$sql = "SELECT item_id, item_name FROM items WHERE quantity > 0";
$items_result = $conn->query($sql);

// ดึงข้อมูลการยืมที่ยังไม่คืน
$sql = "SELECT b.borrowing_id, i.item_name, b.quantity
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        WHERE b.returned_at IS NULL";
$borrowings_result = $conn->query($sql);

$conn->close();
?>


<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">ระบบยืม-คืนครุภัณฑ์ และ ระบบเบิกจ่ายวัสดุสำนักงาน</h1>

    <!-- Button to open Borrowing Modal -->
    <button id="openBorrowingModal" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">ยืมอุปกรณ์</button>

    <!-- Button to open Returning Modal -->
    <button id="openReturningModal" class="bg-green-500 text-white px-4 py-2 rounded">คืนอุปกรณ์</button>

    <!-- Borrowing Modal -->
    <div id="borrowingModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h2 class="text-xl font-semibold mb-4">ยืมอุปกรณ์</h2>
            <form id="?page=Borrow_equipment" method="POST">
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
                <button type="button" id="closeBorrowingModal" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
            </form>
        </div>
    </div>

    <!-- Returning Modal -->
    <div id="returningModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h2 class="text-xl font-semibold mb-4">คืนอุปกรณ์</h2>
            <form id="?page=Return_equipment" method="POST">
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
                    <input type="number" id="return_quantity" name="quantity" class="form-input mt-1 block w-full" min="1" required>
                </div>
                <div class="mb-4">
                    <label for="condition" class="block text-gray-700">Condition:</label>
                    <select id="condition" name="condition" class="form-select mt-1 block w-full" required>
                        <option value="good">Good</option>
                        <option value="damaged">Damaged</option>
                    </select>
                </div>
                <button type="submit" name="return" class="bg-green-500 text-white px-4 py-2 rounded">Return</button>
                <button type="button" id="closeReturningModal" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
            </form>
        </div>
    </div>
</div>

<?php include "Remaining_quantity.php" ?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Open Borrowing Modal
        document.getElementById('openBorrowingModal').addEventListener('click', function() {
            document.getElementById('borrowingModal').classList.remove('hidden');
        });

        // Close Borrowing Modal
        document.getElementById('closeBorrowingModal').addEventListener('click', function() {
            document.getElementById('borrowingModal').classList.add('hidden');
        });

        // Open Returning Modal
        document.getElementById('openReturningModal').addEventListener('click', function() {
            document.getElementById('returningModal').classList.remove('hidden');
        });

        // Close Returning Modal
        document.getElementById('closeReturningModal').addEventListener('click', function() {
            document.getElementById('returningModal').classList.add('hidden');
        });
    });
</script>