<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ล็อกอิน</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <link rel="stylesheet" href="https://horizon-tailwind-react-corporate-7s21b54hb-horizon-ui.vercel.app/static/css/main.d7f96858.css" />
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg border border-gray-200">
        <div class="text-center mb-6">
            <img src="https://www.example.com/school-logo.png" alt="School Logo" class="mx-auto mb-4 w-24 h-24">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">เข้าสู่ระบบ</h1>
            <p class="text-lg text-gray-600">ยินดีต้อนรับสู่ระบบของโรงเรียน</p>
        </div>

        <!-- Display error message -->
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="text-red-500 text-center mb-4">ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</p>';
        }
        ?>

        <form action="process_login.php" method="post" class="space-y-5">
            <div>
                <label for="username" class="block text-base font-medium text-gray-700">ชื่อผู้ใช้:</label>
                <input type="text" id="username" name="username" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label for="password" class="block text-base font-medium text-gray-700">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <button type="submit" class="w-full py-3 px-6 bg-green-600 text-white font-semibold rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-3 focus:ring-green-500">
                เข้าสู่ระบบ
            </button>
        </form>
    </div>
</body>

</html>
