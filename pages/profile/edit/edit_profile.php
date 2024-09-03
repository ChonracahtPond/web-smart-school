<?php
// session_start();
// include 'includes/db_connect.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบการเข้าสู่ระบบและมีการตั้งค่า user_id หรือไม่
if (!isset($_SESSION['user_id'])) {
    echo "กรุณาเข้าสู่ระบบก่อน.";
    exit();
}

$user_id = $_SESSION['user_id'];

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "SELECT username, email, phone_number FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);

    // ตรวจสอบว่า password ถูกกรอกมาใหม่หรือไม่
    if (!empty($_POST['password'])) {
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username = ?, email = ?, phone_number = ?, password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $username, $email, $phone_number, $password, $user_id);
    } else {
        $sql = "UPDATE users SET username = ?, email = ?, phone_number = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $phone_number, $user_id);
    }

    if ($stmt->execute()) {
        echo "อัปเดตโปรไฟล์สำเร็จ.";
        // อัปเดต session ด้วย username ใหม่
        $_SESSION['username'] = $username;
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตโปรไฟล์: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<div class="max-w-3xl mx-auto p-8 bg-white shadow-md rounded-lg mt-10">
    <h1 class="text-2xl font-semibold mb-6">แก้ไขโปรไฟล์ของคุณ</h1>
    <form action="edit_profile.php" method="POST" class="space-y-6">
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">ชื่อผู้ใช้:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">อีเมล:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">หมายเลขโทรศัพท์:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">รหัสผ่านใหม่ (หากต้องการเปลี่ยน):</label>
            <input type="password" id="password" name="password"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">บันทึกการเปลี่ยนแปลง</button>
        </div>
    </form>
</div>