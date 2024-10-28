<?php

// รับ lesson_id จาก URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php'); // ถ้าไม่มี lesson_id ให้เปลี่ยนเส้นทางไปยังหน้าอื่น
    exit();
}

$lesson_id = $_GET['id']; // กำหนด lesson_id จาก URL

// คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง lessons ตาม lesson_id
$sql = "SELECT lesson_title, lesson_content, lesson_date, status FROM lessons WHERE lesson_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lesson_id);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบว่าพบข้อมูลหรือไม่
if ($result->num_rows === 0) {
    echo "<div class='text-center mt-6'>ไม่พบข้อมูลบทเรียน</div>";
    exit();
}

// ดึงข้อมูลบทเรียน
$lesson = $result->fetch_assoc();

// คำสั่ง SQL เพื่อดึงข้อมูลการประชุมออนไลน์ที่เกี่ยวข้อง
$meetings_sql = "SELECT meeting_id, meeting_link, meeting_date, meeting_time, status FROM online_meetings WHERE lesson_id = ?";
$meetings_stmt = $conn->prepare($meetings_sql);
$meetings_stmt->bind_param("i", $lesson_id);
$meetings_stmt->execute();
$meetings_result = $meetings_stmt->get_result();

// คำสั่ง SQL เพื่อดึงข้อมูลการส่งงานที่เกี่ยวข้อง
$submissions_sql = "SELECT submission_id, assignment_id, student_id, submission_date, grade, file, status FROM submissions WHERE lesson_id = ?";
$submissions_stmt = $conn->prepare($submissions_sql);
$submissions_stmt->bind_param("i", $lesson_id);
$submissions_stmt->execute();
$submissions_result = $submissions_stmt->get_result();
?>

<div class="container mx-auto p-6 bg-gray-50 rounded-lg shadow-md">
    <h1 class="text-4xl font-semibold text-center text-purple-900 mb-4"><?php echo htmlspecialchars($lesson['lesson_title']); ?></h1>
    <p class="text-lg text-center text-gray-700 mb-6">วันที่: <?php echo htmlspecialchars($lesson['lesson_date']); ?></p>
    <p class="text-lg text-gray-800 mb-4"><?php echo nl2br(htmlspecialchars($lesson['lesson_content'])); ?></p>
    <p class="text-md text-gray-700 mb-4">สถานะ: <span class="font-semibold"><?php echo htmlspecialchars($lesson['status']); ?></span></p>

    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-purple-900 mb-4">การประชุมออนไลน์</h2>
        <?php if ($meetings_result->num_rows > 0) { ?>
            <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-200">
                <thead>
                    <tr class="bg-purple-600 text-white">
                        <th class="py-3 px-4 text-left">ลิงก์การประชุม</th>
                        <th class="py-3 px-4 text-left">วันที่</th>
                        <th class="py-3 px-4 text-left">เวลา</th>
                        <th class="py-3 px-4 text-left">สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($meeting = $meetings_result->fetch_assoc()) { ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4">
                                <a href="<?php echo htmlspecialchars($meeting['meeting_link']); ?>" class="text-blue-500 hover:underline" target="_blank">
                                    <?php echo 'https://www.youtube.com/watch?v=' . htmlspecialchars($meeting['meeting_link']); ?>
                                </a>
                            </td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($meeting['meeting_date']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($meeting['meeting_time']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($meeting['status']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        <?php } else { ?>
            <p class="text-gray-700">ไม่มีการประชุมออนไลน์ที่เกี่ยวข้อง</p>
            <div class="text-center mt-4">
                <a href="add_meeting.php?lesson_id=<?php echo htmlspecialchars($lesson_id); ?>" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">เพิ่มข้อมูลการประชุมออนไลน์</a>
            </div>
        <?php } ?>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-purple-900 mb-4">การส่งงาน</h2>
        <?php if ($submissions_result->num_rows > 0) { ?>
            <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-200">
                <thead>
                    <tr class="bg-purple-600 text-white">
                        <th class="py-3 px-4 text-left">Assignment ID</th>
                        <th class="py-3 px-4 text-left">Student ID</th>
                        <th class="py-3 px-4 text-left">วันที่ส่ง</th>
                        <th class="py-3 px-4 text-left">เกรด</th>
                        <th class="py-3 px-4 text-left">สถานะ</th>
                        <th class="py-3 px-4 text-left">ไฟล์</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($submission = $submissions_result->fetch_assoc()) { ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($submission['assignment_id']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($submission['student_id']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($submission['submission_date']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($submission['grade']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($submission['status']); ?></td>
                            <td class="py-3 px-4">
                                <?php if (!empty($submission['file'])) { ?>
                                    <a href="<?php echo htmlspecialchars($submission['file']); ?>" class="text-blue-500 hover:underline">ดาวน์โหลด</a>
                                <?php } else { ?>
                                    ไม่มีไฟล์
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="text-gray-700">ไม่มีการส่งงานที่เกี่ยวข้อง</p>
            <div class="text-center mt-4">
                <a href="add_submission.php?lesson_id=<?php echo htmlspecialchars($lesson_id); ?>" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">เพิ่มข้อมูลการส่งงาน</a>
            </div>
        <?php } ?>
    </div>

    <div class="text-center mt-6">
        <a href="index.php" class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition duration-300">กลับไปยังหน้าหลัก</a>
    </div>
</div>