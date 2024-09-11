<?php

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $activity_id = $_POST['activity_id'];
    $activity_name = $_POST['activity_name'];
    $description = $_POST['description'];
    $activity_hour = $_POST['activity_hour'];
    $activity_credits = $_POST['activity_credits'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $location = $_POST['location'];

    // คำสั่ง SQL สำหรับอัปเดตข้อมูลกิจกรรม
    $sql = "UPDATE activities SET activity_name='$activity_name', description='$description',activity_hour='$activity_hour', activity_Credits='$activity_credits',activity_hour='$activity_hour', start_date='$start_date', end_date='$end_date', location='$location' WHERE activity_id='$activity_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script> window.location.href='?page=Manage_Activity&status=1';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>window.location.href='?page=Manage_Activity&status=0';</script>";
    }
}

// รับ activity_id จาก URL
$activity_id = $_GET['id'];

// คำสั่ง SQL สำหรับดึงข้อมูลกิจกรรม
$sql = "SELECT * FROM activities WHERE activity_id='$activity_id'";
$result = $conn->query($sql);
$activity = $result->fetch_assoc();
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">แก้ไขกิจกรรม กพช.</h1>
    <form action="" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <input type="hidden" name="activity_id" value="<?php echo htmlspecialchars($activity['activity_id']); ?>">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชื่อกิจกรรม:</label>
            <input type="text" name="activity_name" value="<?php echo htmlspecialchars($activity['activity_name']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">คำอธิบาย:</label>
            <textarea name="description" class="mt-1 p-2 w-full border border-gray-300 rounded" required><?php echo htmlspecialchars($activity['description']); ?></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชั่วโมงกิจกรรม:</label>
            <input type="text" name="activity_hour" value="<?php echo htmlspecialchars($activity['activity_hour']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">หน่วยกิต:</label>
            <input type="number" name="activity_credits" value="<?php echo htmlspecialchars($activity['activity_Credits']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">วันที่เริ่ม:</label>
            <input type="date" name="start_date" value="<?php echo htmlspecialchars($activity['start_date']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">วันที่สิ้นสุด:</label>
            <input type="date" name="end_date" value="<?php echo htmlspecialchars($activity['end_date']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">สถานที่:</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($activity['location']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">บันทึก</button>
    </form>
</div>
