<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrow'])) {
    $item_id = $_POST['item_id'];
    $borrower_name = $_POST['borrower_name'];
    $quantity = $_POST['quantity'];

    // ตรวจสอบความพร้อมของวัสดุ
    $sql = "SELECT quantity FROM items WHERE item_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $stmt->bind_result($current_quantity);
        $stmt->fetch();
        $stmt->close();

        // ตรวจสอบว่ามีวัสดุเพียงพอ
        if ($current_quantity >= $quantity) {
            // บันทึกการเบิกวัสดุ
            $sql = "INSERT INTO consumable_borrowings (item_id, borrower_name, quantity, borrow_date) VALUES (?, ?, ?, NOW())";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("isi", $item_id, $borrower_name, $quantity);
                $stmt->execute();
                $stmt->close();

                // ปรับปรุงปริมาณวัสดุ
                $sql = "UPDATE items SET quantity = quantity - ? WHERE item_id = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("ii", $quantity, $item_id);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $conn->error;
                }

                echo "<script>alert('Item borrowed successfully'); window.location.href='system.php?page=Borrow_consumables';</script>";
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "<script>alert('Not enough quantity available'); window.location.href='system.php?page=Borrow_consumables';</script>";
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Borrow Consumables</h1>
        <form action="borrow_consumables.php" method="post" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="item_id" class="block text-gray-700">Item ID:</label>
                <input type="text" id="item_id" name="item_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="borrower_name" class="block text-gray-700">Borrower Name:</label>
                <input type="text" id="borrower_name" name="borrower_name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <button type="submit" name="borrow" class="bg-blue-500 text-white px-4 py-2 rounded-md">Borrow Item</button>
        </form>
    </div>


