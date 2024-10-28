<?php
// กำหนด lesson_id จาก URL

// ตรวจสอบว่าแบบฟอร์มถูกส่งมา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lesson_id = isset($_GET['id']) ? $_GET['id'] : null;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $status = '0';
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // สร้างคำสั่ง SQL เพื่อเพิ่มข้อมูล
    $sql = "INSERT INTO exercises (lesson_id, title, description, created_at, updated_at, status, quantity) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // เตรียมและ bind parameters
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isssssi", $lesson_id, $title, $description, $created_at, $updated_at, $status, $quantity);

        // Execute the statement
        if ($stmt->execute()) {
            $exercise_id = $stmt->insert_id;
            // echo "<div class='bg-green-200 text-green-800 p-4 rounded'>เพิ่มแบบฝึกหัดสำเร็จ!</div>";
            echo "<script>window.location.href='?page=show_exam&exercise_id=$exercise_id&status=1';</script>";
            exit();
        } else {
            echo "<div class='bg-red-200 text-red-800 p-4 rounded'>เกิดข้อผิดพลาด: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มแบบฝึกหัด</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <button onclick="closeModal()" class="float-right text-gray-500 hover:text-gray-700">×</button>
    <div class="max-w-md mx-auto bg-white p-6">
        <h1 class="text-2xl font-bold mb-4">เพิ่มแบบฝึกหัด</h1>
        <form method="POST" action="">
            <input type="hidden" id="lesson_id" name="lesson_id" value="<?php echo htmlspecialchars($lesson_id); ?>">

            <div class="mb-4">
                <label for="title" class="block text-gray-700">ชื่อเรื่อง:</label>
                <input type="text" id="title" name="title" required class="border border-gray-300 p-2 w-full rounded">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700">คำอธิบาย:</label>
                <textarea id="description" name="description" required class="border border-gray-300 p-2 w-full rounded"></textarea>
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">จำนวน:</label>
                <input type="number" id="quantity" name="quantity" required class="border border-gray-300 p-2 w-full rounded">
            </div>

            <input type="submit" value="เพิ่มแบบฝึกหัด" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
        </form>
    </div>
</body>

</html>