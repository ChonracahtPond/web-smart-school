<?php

// Get user_id from the query parameter
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

// Fetch borrowings details for the specified user
$sql_borrowings = "SELECT b.borrowing_id, i.item_name, b.quantity, b.borrowed_at
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        WHERE b.user_id = ? AND b.returned_at IS NULL";
$stmt = $conn->prepare($sql_borrowings);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$borrowings_result = $stmt->get_result();

// Fetch user's details
$sql_user = "SELECT first_name, last_name FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();

// Handle return request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_borrowing_id']) && isset($_POST['return_quantity'])) {
    $borrowing_id = intval($_POST['return_borrowing_id']);
    $return_quantity = intval($_POST['return_quantity']);
    $return_date = date('Y-m-d H:i:s');

    // Update the borrowings table to set the returned_at date and quantity
    $sql_return = "UPDATE borrowings SET returned_at = ?, return_quantity = ? WHERE borrowing_id = ?";
    $stmt_return = $conn->prepare($sql_return);
    $stmt_return->bind_param("sii", $return_date, $return_quantity, $borrowing_id);
    $stmt_return->execute();

    // Redirect to the same page to refresh the details
    header("Location: BorrowingDetails.php?user_id=$user_id");
    exit();
}
?>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">
        รายละเอียดการยืมของ <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'], ENT_QUOTES, 'UTF-8'); ?>
    </h2>

    <!-- Borrowing Details Table -->
    <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-md">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b">ชื่ออุปกรณ์</th>
                <th class="py-2 px-4 border-b">จำนวนที่ยืม</th>
                <th class="py-2 px-4 border-b">วันที่ยืม</th>
                <th class="py-2 px-4 border-b">การดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($borrowings_result->num_rows > 0) { ?>
                <?php while ($row = $borrowings_result->fetch_assoc()) { ?>
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row['item_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($row['quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars(date('d/m/Y', strtotime($row['borrowed_at'])), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b text-center">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                onclick="showModal(<?php echo htmlspecialchars($row['borrowing_id'], ENT_QUOTES, 'UTF-8'); ?>)">
                                คืนอุปกรณ์
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4" class="py-2 px-4 border-b text-center">ไม่มีข้อมูลการยืม</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Back button -->
    <div class="mt-6 text-center">
        <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            กลับ
        </a>
    </div>
</div>

<!-- Modal -->
<div id="returnModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <span id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800 cursor-pointer text-xl">&times;</span>
        <h2 class="text-lg font-bold mb-4">คืนอุปกรณ์</h2>
        <form id="returnForm" method="post">
            <input type="hidden" name="return_borrowing_id" id="returnBorrowingId">
            <div class="mb-4">
                <label for="return_quantity" class="block text-gray-700">จำนวนที่คืน</label>
                <input type="number" id="return_quantity" name="return_quantity"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="text-center">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    บันทึก
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showModal(borrowingId) {
        document.getElementById('returnBorrowingId').value = borrowingId;
        document.getElementById('returnModal').classList.remove('hidden');
    }

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('returnModal').classList.add('hidden');
    });

    // Close modal if clicked outside
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('returnModal')) {
            document.getElementById('returnModal').classList.add('hidden');
        }
    });
</script>