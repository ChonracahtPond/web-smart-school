<?php


// Retrieve form data
$item_id = $_POST['item_id'];
$borrower_name = $_POST['borrower_name'];
$quantity = $_POST['quantity'];

// Insert borrowing record
$sql = "INSERT INTO permanent_borrowings (item_id, borrower_name, quantity) VALUES (?, ?, ?)";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("isi", $item_id, $borrower_name, $quantity);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Item borrowed successfully'); window.location.href='system.php?page=Borrow_Office_Supplies';</script>";
} else {
    echo "Error preparing statement: " . $conn->error;
}
