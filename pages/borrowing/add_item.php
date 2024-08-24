<?php
if (isset($_POST['add_item'])) {
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    $sql = "INSERT INTO items (item_name, item_description, quantity, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssis', $item_name, $item_description, $quantity, $status);
    $stmt->execute();

    // header('Location: equipment_list.php');
    echo "<script>alert('equipment add successfully'); window.location.href='system.php?page=equipment_management';</script>";
}
