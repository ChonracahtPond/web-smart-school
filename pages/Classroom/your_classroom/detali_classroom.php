<?php
// รับ course_id จาก URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php'); // ถ้าไม่มี course_id ให้เปลี่ยนเส้นทางไปยังหน้าอื่น
    exit();
}

$course_id = $_GET['id']; // กำหนด course_id จาก URL

// คำสั่ง SQL เพื่อดึงข้อมูลจากตาราง lessons ตาม course_id
$sql = "SELECT lesson_id, course_id, lesson_title, lesson_content, lesson_date, status 
        FROM lessons 
        WHERE course_id = ?";

$stmt = $conn->prepare($sql); // เตรียมคำสั่ง SQL
$stmt->bind_param("i", $course_id); // ผูกตัวแปร course_id เข้ากับคำสั่ง SQL
$stmt->execute(); // รันคำสั่ง SQL
$result = $stmt->get_result(); // รับผลลัพธ์

// คำสั่ง SQL เพื่อดึงข้อมูลหลักสูตรจากตาราง courses
$course_sql = "SELECT course_name, course_description FROM courses WHERE course_id = ?";
$course_stmt = $conn->prepare($course_sql);
$course_stmt->bind_param("i", $course_id);
$course_stmt->execute();
$course_result = $course_stmt->get_result();
$course = $course_result->fetch_assoc();
?>

<div class="container mx-auto p-6 bg-gray-50 rounded-lg shadow-md">
    <h1 class="text-4xl font-semibold text-center text-purple-900 mb-4"><?php echo htmlspecialchars($course['course_name']); ?></h1>
    <p class="text-lg text-center text-gray-700 mb-6"><?php echo htmlspecialchars($course['course_description']); ?></p>

    <!-- ปุ่มเพิ่มบทเรียน -->
    <div class="text-center mb-6">
        <button id="addLessonBtn" class="w-[250px] h-12 bg-green-500 text-white px-4 py-2 rounded-lg text-xl hover:bg-green-600 transition-transform transform hover:scale-105 duration-300">
            + เพิ่มบทเรียน
        </button>
    </div>

    <!-- Modal สำหรับเพิ่มบทเรียน -->
    <div id="addLessonModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/2">
            <h2 class="text-2xl font-semibold mb-4 text-center">เพิ่มบทเรียน</h2>
            <form action="add_lesson.php" method="POST">
                <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">

                <div class="mb-4">
                    <label for="lesson_title" class="block text-gray-700">ชื่อบทเรียน:</label>
                    <input type="text" name="lesson_title" id="lesson_title" class="border border-gray-300 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                </div>

                <div class="mb-4">
                    <label for="lesson_content" class="block text-gray-700">เนื้อหาบทเรียน:</label>
                    <textarea name="lesson_content" id="lesson_content" class="border border-gray-300 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-600" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="lesson_date" class="block text-gray-700">วันที่:</label>
                    <input type="date" name="lesson_date" id="lesson_date" class="border border-gray-300 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="closeModal" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2">ยกเลิก</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">เพิ่มบทเรียน</button>
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto mt-6">
        <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-200">
            <thead>
                <tr class="bg-purple-600 text-white">
                    <th class="py-3 px-4 text-left">ชื่อบทเรียน</th>
                    <th class="py-3 px-4 text-left">เนื้อหาบทเรียน</th>
                    <th class="py-3 px-4 text-left">วันที่</th>
                    <th class="py-3 px-4 text-left">สถานะ</th>
                    <th class="py-3 px-4 text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) { // ถ้ามีข้อมูลในผลลัพธ์
                    while ($row = $result->fetch_assoc()) { // วนลูปผ่านข้อมูลแต่ละแถว
                ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4"><?php echo htmlspecialchars($row['lesson_title']); ?></td> <!-- ชื่อบทเรียน -->
                            <td class="py-3 px-4"><?php echo htmlspecialchars($row['lesson_content']); ?></td> <!-- เนื้อหาบทเรียน -->
                            <td class="py-3 px-4"><?php echo htmlspecialchars($row['lesson_date']); ?></td> <!-- วันที่ -->
                            <td class="py-3 px-4"><?php echo htmlspecialchars($row['status']); ?></td> <!-- สถานะ -->
                            <td class="py-3 px-4 flex  space-x-2">
                                <!-- ปุ่มแก้ไข -->
                                <a href="?page=lesson_detail&id=<?php echo htmlspecialchars($row['lesson_id']); ?>" class="flex items-center bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 transition duration-300 h-10">
                                    <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                        <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg>
                                    ดูรายละเอียด
                                </a>
                                <!-- ปุ่มลบ -->
                                <form action="delete_lesson.php" method="POST" class="inline-block">
                                    <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($row['lesson_id']); ?>">
                                    <button type="submit" onclick="return confirm('คุณแน่ใจว่าต้องการลบบทเรียนนี้?');" class="flex items-center bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition duration-300 h-10">
                                        <svg class="h-5 w-5 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" />
                                            <line x1="4" y1="7" x2="20" y2="7" />
                                            <line x1="10" y1="11" x2="10" y1="17" />
                                            <line x1="14" y1="11" x2="14" y1="17" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                        ลบ
                                    </button>
                                </form>
                            </td>

                        </tr>

                <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center text-purple-600 py-3'>ไม่มีบทเรียนที่เกี่ยวข้อง</td></tr>"; // ข้อความถ้าไม่มีบทเรียน
                }
                ?>
            </tbody>

            <tfoot>
                <tr class="bg-purple-600 text-white">
                    <th class="py-3 px-4 text-left">ชื่อบทเรียน</th>
                    <th class="py-3 px-4 text-left">เนื้อหาบทเรียน</th>
                    <th class="py-3 px-4 text-left">วันที่</th>
                    <th class="py-3 px-4 text-left">สถานะ</th>
                    <th class="py-3 px-4 text-center">จัดการ</th>
                </tr>

            </tfoot>

        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addLessonBtn').click(function() {
            $('#addLessonModal').removeClass('hidden'); // แสดง modal
        });

        $('#closeModal').click(function() {
            $('#addLessonModal').addClass('hidden'); // ปิด modal
        });
    });
</script>