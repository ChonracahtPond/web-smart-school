<?php
// รับ lesson_id จาก URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php'); // ถ้าไม่มี lesson_id ให้เปลี่ยนเส้นทางไปยังหน้าอื่น
    exit();
}

$lesson_id = $_GET['id']; // กำหนด lesson_id จาก URL

// ดึงข้อมูลจากตาราง lessons
$sql = "SELECT lesson_title, lesson_content, lesson_date, status FROM lessons WHERE lesson_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lesson_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='text-center mt-6'>ไม่พบข้อมูลบทเรียน</div>";
    exit();
}

$lesson = $result->fetch_assoc();

// ดึงข้อมูลจากตาราง online_meetings
$meetings_sql = "SELECT meeting_id, meeting_link, meeting_date, meeting_time, status FROM online_meetings WHERE lesson_id = ?";
$meetings_stmt = $conn->prepare($meetings_sql);
$meetings_stmt->bind_param("i", $lesson_id);
$meetings_stmt->execute();
$meetings_result = $meetings_stmt->get_result();

// ดึงข้อมูลจากตาราง assignments
$assignments_sql = "SELECT assignment_id, assignment_title, assignment_description, due_date, status FROM assignments WHERE lesson_id = ?";
$assignments_stmt = $conn->prepare($assignments_sql);
$assignments_stmt->bind_param("i", $lesson_id);
$assignments_stmt->execute();
$assignments_result = $assignments_stmt->get_result();

// ดึงข้อมูลจากตาราง exercises
$exercises_sql = "SELECT exercise_id, title, description, quantity, status, created_at, updated_at FROM exercises WHERE lesson_id = ?";
$exercises_stmt = $conn->prepare($exercises_sql);
$exercises_stmt->bind_param("i", $lesson_id);
$exercises_stmt->execute();
$exercises_result = $exercises_stmt->get_result();
?>


<div class="container mx-auto p-6 bg-gray-50 rounded-lg shadow-md">

    <h1 class="text-4xl font-semibold text-center text-purple-900 mb-4"><?php echo htmlspecialchars($lesson['lesson_title']); ?></h1>
    <p class="text-lg text-center text-gray-700 mb-6">วันที่: <?php echo htmlspecialchars($lesson['lesson_date']); ?></p>
    <!-- <p class="text-lg text-gray-800 mb-4"><?php echo nl2br(htmlspecialchars($lesson['lesson_content'])); ?></p>
    <p class="text-md text-gray-700 mb-4">สถานะ: <span class="font-semibold"><?php echo htmlspecialchars($lesson['status']); ?></span></p> -->

    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-purple-900 mb-4">การเรียนออนไลน์</h2>
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
                                    <?php echo htmlspecialchars($meeting['meeting_link']); ?>
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
            <p class="text-gray-700">ไม่มีการเรียนออนไลน์ที่เกี่ยวข้อง</p>
        <?php } ?>
        <div class="text-center mt-4">
            <button id="openModal" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">เพิ่มข้อมูลการเรียนออนไลน์</button>
        </div>

    </div>


    <!-- โมดัลเพิ่มการฝึกหัด -->
    <div id="meetingModal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

            <?php include "sql/add_onlinemeeting.php"; ?>
        </div>
    </div>





    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-purple-900 mb-4">การบ้าน</h2>
        <?php if ($assignments_result->num_rows > 0) { ?>
            <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-200">
                <thead>
                    <tr class="bg-purple-600 text-white">
                        <th class="py-3 px-4 text-left">Assignment Title</th>
                        <th class="py-3 px-4 text-left">Description</th>
                        <th class="py-3 px-4 text-left">Due Date</th>
                        <th class="py-3 px-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($assignment = $assignments_result->fetch_assoc()) { ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($assignment['assignment_title']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($assignment['assignment_description']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($assignment['due_date']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($assignment['status']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="text-gray-700">ไม่มีการบ้านที่เกี่ยวข้อง</p>
            <div class="text-center mt-4">
                <a href="add_assignment.php?lesson_id=<?php echo htmlspecialchars($lesson_id); ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">เพิ่มการบ้าน</a>
            </div>
        <?php } ?>
    </div>

    <!-- ตารางการฝึกหัด -->
    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-purple-900 mb-4">การฝึกหัด</h2>
        <?php if ($exercises_result->num_rows > 0) { ?>
            <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-200">
                <thead>
                    <tr class="bg-purple-600 text-white">
                        <th class="py-3 px-4 text-left">Exercise Title</th>
                        <th class="py-3 px-4 text-left">Description</th>
                        <th class="py-3 px-4 text-left">Quantity</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Created At</th>
                        <th class="py-3 px-4 text-left">Updated At</th>
                        <th class="py-3 px-4 text-left">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($exercise = $exercises_result->fetch_assoc()) { ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($exercise['title']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($exercise['description']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($exercise['quantity']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($exercise['status']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($exercise['created_at']); ?></td>
                            <td class="py-3 px-4"><?php echo htmlspecialchars($exercise['updated_at']); ?></td>
                            <td class="py-3 px-4">
                                <a href="?page=show_exam&exercise_id=<?php echo htmlspecialchars($exercise['exercise_id']); ?>" class="flex items-center bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 transition duration-300 h-10">
                                    <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                        <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg>
                                    ดูรายละเอียด
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        <?php } else { ?>
            <p class="text-gray-700">ไม่มีการฝึกหัดที่เกี่ยวข้อง</p>
            <!-- ปุ่มเปิดโมดัล -->
            <div class="text-center mt-4">
                <button onclick="openModal()" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                    เพิ่มการฝึกหัด
                </button>
            </div>
        <?php } ?>
    </div>

    <!-- โมดัลเพิ่มการฝึกหัด -->
    <div id="exerciseModal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

            <?php
            include "./exercise/add_exercise.php";
            // include "../testExercise/add_exercise.php";
            ?>
        </div>
    </div>

    <div class="text-center mt-6">
        <!-- <a href="index.php" class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition duration-300">กลับไปยังหน้าหลัก</a> -->
    </div>
</div>
<script>
    // Script to handle modal open and close
    document.getElementById("openModal").onclick = function() {
        document.getElementById("meetingModal").classList.remove("hidden");
    }

    document.getElementById("closeModal").onclick = function() {
        document.getElementById("meetingModal").classList.add("hidden");
    }
</script>

<script>
    function openModal() {
        document.getElementById("exerciseModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("exerciseModal").classList.add("hidden");
        document.getElementById("meetingModal").classList.add("hidden");
    }
</script>