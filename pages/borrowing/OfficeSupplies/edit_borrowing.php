<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $permanent_borrowing_id = $_POST['permanent_borrowing_id'];
    $item_id = $_POST['item_id'];
    $user_id = $_POST['user_id'];
    $quantity = $_POST['quantity'];

    // เริ่มการทำธุรกรรม
    $conn->begin_transaction();

    try {
        // ดึงข้อมูลการเบิกวัสดุก่อนการอัปเดต
        $select_sql = "SELECT item_id, quantity FROM permanent_borrowings WHERE permanent_borrowing_id = ?";
        if ($stmt = $conn->prepare($select_sql)) {
            $stmt->bind_param("i", $permanent_borrowing_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $old_borrowing = $result->fetch_assoc();
            $stmt->close();

            // เพิ่มจำนวนวัสดุกลับไปในตาราง items ตามจำนวนที่ถูกเบิกออกเดิม
            $update_items_sql = "UPDATE items SET quantity = quantity + ? WHERE item_id = ?";
            if ($stmt = $conn->prepare($update_items_sql)) {
                $stmt->bind_param("ii", $old_borrowing['quantity'], $old_borrowing['item_id']);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception("Error preparing update statement for items: " . $conn->error);
            }

            // อัปเดตข้อมูลการเบิกวัสดุ
            $update_borrowing_sql = "UPDATE permanent_borrowings SET item_id = ?, user_id = ?, quantity = ? WHERE permanent_borrowing_id = ?";
            if ($stmt = $conn->prepare($update_borrowing_sql)) {
                $stmt->bind_param("isii", $item_id, $user_id, $quantity, $permanent_borrowing_id);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception("Error preparing update statement for borrowing: " . $conn->error);
            }

            // เพิ่มจำนวนวัสดุกลับไปในตาราง items ตามจำนวนที่เบิกออกใหม่
            $update_items_sql = "UPDATE items SET quantity = quantity - ? WHERE item_id = ?";
            if ($stmt = $conn->prepare($update_items_sql)) {
                $stmt->bind_param("ii", $quantity, $item_id);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception("Error preparing update statement for items: " . $conn->error);
            }

            // คอมมิทธุรกรรม
            $conn->commit();
            echo "<script>window.location.href='system.php?page=Borrow_Office_Supplies&status=1';</script>";
        } else {
            throw new Exception("Error preparing select statement: " . $conn->error);
        }
    } catch (Exception $e) {
        // ยกเลิกธุรกรรมหากเกิดข้อผิดพลาด
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='system.php?page=Borrow_Office_Supplies&status=0';</script>";
    }
}

// ดึงข้อมูลการเบิกวัสดุปัจจุบัน
$permanent_borrowing_id = $_GET['permanent_borrowing_id'];
$sql = "SELECT * FROM permanent_borrowings WHERE permanent_borrowing_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $permanent_borrowing_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $borrowing = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// ดึงข้อมูลรายการวัสดุ
$items_sql = "SELECT item_id, item_name FROM items";
$items_result = $conn->query($items_sql);

// ดึงข้อมูลผู้เบิก
$users_sql = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS user_name FROM users";
$users_result = $conn->query($users_sql);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">แก้ไขการเบิกวัสดุ-อุปกรณ์</h1>
    <form method="post" action="">
        <input type="hidden" name="permanent_borrowing_id" value="<?php echo htmlspecialchars($borrowing['permanent_borrowing_id']); ?>">
        <div class="mb-4">
            <label for="item_id" class="block text-sm font-medium text-gray-700">เลือก วัสดุ-อุปกรณ์</label>
            <select id="item_id" name="item_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <?php while ($item = $items_result->fetch_assoc()) { ?>
                    <option value="<?php echo $item['item_id']; ?>" <?php if ($item['item_id'] == $borrowing['item_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($item['item_name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">ชื่อผู้เบิกวัสดุ-อุปกรณ์</label>
            <select id="user_id" name="user_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <?php while ($user = $users_result->fetch_assoc()) { ?>
                    <option value="<?php echo $user['user_id']; ?>" <?php if ($user['user_id'] == $borrowing['user_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($user['user_name']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-gray-700">จำนวน</label>
            <input type="number" id="quantity" name="quantity" required value="<?php echo htmlspecialchars($borrowing['quantity']); ?>" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <button type="submit" name="update" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            บันทึก
        </button>
    </form>
</div>