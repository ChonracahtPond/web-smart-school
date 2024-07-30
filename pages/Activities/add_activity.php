<?php


// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $activity_name = $_POST['activity_name'];
    $description = $_POST['description'];
    $activity_hour = $_POST['activity_hour'];
    $activity_credits = $_POST['activity_credits'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $location = $_POST['location'];

    // คำสั่ง SQL สำหรับเพิ่มกิจกรรมใหม่
    $sql = "INSERT INTO activities (activity_name, description, activity_Credits, activity_hour, start_date, end_date, location) 
            VALUES ('$activity_name', '$description', '$activity_credits', '$activity_hour', '$start_date', '$end_date', '$location')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Activity added successfully'); window.location.href='admin.php?page=Manage_Activity';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Add Activity</h1>
    <form action="" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Activity Name:</label>
            <input type="text" name="activity_name" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Description:</label>
            <textarea name="description" class="mt-1 p-2 w-full border border-gray-300 rounded" required></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Activity Hour:</label>
            <input type="text" name="activity_hour" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Credits:</label>
            <input type="number" name="activity_credits" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Start Date:</label>
            <input type="date" name="start_date" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">End Date:</label>
            <input type="date" name="end_date" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Location:</label>
            <input type="text" name="location" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Add Activity</button>
    </form>
</div>
</body>