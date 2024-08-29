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







// // ตรวจสอบและแสดงข้อมูลที่ถูกส่งมา
// if (isset($_POST['borrowed_items_data'])) {
//     $borrowed_items_data = json_decode($_POST['borrowed_items_data'], true);

//     foreach ($borrowed_items_data as $item) {
//         $item_id = $item['id'];
//         $quantity = $item['quantity'];

//         // ตรวจสอบว่าค่า quantity ถูกต้องและไม่ว่าง
//         if ($quantity > 0) {
//             // ดำเนินการบันทึกข้อมูลลงในฐานข้อมูล
//             $update_item_sql = "INSERT INTO borrowings (item_id, user_id, quantity, return_due_date) VALUES (?, ?, ?, ?)";
//             $stmt = $conn->prepare($update_item_sql);
//             $stmt->bind_param("iiis", $item_id, $_POST['user_id'], $quantity, $_POST['return_due_date']);

//             if ($stmt->execute()) {
//                 echo "บันทึกข้อมูลเรียบร้อย: $quantity สำหรับวัสดุ ID: $item_id <br>";
//             } else {
//                 echo "ไม่สามารถบันทึกข้อมูลได้: " . $stmt->error . "<br>";
//             }
//         } else {
//             echo "ค่า quantity ไม่ถูกต้องสำหรับวัสดุ ID: $item_id<br>";
//         }
//     }
// }


// ตรวจสอบและแสดงข้อมูลที่ถูกส่งมา
if (isset($_POST['borrowed_items_data'])) {
    $borrowed_items_data = json_decode($_POST['borrowed_items_data'], true);

    foreach ($borrowed_items_data as $item) {
        $item_id = $item['id'];
        $quantity = $item['quantity'];

        // ตรวจสอบว่าค่า quantity ถูกต้องและไม่ว่าง
        if ($quantity > 0) {
            // ตรวจสอบจำนวนที่เบิกว่ามีเพียงพอหรือไม่
            $check_quantity_sql = "SELECT quantity FROM items WHERE item_id = ?";
            $stmt = $conn->prepare($check_quantity_sql);
            $stmt->bind_param("i", $item_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['quantity'] >= $quantity) {
                // ดำเนินการบันทึกข้อมูลลงในฐานข้อมูล
                $update_item_sql = "INSERT INTO borrowings (item_id, user_id, quantity, return_due_date) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($update_item_sql);
                $stmt->bind_param("iiis", $item_id, $_POST['user_id'], $quantity, $_POST['return_due_date']);

                if ($stmt->execute()) {
                    echo "บันทึกข้อมูลเรียบร้อย: $quantity สำหรับวัสดุ ID: $item_id <br>";

                    // ลดจำนวนวัสดุที่ถูกยืมจากตาราง items
                    $update_stock_sql = "UPDATE items SET quantity = quantity - ? WHERE item_id = ?";
                    $stmt = $conn->prepare($update_stock_sql);
                    $stmt->bind_param("ii", $quantity, $item_id);

                    if ($stmt->execute()) {
                        echo "อัปเดตจำนวนวัสดุเรียบร้อยสำหรับวัสดุ ID: $item_id <br>";
                    } else {
                        echo "ไม่สามารถอัปเดตจำนวนวัสดุได้: " . $stmt->error . "<br>";
                    }
                } else {
                    echo "ไม่สามารถบันทึกข้อมูลการเบิกได้: " . $stmt->error . "<br>";
                }
            } else {
                // แจ้งเตือนว่าจำนวนวัสดุไม่เพียงพอ
                echo "จำนวนวัสดุไม่เพียงพอสำหรับวัสดุ ID: $item_id ต้องการ $quantity แต่มีเพียง " . $row['quantity'] . "<br>";
            }
        } else {
            echo "ค่า quantity ไม่ถูกต้องสำหรับวัสดุ ID: $item_id<br>";
        }
    }
}
