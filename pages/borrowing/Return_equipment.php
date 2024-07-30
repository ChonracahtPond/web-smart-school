<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return'])) {
    $borrowing_id = $_POST['borrowing_id'];
    $quantity = $_POST['quantity'];
    $condition = $_POST['condition'];

    // Insert return record
    $sql = "INSERT INTO returns (borrowing_id, return_quantity, condition, return_date) VALUES (?, ?, ?, NOW())";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iis", $borrowing_id, $quantity, $condition);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Update borrowing record
    $sql = "UPDATE borrowings SET returned_at = NOW() WHERE borrowing_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $borrowing_id);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Update item quantity
    $sql = "UPDATE items SET quantity = quantity + ? WHERE item_id = (SELECT item_id FROM borrowings WHERE borrowing_id = ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $quantity, $borrowing_id);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    echo "<script>alert('Item returned successfully'); window.location.href='admin.php?page=System_for_borrowing';</script>";
}
?>
