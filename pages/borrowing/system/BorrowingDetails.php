<?php
// Get user_id from the query parameter
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

$sql_borrowings = "SELECT b.borrowing_id, i.item_name, b.quantity, COALESCE(b.return_quantity, 0) as return_quantity, b.borrowed_at, b.returned_at, i.item_id
        FROM borrowings b
        JOIN items i ON b.item_id = i.item_id
        WHERE b.user_id = ?";

$stmt = $conn->prepare($sql_borrowings);

if ($stmt === false) {
    die("ERROR: ไม่สามารถเตรียมคำสั่ง SQL: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$borrowings_result = $stmt->get_result();

// Fetch user's details
$sql_user = "SELECT first_name, last_name FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);

if ($stmt_user === false) {
    die("ERROR: ไม่สามารถเตรียมคำสั่ง SQL: " . $conn->error);
}

$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();

// Handle return request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_borrowing_id']) && isset($_POST['quantity'])) {
    $borrowing_id = intval($_POST['return_borrowing_id']);
    $return_quantity = intval($_POST['quantity']);
    $return_date = date('Y-m-d H:i:s');

    // Fetch current borrowing details
    $sql_check = "SELECT item_id, quantity, return_quantity FROM borrowings WHERE borrowing_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    if ($stmt_check === false) {
        die("ERROR: ไม่สามารถเตรียมคำสั่ง SQL: " . $conn->error);
    }
    $stmt_check->bind_param("i", $borrowing_id);
    $stmt_check->execute();
    $check_result = $stmt_check->get_result();
    $row = $check_result->fetch_assoc();

    $current_quantity = $row['quantity'];
    $current_return_quantity = $row['return_quantity'];
    $item_id = $row['item_id'];
    $new_return_quantity = $current_return_quantity + $return_quantity;

    if ($new_return_quantity > $current_quantity) {
        // Prevent over-returning
        die("ERROR: จำนวนที่คืนเกินจำนวนที่ยืม");
    }

    if ($new_return_quantity >= $current_quantity) {
        // Mark as returned if all items are returned
        $sql_return = "UPDATE borrowings SET returned_at = ?, return_quantity = ?, status = 1 WHERE borrowing_id = ?";
    } else {
        // Update return quantity only
        $sql_return = "UPDATE borrowings SET return_quantity = ? WHERE borrowing_id = ?";
    }
    $stmt_return = $conn->prepare($sql_return);
    if ($stmt_return === false) {
        die("ERROR: ไม่สามารถเตรียมคำสั่ง SQL: " . $conn->error);
    }

    if ($new_return_quantity >= $current_quantity) {
        $stmt_return->bind_param("ssi", $return_date, $new_return_quantity, $borrowing_id);
    } else {
        $stmt_return->bind_param("ii", $new_return_quantity, $borrowing_id);
    }
    $stmt_return->execute();

    // Update the quantity in the items table
    $sql_update_item = "UPDATE items SET quantity = quantity + ? WHERE item_id = ?";
    $stmt_update_item = $conn->prepare($sql_update_item);
    if ($stmt_update_item === false) {
        die("ERROR: ไม่สามารถเตรียมคำสั่ง SQL: " . $conn->error);
    }
    $stmt_update_item->bind_param("ii", $return_quantity, $item_id);
    $stmt_update_item->execute();

    // Redirect to the same page to refresh the details
    echo "<script>window.location.href='system.php?page=BorrowingDetails&user_id=$user_id&status=1';</script>";
    exit();
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="text-2xl font-bold mb-6 text-center text-gray-800">
        รายละเอียดการยืมของ <span class="text-green-400"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'], ENT_QUOTES, 'UTF-8'); ?></span>
    </div>

    <!-- Borrowing Details Table -->
    <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-md">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b">ชื่ออุปกรณ์</th>
                <th class="py-2 px-4 border-b">จำนวนที่ยืม</th>
                <th class="py-2 px-4 border-b">จำนวนที่คืน</th>
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
                        <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars($row['return_quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo htmlspecialchars(date('d/m/Y', strtotime($row['borrowed_at'])), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="py-2 px-4 border-b text-center">
                            <?php if ($row['quantity'] > $row['return_quantity']) { ?>
                                <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    onclick="openModal(<?php echo htmlspecialchars($row['borrowing_id'], ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($row['quantity'] - $row['return_quantity'], ENT_QUOTES, 'UTF-8'); ?>)">
                                    คืนอุปกรณ์
                                </button>
                            <?php } else { ?>
                                <span class="text-green-600">คืนครบแล้ว</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5" class="py-2 px-4 border-b text-center">ไม่มีข้อมูลการยืม</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Back button -->
    <div class="mt-6 text-center">
        <a href="?page=System_for_borrowing" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            กลับ
        </a>
    </div>
</div>

<!-- Modal -->
<div id="returnModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <span id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800 cursor-pointer text-xl">&times;</span>
        <h2 class="text-lg font-bold mb-4">คืนอุปกรณ์</h2>
        <form id="returnForm" method="post" onsubmit="return validateReturnQuantity();">
            <input type="hidden" name="return_borrowing_id" id="returnBorrowingId">
            <!-- Hidden field to store the maximum quantity that can be returned -->
            <input type="hidden" id="maxQuantity" name="max_quantity">
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">จำนวนที่คืน</label>
                <input type="number" id="quantity" name="quantity"
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
    function openModal(borrowingId, maxQuantity) {
        document.getElementById('returnBorrowingId').value = borrowingId;
        document.getElementById('maxQuantity').value = maxQuantity;
        document.getElementById('returnModal').classList.remove('hidden');
    }

    function validateReturnQuantity() {
        var maxQuantity = parseInt(document.getElementById('maxQuantity').value, 10);
        var returnQuantity = parseInt(document.getElementById('quantity').value, 10);

        if (returnQuantity > maxQuantity) {
            alert('จำนวนที่คืนต้องน้อยกว่าหรือเท่ากับจำนวนที่ยืม');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
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

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
ob_end_flush(); // ส่งข้อมูลออกและหยุด buffering
$conn->close();
?>