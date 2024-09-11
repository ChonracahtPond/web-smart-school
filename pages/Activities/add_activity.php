<?php
// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $activity_name = $_POST['activity_name'];
    $description = $_POST['description'];
    $activity_hour = $_POST['activity_hour'];
    $activity_credits = $_POST['activity_credits'];
    $activity_type = $_POST['activity_type'];  // รับประเภทกิจกรรม
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $location = $_POST['location'];

    // คำสั่ง SQL สำหรับเพิ่มกิจกรรมใหม่
    $sql = "INSERT INTO activities (activity_name, description, activity_credits, activity_type, activity_hour, start_date, end_date, location) 
            VALUES ('$activity_name', '$description', '$activity_credits', '$activity_type', '$activity_hour', '$start_date', '$end_date', '$location')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>window.location.href='?page=Manage_Activity&status=1';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>window.location.href='?page=Manage_Activity&status=0';</script>";
    }
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">เพิ่ม กิจกรรม</h1>
    <form action="" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ชื่อกิจกรรม:</label>
            <input type="text" name="activity_name" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">รายละเอียดกิจกรรม:</label>
            <textarea name="description" class="mt-1 p-2 w-full border border-gray-300 rounded" required></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">จำนวนชั่วโมง:</label>
            <input type="text" name="activity_hour" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">หน่วยกิตที่ได้รับ:</label>
            <input type="number" name="activity_credits" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">ประเภทกิจกรรม:</label>
            <select name="activity_type" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                <option>--กรุณาเลือกประเภท--</option>
                <option value="พัฒนาทักษะชีวิตของตนเอง">ประเภทที่ 1 กิจกรรมการเรียนรู้ที่มุ่งเน้นการพัฒนาทักษะชีวิตของตนเอง</option>
                <option value="พัฒนาชุมชนและสังคม">ประเภทที่ 2 กิจกรรมการเรียนรู้ที่มุ่งเน้นการพัฒนาชุมชนและสังคม</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">เริ่มวันที่:</label>
            <input type="date" name="start_date" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">สิ้นสุด:</label>
            <input type="date" name="end_date" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">สถานที่:</label>
            <input type="text" name="location" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">เพิ่มกิจกรรม</button>
    </form>
</div>
</body>