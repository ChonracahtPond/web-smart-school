<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $item_id = intval($_POST['item_id']);
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];
    $category = $_POST['category'];
    $quantity = intval($_POST['quantity']);
    $unit = $_POST['unit'];
    $location = $_POST['location'];
    $purchase_date = $_POST['purchase_date'];
    $supplier = $_POST['supplier'];
    $purchase_price = floatval($_POST['purchase_price']);
    $status = $_POST['status'];
    $warranty_expiry = $_POST['warranty_expiry'];
    $last_maintenance_date = $_POST['last_maintenance_date'];
    $maintenance_due_date = $_POST['maintenance_due_date'];
    $barcode = $_POST['barcode'];
    $condition = $_POST['condition'];
    $remarks = $_POST['remarks'];
    $department = $_POST['department'];
    $acquisition_type = $_POST['acquisition_type'];

    // Prepare an update statement
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
        condition = ?, 
        remarks = ?, 
        department = ?, 
        acquisition_type = ? 
        WHERE item_id = ?";

    // Check if the connection is successful
    if ($conn) {
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(
                'sssissssssssssssi',
                $item_name,
                $item_description,
                $category,
                $quantity,
                $unit,
                $location,
                $purchase_date,
                $supplier,
                $purchase_price,
                $status,
                $warranty_expiry,
                $last_maintenance_date,
                $maintenance_due_date,
                $barcode,
                $condition,
                $remarks,
                $department,
                $acquisition_type,
                $item_id
            );

            if ($stmt->execute()) {
                echo "<script>alert('Item updated successfully'); window.location.href='system.php?page=equipment_management';</script>";
            } else {
                echo "<script>alert('Failed to update item: " . $stmt->error . "'); window.location.href='system.php?page=equipment_management';</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Failed to prepare SQL statement: " . $conn->error . "'); window.location.href='system.php?page=equipment_management';</script>";
        }
    } else {
        echo "<script>alert('Database connection failed'); window.location.href='system.php?page=equipment_management';</script>";
    }

    $conn->close();
} else {
    // Redirect to main page if form is not submitted
    echo "<script>alert('Invalid request'); window.location.href='system.php?page=equipment_management';</script>";
    exit;
}
