<?php
// ตรวจสอบว่ามีการส่งฟอร์มหรือไม่
if (isset($_POST['add_item'])) {

    // รับข้อมูลจากฟอร์ม
    $item_name = !empty($_POST['item_name']) ? $conn->real_escape_string($_POST['item_name']) : '-';
    $item_description = !empty($_POST['item_description']) ? $conn->real_escape_string($_POST['item_description']) : '-';
    $category = !empty($_POST['category']) ? $conn->real_escape_string($_POST['category']) : '-';
    $quantity = !empty($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $unit = !empty($_POST['unit']) ? $conn->real_escape_string($_POST['unit']) : '-';
    $location = !empty($_POST['location']) ? $conn->real_escape_string($_POST['location']) : '-';
    $purchase_date = !empty($_POST['purchase_date']) ? $conn->real_escape_string($_POST['purchase_date']) : '-';
    $supplier = !empty($_POST['supplier']) ? $conn->real_escape_string($_POST['supplier']) : '-';
    $purchase_price = !empty($_POST['purchase_price']) ? floatval($_POST['purchase_price']) : 0.00;
    $status = !empty($_POST['status']) ? $conn->real_escape_string($_POST['status']) : '-';
    $warranty_expiry = !empty($_POST['warranty_expiry']) ? $conn->real_escape_string($_POST['warranty_expiry']) : '-';
    $last_maintenance_date = !empty($_POST['last_maintenance_date']) ? $conn->real_escape_string($_POST['last_maintenance_date']) : '-';
    $maintenance_due_date = !empty($_POST['maintenance_due_date']) ? $conn->real_escape_string($_POST['maintenance_due_date']) : '-';
    $barcode = !empty($_POST['barcode']) ? $conn->real_escape_string($_POST['barcode']) : '-';
    $condition = !empty($_POST['condition']) ? $conn->real_escape_string($_POST['condition']) : '-';
    $remarks = !empty($_POST['remarks']) ? $conn->real_escape_string($_POST['remarks']) : '-';
    $department = !empty($_POST['department']) ? $conn->real_escape_string($_POST['department']) : '-';
    $acquisition_type = !empty($_POST['acquisition_type']) ? $conn->real_escape_string($_POST['acquisition_type']) : '-';

    // การอัปโหลดไฟล์
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = $conn->real_escape_string($image['name']);
        $image_tmp_name = $image['tmp_name'];
        $image_path = '../../uploads/' . $image_name;

        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $image_url = $image_path;
        } else {
            $image_url = '-'; // หากไม่สามารถอัปโหลดไฟล์ได้
        }
    } else {
        $image_url = '-';
    }

    // สร้างคำสั่ง SQL สำหรับเพิ่มรายการใหม่
    $sql = "INSERT INTO items (item_name, item_description, quantity, `status`, created_at, updated_at, category, unit, location, purchase_date, supplier, purchase_price, warranty_expiry, last_maintenance_date, maintenance_due_date, barcode, image, `condition`, remarks, department, acquisition_type) 
            VALUES ('$item_name', '$item_description', $quantity, '$status', NOW(), NOW(), '$category', '$unit', '$location', '$purchase_date', '$supplier', $purchase_price, '$warranty_expiry', '$last_maintenance_date', '$maintenance_due_date', '$barcode', '$image_url', '$condition', '$remarks', '$department', '$acquisition_type')";

    if ($conn->query($sql) === TRUE) {
        // ส่งค่า 1 ไปที่ modal แสดงความสำเร็จ
        // header("Location: equipment_management?status=1"); // เปลี่ยน your_page.php เป็นชื่อไฟล์ที่ต้องการแสดงโมดัล
        // echo "Location: ?page=equipment_management?status=1";
        echo "<script>window.location.href='system.php?page=equipment_management&status=1';</script>";
    } else {
        // ส่งค่า 0 ไปที่ modal แสดงข้อผิดพลาด
        echo "Location: ?page=equipment_management?status=0";
        echo "<script>window.location.href='system.php?page=equipment_management&status=0';</script>";
        // header("Location: equipment_management?status=0"); // เปลี่ยน your_page.php เป็นชื่อไฟล์ที่ต้องการแสดงโมดัล
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    exit(); // ใช้ exit() หลังการเรียกใช้ header() เพื่อหยุดการประมวลผลเพิ่มเติม
} else {
    echo "ไม่พบข้อมูลการส่งฟอร์ม.";
}
?>








<!-- 
// if (isset($_POST['add_item'])) {
// $item_name = $_POST['item_name'];
// $item_description = $_POST['item_description'];
// $quantity = $_POST['quantity'];
// $status = $_POST['status'];

// $sql = "INSERT INTO items (item_name, item_description, quantity, status) VALUES (?, ?, ?, ?)";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param('ssis', $item_name, $item_description, $quantity, $status);
// $stmt->execute();
// echo "<script>
    alert('equipment add successfully');
    window.location.href = 'system.php?page=equipment_management';
</script>";
// } -->