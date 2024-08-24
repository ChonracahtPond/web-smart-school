<?php

if (isset($_GET['permanent_borrowing_id'])) {
    $permanent_borrowing_id = $_GET['permanent_borrowing_id'];

    // เริ่มการทำธุรกรรม
    $conn->begin_transaction();

    try {
        // ดึงข้อมูลการเบิกวัสดุ
        $select_sql = "SELECT item_id, quantity FROM permanent_borrowings WHERE permanent_borrowing_id = ?";
        if ($stmt = $conn->prepare($select_sql)) {
            $stmt->bind_param("i", $permanent_borrowing_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $borrowing = $result->fetch_assoc();

            // เพิ่มจำนวนวัสดุกลับไปในตาราง items
            $item_id = $borrowing['item_id'];
            $quantity = $borrowing['quantity'];
            $update_sql = "UPDATE items SET quantity = quantity + ? WHERE item_id = ?";
            if ($stmt = $conn->prepare($update_sql)) {
                $stmt->bind_param("ii", $quantity, $item_id);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception("Error preparing update statement: " . $conn->error);
            }

            // ลบข้อมูลการเบิกวัสดุ
            $delete_sql = "DELETE FROM permanent_borrowings WHERE permanent_borrowing_id = ?";
            if ($stmt = $conn->prepare($delete_sql)) {
                $stmt->bind_param("i", $permanent_borrowing_id);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception("Error preparing delete statement: " . $conn->error);
            }

            // คอมมิทธุรกรรม
            $conn->commit();
            echo "<script>alert('Item deleted and quantity updated successfully'); window.location.href='system.php?page=Borrow_Office_Supplies';</script>";
        } else {
            throw new Exception("Error preparing select statement: " . $conn->error);
        }
    } catch (Exception $e) {
        // ยกเลิกธุรกรรมหากเกิดข้อผิดพลาด
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='system.php?page=Borrow_Office_Supplies';</script>";
    }
}
