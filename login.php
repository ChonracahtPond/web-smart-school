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
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4 text-center text-blue-600">เข้าสู่ระบบ</h1>

        <!-- Display error message -->
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="text-red-500 text-center mb-4">ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</p>';
        }
        ?>

        <form action="process_login.php" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">ชื่อผู้ใช้:</label>
                <input type="text" id="username" name="username" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                เข้าสู่ระบบ
            </button>
        </form>
    </div>
</body>

</html>