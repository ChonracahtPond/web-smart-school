<?php
include 'sql.php';

// Modify the query to fetch only the 4 most recent news items
$query = "SELECT * FROM news ORDER BY New_id DESC LIMIT 4";
$result_news = $conn->query($query);

if (!$result_news) {
    // Output error message and stop script execution
    echo "Error executing query: " . $conn->error;
    exit;
}

// Get the total number of news items to check if there are more than 4
$total_news_query = "SELECT COUNT(*) AS total FROM news";
$total_news_result = $conn->query($total_news_query);
$total_news = $total_news_result->fetch_assoc()['total'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <!-- Page Title based on 'page' parameter -->
        <div class="mb-8">
            <?php
            switch ($page) {
                case 'education':
                    echo "<h1 class='text-4xl font-bold text-blue-800'>สวัสดี</h1>";
                    break;
                case 'teacher':
                    echo "<h1 class='text-4xl font-bold text-blue-800'>ยินดีต้อนรับเข้าสู่หน้าคุณครู</h1>";
                    break;
                case 'system.php':
                    echo "<h1 class='text-4xl font-bold text-blue-800'>ยินดีต้อนรับเข้าสู่หน้าคุณครู</h1>";
                    break;
                default:
                    echo "<h1 class='text-4xl font-bold text-blue-800'>ยินดีต้อนรับสู่ระบบ สกร.</h1>";
                    break;
            }
            ?>
        </div>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Summary Information -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex-1">
                <h2 class="text-3xl font-semibold mb-6 text-gray-800">ข้อมูลสรุป</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Number of Students -->
                    <div class="bg-blue-700 p-6 rounded-lg shadow-md">
                        <p class="text-lg font-semibold text-white">นักศึกษาทั้งหมด จำนวน <span class="text-1xl font-bold text-blue-300"><?php echo htmlspecialchars($students_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">ชาย <span class="text-1xl font-bold text-blue-300"><?php echo htmlspecialchars($male_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">หญิง <span class="text-1xl font-bold text-blue-300"><?php echo htmlspecialchars($female_count); ?></span> คน</p>
                    </div>

                    <!-- Primary Level Students -->
                    <div class="bg-green-700 p-6 rounded-lg shadow-md">
                        <p class="text-lg font-semibold text-white">ระดับ ประถม ทั้งหมด <span class="text-1xl font-bold text-green-300"><?php echo htmlspecialchars($primary_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">ชาย <span class="text-1xl font-bold text-green-300"><?php echo htmlspecialchars($primary_male_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">หญิง <span class="text-1xl font-bold text-green-300"><?php echo htmlspecialchars($primary_female_count); ?></span> คน</p>
                    </div>

                    <!-- Lower Secondary Students -->
                    <div class="bg-yellow-700 p-6 rounded-lg shadow-md">
                        <p class="text-lg font-semibold text-white">ระดับ มัธยมต้น ทั้งหมด <span class="text-1xl font-bold text-yellow-300"><?php echo htmlspecialchars($lower_secondary_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">ชาย <span class="text-1xl font-bold text-yellow-300"><?php echo htmlspecialchars($lower_secondary_male_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">หญิง <span class="text-1xl font-bold text-yellow-300"><?php echo htmlspecialchars($lower_secondary_female_count); ?></span> คน</p>
                    </div>

                    <!-- Upper Secondary Students -->
                    <div class="bg-red-700 p-6 rounded-lg shadow-md">
                        <p class="text-lg font-semibold text-white">ระดับ มัธยมปลาย ทั้งหมด <span class="text-1xl font-bold text-red-300"><?php echo htmlspecialchars($upper_secondary_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">ชาย <span class="text-1xl font-bold text-red-300"><?php echo htmlspecialchars($upper_secondary_male_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">หญิง <span class="text-1xl font-bold text-red-300"><?php echo htmlspecialchars($upper_secondary_female_count); ?></span> คน</p>
                    </div>

                    <!-- Number of Courses -->
                    <div class="bg-gray-700 p-6 rounded-lg shadow-md">
                        <p class="text-lg font-semibold text-white">รายวิชาทั้งหมด <span class="text-1xl font-bold text-gray-300"><?php echo htmlspecialchars($classes_courses); ?></span> รายวิชา</p>
                        <p class="text-lg font-semibold text-white">รายวิชาที่เปิดสอนตอนนี้ <span class="text-1xl font-bold text-gray-300"><?php echo htmlspecialchars($active_courses); ?></span> รายวิชา</p>
                    </div>

                    <!-- Number of Teachers -->
                    <div class="bg-purple-700 p-6 rounded-lg shadow-md">
                        <p class="text-lg font-semibold text-white">ครูทั้งหมด <span class="text-1xl font-bold text-purple-300"><?php echo htmlspecialchars($teachers_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">ครู <span class="text-1xl font-bold text-purple-300"><?php echo htmlspecialchars($kru_count); ?></span> คน</p>
                        <p class="text-lg font-semibold text-white">ครูบรรจุ <span class="text-1xl font-bold text-purple-300"><?php echo htmlspecialchars($krubanju_count); ?></span> คน</p>
                    </div>
                </div>








                <div class=" mt-5">
                    <h2 class="text-3xl font-semibold mb-6 text-gray-800">ฟังก์ชันหลัก</h2>

                    <a href="education.php?page=Manage_courses" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">จัดการคอร์ส</a>
                    <a href="student.php?page=Manage_student" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">จัดการนักเรียน</a>
                    <a href="teacher.php?page=Teacher_Manage" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">จัดการครู</a>
                    <a href="system.php?page=Manage_News" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">จัดการข่าวสาร</a>

                </div>
            </div>

            <!-- Quick Links -->

            <div class="bg-white shadow-lg rounded-lg p-6 w-full md:w-1/4">
                <h2 class="text-3xl font-semibold mb-6 text-gray-800">ข่าวสารล่าสุด</h2>
                <?php if ($result_news->num_rows > 0) : ?>
                    <div class="space-y-6">
                        <?php while ($news = $result_news->fetch_assoc()) : ?>
                            <div class="flex bg-gray-50 rounded-lg shadow-md overflow-hidden">
                                <?php if (!empty($news['News_images'])) : ?>
                                    <img src="<?php echo htmlspecialchars($news['News_images']); ?>" alt="ข่าวสาร" class="w-1/3 h-24 object-cover">
                                <?php endif; ?>
                                <div class="p-4 w-2/3 flex flex-col justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800 truncate"><?php echo htmlspecialchars($news['News_name']); ?></h3>
                                    <p class="text-gray-700 truncate"><?php echo htmlspecialchars($news['News_detail']); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php if ($total_news > 4) : ?>
                        <a href="system.php?page=Manage_News" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">ดูข้อมูลเพิ่มเติม</a>
                    <?php endif; ?>
                <?php else : ?>
                    <p class="text-gray-600">ไม่มีข่าวสารล่าสุด</p>
                <?php endif; ?>
            </div>




        </div>

        <!-- Latest News -->
        <div class="bg-white shadow-lg rounded-lg p-6 mt-6 ">
            <h2 class="text-3xl font-semibold mb-6 text-gray-800">อีเว้นท์</h2>
            <?php include "calendar/calendar.php"; ?>
        </div>
    </div>

</body>

</html>