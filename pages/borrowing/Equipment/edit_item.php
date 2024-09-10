<?php
// ตรวจสอบว่ามี item_id มาหรือไม่
if (isset($_GET['item_id'])) {
    $item_id = intval($_GET['item_id']);

    // SQL สำหรับดึงข้อมูลของ item ที่ต้องการแก้ไข
    $sql = "SELECT * FROM items WHERE item_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error)); // แสดงข้อผิดพลาด
    }

    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<script>alert('Invalid item ID'); window.location.href='system.php?page=equipment_management';</script>";
    exit;
}

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: print POST data
    print_r($_POST);

    $item_id = intval($_POST['item_id']);

    // SQL สำหรับการอัปเดตข้อมูล item
    $sql = "UPDATE items SET 
    item_name = ?, 
    item_description = ?, 
    category = ?, 
    quantity = ?, 
    unit = ?, 
    location = ?, 
    purchase_date = ?, 
    supplier = ?, 
    purchase_price = ?, 
    status = ?, 
    warranty_expiry = ?, 
    last_maintenance_date = ?, 
    maintenance_due_date = ?, 
    barcode = ?, 
    `condition` = ?, 
    remarks = ?, 
    department = ?, 
    acquisition_type = ? 
WHERE item_id = ?";

    // Note the 'i' at the end for the integer item_id
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error)); // แสดงข้อผิดพลาด
    }

    // Correct bind_param for the given SQL and parameter count
    $stmt->bind_param(
        'ssssisisssssssssssi',
        $_POST['item_name'],
        $_POST['item_description'],
        $_POST['category'],
        $_POST['quantity'],
        $_POST['unit'],
        $_POST['location'],
        $_POST['purchase_date'],
        $_POST['supplier'],
        $_POST['purchase_price'],
        $_POST['status'],
        $_POST['warranty_expiry'],
        $_POST['last_maintenance_date'],
        $_POST['maintenance_due_date'],
        $_POST['barcode'],
        $_POST['condition'],
        $_POST['remarks'],
        $_POST['department'],
        $_POST['acquisition_type'],
        $item_id
    );



    // ตรวจสอบผลการอัปเดต
    if ($stmt->execute()) {
        echo "<script>window.location.href='system.php?page=equipment_management&status=1';</script>";
    } else {
        echo "<script> window.location.href='system.php?page=equipment_management&status=0';</script>";
    }

    $stmt->close();
}

?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">แก้ไขรายการ</h1>

    <form action="" method="POST">
        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>">

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="item_name" class="block text-gray-700">ชื่อรายการ</label>
                <input type="text" id="item_name" name="item_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['item_name']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="item_description" class="block text-gray-700">คำอธิบาย</label>
                <input type="text" id="item_description" name="item_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['item_description']); ?>">
            </div>

            <div class="mb-4">
                <label for="category" class="block text-gray-700">หมวดหมู่</label>
                <input type="text" id="category" name="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['category']); ?>">
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">จำนวน</label>
                <input type="number" id="quantity" name="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="unit" class="block text-gray-700">หน่วย</label>
                <input type="text" id="unit" name="unit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['unit']); ?>">
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700">สถานที่จัดเก็บ</label>
                <input type="text" id="location" name="location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['location']); ?>">
            </div>

            <div class="mb-4">
                <label for="purchase_date" class="block text-gray-700">วันที่ซื้อ</label>
                <input type="date" id="purchase_date" name="purchase_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['purchase_date']); ?>">
            </div>

            <div class="mb-4">
                <label for="supplier" class="block text-gray-700">ผู้จัดจำหน่าย</label>
                <input type="text" id="supplier" name="supplier" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['supplier']); ?>">
            </div>

            <div class="mb-4">
                <label for="purchase_price" class="block text-gray-700">ราคาซื้อ</label>
                <input type="number" step="0.01" id="purchase_price" name="purchase_price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['purchase_price']); ?>">
            </div>

            <div class="mb-4 col-span-2">
                <label for="status" class="block text-gray-700">สถานะ</label>
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="พร้อมใช้งาน" <?php echo $item['status'] === 'พร้อมใช้งาน' ? 'selected' : ''; ?>>พร้อมใช้งาน</option>
                    <option value="ซ่อมบำรุง" <?php echo $item['status'] === 'ซ่อมบำรุง' ? 'selected' : ''; ?>>ซ่อมบำรุง</option>
                    <option value="หมดสต็อก" <?php echo $item['status'] === 'หมดสต็อก' ? 'selected' : ''; ?>>หมดสต็อก</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="warranty_expiry" class="block text-gray-700">วันหมดอายุการรับประกัน</label>
                <input type="date" id="warranty_expiry" name="warranty_expiry" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['warranty_expiry']); ?>">
            </div>

            <div class="mb-4">
                <label for="last_maintenance_date" class="block text-gray-700">วันที่บำรุงรักษาครั้งล่าสุด</label>
                <input type="date" id="last_maintenance_date" name="last_maintenance_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['last_maintenance_date']); ?>">
            </div>

            <div class="mb-4">
                <label for="maintenance_due_date" class="block text-gray-700">วันที่ต้องบำรุงรักษา</label>
                <input type="date" id="maintenance_due_date" name="maintenance_due_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['maintenance_due_date']); ?>">
            </div>

            <div class="mb-4">
                <label for="barcode" class="block text-gray-700">บาร์โค้ด</label>
                <input type="text" id="barcode" name="barcode" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['barcode']); ?>">
            </div>

            <div class="mb-4">
                <label for="condition" class="block text-gray-700">สภาพ</label>
                <input type="text" id="condition" name="condition" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['condition']); ?>">
            </div>

            <div class="mb-4 col-span-2">
                <label for="remarks" class="block text-gray-700">หมายเหตุ</label>
                <textarea id="remarks" name="remarks" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><?php echo htmlspecialchars($item['remarks']); ?></textarea>
            </div>

            <div class="mb-4">
                <label for="department" class="block text-gray-700">แผนก</label>
                <input type="text" id="department" name="department" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['department']); ?>">
            </div>

            <div class="mb-4">
                <label for="acquisition_type" class="block text-gray-700">ประเภทการได้มา</label>
                <input type="text" id="acquisition_type" name="acquisition_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="<?php echo htmlspecialchars($item['acquisition_type']); ?>">
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">บันทึกรายการ</button>
            <a href="system.php?page=equipment_management" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md">ยกเลิก</a>
        </div>
    </form>
</div>