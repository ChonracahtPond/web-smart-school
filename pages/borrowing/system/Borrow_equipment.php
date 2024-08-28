<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow'])) {
    // Get user inputs
    $borrower_id = intval($_POST['borrower_name']);  // Corrected input name
    $return_due_date = $_POST['return_due_date'];
    $borrowed_items_data = isset($_POST['borrowed_items_data']) ? json_decode($_POST['borrowed_items_data'], true) : [];

    // Check if borrowed items data is empty
    if (empty($borrowed_items_data)) {
        echo "<script>alert('No items selected for borrowing.'); window.location.href='system.php?page=System_for_borrowing';</script>";
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Insert borrowing records
        foreach ($borrowed_items_data as $item) {
            $item_id = intval($item['id']);
            $quantity = intval($item['quantity']);

            // Insert borrowing record
            $sql = "INSERT INTO borrowings (user_id, item_id, quantity, return_due_date) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("iiis", $borrower_id, $item_id, $quantity, $return_due_date);
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
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='system.php?page=System_for_borrowing';</script>";
    }
}
