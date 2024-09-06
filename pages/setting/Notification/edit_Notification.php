<?php

$user_id = $_SESSION['user_id'] ?? null; // รับค่า user_id จากเซสชัน

function getNotificationSettings($conn, $user_id)
{
    $sql = "SELECT * FROM notification_settings WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing the statement: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function saveNotificationSettings($conn, $user_id, $email_notifications, $app_notifications, $sms_notifications)
{
    $sql = "UPDATE notification_settings 
            SET email_notifications = ?, app_notifications = ?, sms_notifications = ?
            WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing the statement: " . $conn->error);
    }
    // ตรวจสอบชนิดข้อมูลที่ถูกต้อง
    $stmt->bind_param("iiii", $email_notifications, $app_notifications, $sms_notifications, $user_id);
    if (!$stmt->execute()) {
        die("Error executing the statement: " . $stmt->error);
    }
    return true;
}

$settings = getNotificationSettings($conn, $user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_notifications = isset($_POST['email_notifications']) ? (int)$_POST['email_notifications'] : 0;
    $app_notifications = isset($_POST['app_notifications']) ? (int)$_POST['app_notifications'] : 0;
    $sms_notifications = isset($_POST['sms_notifications']) ? (int)$_POST['sms_notifications'] : 0;

    if (saveNotificationSettings($conn, $user_id, $email_notifications, $app_notifications, $sms_notifications)) {
        $message = "การตั้งค่าการแจ้งเตือนถูกบันทึกเรียบร้อยแล้ว";
    } else {
        $message = "เกิดข้อผิดพลาดในการบันทึกการตั้งค่า";
    }

    // รีโหลดข้อมูลการตั้งค่า
    $settings = getNotificationSettings($conn, $user_id);
}

$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">การตั้งค่าการแจ้งเตือน</h1>

    <?php if (isset($message)): ?>
        <div class="bg-green-200 text-green-800 p-4 mb-4 rounded">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form action="" method="post" class="bg-white p-6 rounded shadow-md">
        <div class="mb-4">
            <label for="email_notifications" class="block text-sm font-medium text-gray-700">การแจ้งเตือนทางอีเมล</label>
            <select id="email_notifications" name="email_notifications" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="1" <?php echo isset($settings['email_notifications']) && $settings['email_notifications'] == '1' ? 'selected' : ''; ?>>เปิดใช้งาน</option>
                <option value="0" <?php echo isset($settings['email_notifications']) && $settings['email_notifications'] == '0' ? 'selected' : ''; ?>>ปิดการใช้งาน</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="app_notifications" class="block text-sm font-medium text-gray-700">การแจ้งเตือนในแอป</label>
            <select id="app_notifications" name="app_notifications" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="1" <?php echo isset($settings['app_notifications']) && $settings['app_notifications'] == '1' ? 'selected' : ''; ?>>เปิดใช้งาน</option>
                <option value="0" <?php echo isset($settings['app_notifications']) && $settings['app_notifications'] == '0' ? 'selected' : ''; ?>>ปิดการใช้งาน</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="sms_notifications" class="block text-sm font-medium text-gray-700">การแจ้งเตือนผ่าน SMS</label>
            <select id="sms_notifications" name="sms_notifications" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="1" <?php echo isset($settings['sms_notifications']) && $settings['sms_notifications'] == '1' ? 'selected' : ''; ?>>เปิดใช้งาน</option>
                <option value="0" <?php echo isset($settings['sms_notifications']) && $settings['sms_notifications'] == '0' ? 'selected' : ''; ?>>ปิดการใช้งาน</option>
            </select>
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">บันทึกการตั้งค่า</button>
        </div>
    </form>

</div>