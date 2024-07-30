<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow'])) {
    $item_id = $_POST['item_id'];
    $borrower_name = $_POST['borrower_name'];
    $quantity = $_POST['quantity'];
    $return_due_date = $_POST['return_due_date'];

    // Insert borrowing record
    $sql = "INSERT INTO borrowings (item_id, borrower_name, quantity, return_due_date) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isis", $item_id, $borrower_name, $quantity, $return_due_date);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Update item quantity
    $sql = "UPDATE items SET quantity = quantity - ? WHERE item_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $quantity, $item_id);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    echo "<script>alert('Item borrowed successfully'); window.location.href='admin.php?page=System_for_borrowing';</script>";
}
