<?php

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow'])) {
//     $item_id = $_POST['item_id'];
//     $borrower_name = $_POST['borrower_name'];
//     $quantity = $_POST['quantity'];
//     $return_due_date = $_POST['return_due_date'];

//     // Insert borrowing record
//     $sql = "INSERT INTO borrowings (item_id, borrower_name, quantity, return_due_date) VALUES (?, ?, ?, ?)";
//     if ($stmt = $conn->prepare($sql)) {
//         $stmt->bind_param("isis", $item_id, $borrower_name, $quantity, $return_due_date);
//         $stmt->execute();
//         $stmt->close();
//     } else {
//         echo "Error preparing statement: " . $conn->error;
//     }

//     // Update item quantity
//     $sql = "UPDATE items SET quantity = quantity - ? WHERE item_id = ?";
//     if ($stmt = $conn->prepare($sql)) {
//         $stmt->bind_param("ii", $quantity, $item_id);
//         $stmt->execute();
//         $stmt->close();
//     } else {
//         echo "Error preparing statement: " . $conn->error;
//     }

//     echo "<script>alert('Item borrowed successfully'); window.location.href='system.php?page=System_for_borrowing';</script>";
// }

// Include the database connection file



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow'])) {
    $borrower_name = $_POST['borrower_name'];
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
            $sql = "INSERT INTO borrowings (item_id, borrower_name, quantity, return_due_date) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("isis", $item_id, $borrower_name, $quantity, $return_due_date);
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
