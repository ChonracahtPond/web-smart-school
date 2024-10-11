<?php
// เริ่ม session และเชื่อมต่อกับฐานข้อมูล
session_start();
include('../db_connection.php'); // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าแบบฟอร์มถูกส่งมา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lesson_id = $_POST['lesson_id'];
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
            $exercise_id = $stmt->insert_id; // รับค่า exercise_id ที่ถูกเพิ่มเข้ามา
            echo "<div class='bg-green-200 text-green-800 p-4 rounded'>Exercise added successfully!</div>";
            // เปลี่ยนเส้นทางไปยัง add_questions.php พร้อมส่งค่า exercise_id
            // header("Location: add_questions.php?exercise_id=" . $exercise_id);
            echo "<script>window.location.href='?page=show_exam&exercise_id=$exercise_id&status=1';</script>";

            exit(); // หยุดการทำงานของสคริปต์
        } else {
            echo "<div class='bg-red-200 text-red-800 p-4 rounded'>Error: " . $stmt->error . "</div>";
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
    <title>Add Exercise</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Add an Exercise</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="lesson_id" class="block text-gray-700">Lesson ID:</label>
                <input type="number" id="lesson_id" name="lesson_id" required class="border border-gray-300 p-2 w-full rounded">
            </div>

            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title:</label>
                <input type="text" id="title" name="title" required class="border border-gray-300 p-2 w-full rounded">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description:</label>
                <textarea id="description" name="description" required class="border border-gray-300 p-2 w-full rounded"></textarea>
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required class="border border-gray-300 p-2 w-full rounded">
            </div>

            <input type="submit" value="Add Exercise" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
        </form>
    </div>
</body>

</html>