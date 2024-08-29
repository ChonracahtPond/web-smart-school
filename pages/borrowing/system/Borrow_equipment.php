<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow'])) {
    $user_id = $_POST['user_id'];
    $return_due_date = $_POST['return_due_date'];
    $borrowed_items_data = isset($_POST['borrowed_items_data']) ? json_decode($_POST['borrowed_items_data'], true) : [];

    if (empty($borrowed_items_data)) {
        echo "<script>alert('No items selected for borrowing.'); window.location.href='system.php?page=System_for_borrowing';</script>";
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Insert borrowing records
        foreach ($borrowed_items_data as $item) {
            $item_id = $item['id'];
            $quantity = $item['quantity'];

            // Insert borrowing record
            $sql = "INSERT INTO borrowings (item_id, user_id, quantity, return_due_date) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("isis", $item_id, $user_id, $quantity, $return_due_date);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception("Error preparing statement for borrowings: " . $conn->error);
            }

            // Update item quantity
            $sql = "UPDATE items SET quantity = quantity - ? WHERE item_id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ii", $quantity, $item_id);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception("Error preparing statement for items: " . $conn->error);
            }
        }

        // Commit transaction
        $conn->commit();
        echo "<script>alert('Items borrowed successfully'); window.location.href='system.php?page=System_for_borrowing';</script>";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='system.php?page=System_for_borrowing';</script>";
    }
}
