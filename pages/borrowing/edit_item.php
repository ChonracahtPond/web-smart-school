<?php

// ตรวจสอบว่าได้รับ item_id หรือไม่
if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];

    // ดึงข้อมูลของไอเท็มที่ต้องการแก้ไข
    $sql = "SELECT * FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
} else {
    // ถ้าไม่มี item_id ส่งกลับไปยังหน้าหลักหรือแสดงข้อผิดพลาด
    // header('Location: manage_items.php');
    // exit;
    echo "<script>alert('equipment update successfully'); window.location.href='system.php?page=equipment_management';</script>";
}

// ตรวจสอบว่ามีข้อมูล POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    // อัปเดตข้อมูลของไอเท็ม
    $sql = "UPDATE items SET item_name = ?, item_description = ?, quantity = ?, status = ? WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisi', $item_name, $item_description, $quantity, $status, $item_id);
    $stmt->execute();

    // ส่งกลับไปยังหน้าหลัก
    echo "<script>alert('equipment update successfully'); window.location.href='system.php?page=equipment_management';</script>";
}



?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Item</h1>

    <form action="" method="post">
        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>">

        <div class="mb-4">
            <label for="item_name" class="block text-gray-700">Item Name</label>
            <input type="text" id="item_name" name="item_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['item_name']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="item_description" class="block text-gray-700">Description</label>
            <input type="text" id="item_description" name="item_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['item_description']); ?>">
        </div>

        <div class="mb-4">
            <label for="quantity" class="block text-gray-700">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700">Status</label>
            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="Available" <?php echo $item['status'] === 'มีอยู่' ? 'selected' : ''; ?>>มีอยู่</option>
                <option value="Unavailable" <?php echo $item['status'] === 'ไม่พร้อมใช้งาน' ? 'selected' : ''; ?>>ไม่พร้อมใช้งาน</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update Item</button>
            <a href="manage_items.php" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</a>
        </div>
    </form>
</div>