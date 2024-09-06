<?php
// session_start();

// ถ้ามีการส่งค่า tool_color ผ่าน form ให้เก็บค่าไว้ใน session
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tool_color'])) {
    if (isset($_POST['reset_color'])) {
        $_SESSION['tool_color'] = '#6e4db0'; // Reset to default color
    } else {
        $_SESSION['tool_color'] = $_POST['tool_color'];
    }
    echo "<script>window.location.href = window.location.href;</script>"; // รีเฟรชหน้าหลังการบันทึก
    exit();
}

// กำหนดค่า default สีหน้าจอจาก session หรือกำหนดค่าเริ่มต้นเป็นสี #ffffff
$tool_color = isset($_SESSION['tool_color']) ? $_SESSION['tool_color'] : '#ffffff';
?>

<!DOCTYPE html>
<html lang="th" data-theme="mytheme">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการการตั้งค่าหน้าจอ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen" style="background-color: 
<?php
// echo $tool_color; 
?>
;">
    <div class="container mx-auto py-10 px-4">
        <h1 class="text-4xl font-bold mb-8 text-gray-800 text-center">ตั้งค่าแถบสี</h1>

        <form method="POST" action="" class="space-y-6 bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
            <!-- Color Picker -->
            <p class="text-red-500">** คลิกที่แถบสีเพื่อเปลี่ยนสี **</p>

            <div class="flex flex-col space-y-2">
                <label for="tool_color" class="block text-lg font-medium text-gray-700">เลือกแถบสีหน้าจอ</label>

                <input type="color" name="tool_color" id="tool_color" class="p-2 border border-gray-300 rounded-md shadow-sm w-full h-48" value="<?php echo htmlspecialchars($tool_color); ?>">
            </div>

            <div class="text-center mt-6 space-x-4">
                <!-- Save Button -->
                <button type="submit" class="px-6 py-2 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600 transition">
                    บันทึกการเปลี่ยนแปลง
                </button>

                <!-- Reset Button -->
                <button type="submit" name="reset_color" class="px-6 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition">
                    รีเซ็ตสี
                </button>

            </div>
        </form>

    </div>
</body>

</html>