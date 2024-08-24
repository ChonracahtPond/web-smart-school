<?php

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];
    $borrower_name = $_POST['borrower_name'];
    $quantity = $_POST['quantity'];

    // ตรวจสอบจำนวนวัสดุที่มีอยู่
    $check_quantity_sql = "SELECT quantity FROM items WHERE item_id = ?";
    if ($stmt = $conn->prepare($check_quantity_sql)) {
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

        // ตรวจสอบจำนวนวัสดุที่มีอยู่ก่อนการเบิก
        if ($item['quantity'] >= $quantity) {
            // เริ่มการทำธุรกรรม
            $conn->begin_transaction();

            try {
                // Insert borrowing record
                $insert_sql = "INSERT INTO permanent_borrowings (item_id, borrower_name, quantity) VALUES (?, ?, ?)";
                if ($stmt = $conn->prepare($insert_sql)) {
                    $stmt->bind_param("isi", $item_id, $borrower_name, $quantity);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    throw new Exception("Error preparing insert statement: " . $conn->error);
                }

                // ลดจำนวนวัสดุในตาราง items
                $update_sql = "UPDATE items SET quantity = quantity - ? WHERE item_id = ?";
                if ($stmt = $conn->prepare($update_sql)) {
                    $stmt->bind_param("ii", $quantity, $item_id);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    throw new Exception("Error preparing update statement: " . $conn->error);
                }

                // คอมมิทธุรกรรม
                $conn->commit();

                echo "<script>alert('Item borrowed successfully'); window.location.href='system.php?page=Borrow_Office_Supplies';</script>";
            } catch (Exception $e) {
                // ยกเลิกธุรกรรมหากเกิดข้อผิดพลาด
                $conn->rollback();
                echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='system.php?page=Borrow_Office_Supplies';</script>";
            }
        } else {
            echo "<script>alert('Insufficient stock for this item.'); window.location.href='system.php?page=Borrow_Office_Supplies';</script>";
        }
    } else {
        echo "Error preparing check quantity statement: " . $conn->error;
    }
}
