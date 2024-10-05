<?php
// ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$selected_course = isset($_GET['course_name']) ? trim($_GET['course_name']) : '';

// Get the current year
$current_year = date('Y') + 543;

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง courses พร้อมการค้นหา และเรียงลำดับจากใหม่ไปเก่า
$sql = "SELECT c.course_id, c.course_name, c.course_description, c.teacher_id, c.course_type, c.course_code, c.credits, c.semester, c.academic_year, c.status, t.teacher_name
        FROM courses c
        LEFT JOIN teachers t ON c.teacher_id = t.teacher_id
        WHERE (c.course_name LIKE ? OR c.course_description LIKE ? OR t.teacher_name LIKE ?) AND c.status = '1'
        AND (c.course_name = ? OR ? = '')
        AND c.academic_year = ?
        ORDER BY c.course_id DESC";

// เตรียมการค้นหาข้อมูล
$searchTerm = "%$search%";
$courseFilter = $selected_course;
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssss', $searchTerm, $searchTerm, $searchTerm, $courseFilter, $courseFilter, $current_year);
$stmt->execute();
$result = $stmt->get_result();

// ดึงชื่อคอร์สทั้งหมดเพื่อใช้ใน dropdown
$courses_query = "SELECT DISTINCT course_name FROM courses ORDER BY course_name";
$courses_result = $conn->query($courses_query);

?>


<link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">

        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">รายวิชาทั้งหมด</h1>


        <a href="?page=Manage_courses">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 mt-4 flex items-center space-x-2 transition duration-200 ease-in-out">
                <svg class="h-5 w-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <line x1="15" y1="16" x2="19" y2="12" />
                    <line x1="15" y1="8" x2="19" y2="12" />
                </svg>
                <span class="font-medium">ไปที่หน้าจัดการรายวิชา</span>
            </button>
        </a>

        <!-- ฟอร์มค้นหา -->
        <form method="GET" action="" class="mb-4">
            <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                <div class="flex-1 mb-4 md:mb-0">
                    <input id="search-input" type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="ค้นหาตามชื่อรายวิชา คำอธิบาย หรืออาจารย์">
                </div>
                <div class="flex-1 mb-4 md:mb-0">
                    <select id="course_name" name="course_name" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                        <option value="">เลือกรายวิชา</option>
                        <?php while ($course_row = $courses_result->fetch_assoc()) : ?>
                            <option value="<?php echo htmlspecialchars($course_row['course_name']); ?>" <?php if ($selected_course == $course_row['course_name']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($course_row['course_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">ค้นหา</button> -->
            </div>
        </form>
        <!-- <p class="text-red-400">**คลิกที่การดำเนินการเพื่อดูรายละเอียดรายวิชา**</p> -->

        <!-- Card Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="card bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 flex flex-col justify-between">
                        <div class="mb-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white"><?php echo htmlspecialchars($row['course_name']); ?></h2>
                            <p class="text-gray-600 dark:text-gray-300"><?php echo htmlspecialchars($row['course_description']); ?></p>
                            <p class="text-gray-500 dark:text-gray-400">อาจารย์: <?php echo htmlspecialchars($row['teacher_name']); ?></p>
                            <p class="text-gray-500 dark:text-gray-400">ประเภท: <?php echo ($row['course_type'] === 'mandatory') ? 'บังคับ' : 'วิชาเลือก'; ?></p>
                            <p class="text-gray-500 dark:text-gray-400">รหัสรายวิชา: <?php echo htmlspecialchars($row['course_code']); ?></p>
                            <p class="text-gray-500 dark:text-gray-400">หน่วยกิจ: <?php echo htmlspecialchars($row['credits']); ?></p>
                            <p class="text-gray-500 dark:text-gray-400">ภาคเรียน: <?php echo htmlspecialchars($row['semester']); ?></p>
                            <p class="text-gray-500 dark:text-gray-400">ปีการศึกษา: <?php echo htmlspecialchars($row['academic_year']); ?></p>
                            <p class="text-gray-500 dark:text-gray-400">สถานะ: <?php echo ($row['status'] == 1) ? '<span class="text-green-500">กำลังทำงาน</span>' : '<span class="text-red-500">ไม่ได้ใช้งาน</span>'; ?></p>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <a href="?page=course_details&course_id=<?php echo htmlspecialchars($row['course_id']); ?>" class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-600 flex items-center space-x-2">
                                <i class="fas fa-eye"></i>
                                <span>ดูรายละเอียด</span>
                            </a>
                            <a href="?page=edit_course&id=<?php echo htmlspecialchars($row['course_id']); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600 flex items-center space-x-2">
                                <i class="fas fa-pencil-alt"></i>
                                <span>แก้ไข</span>
                            </a>
                            <a href="?page=delete_course&id=<?php echo htmlspecialchars($row['course_id']); ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 flex items-center space-x-2" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">
                                <i class="fas fa-trash-alt"></i>
                                <span>ลบ</span>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="text-gray-600 text-center col-span-full">ไม่มีข้อมูล</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// include "add_course.php"; 
?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    // JavaScript สำหรับเปิดและปิด Modal
    $('#openModal').click(function() {
        $('#courseModal').removeClass('hidden');
    });

    $('#closeModal').click(function() {
        $('#courseModal').addClass('hidden');
    });

    // JavaScript สำหรับการค้นหาแบบเรียลไทม์
    document.getElementById('search-input').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const cards = document.querySelectorAll('.card');

        cards.forEach(card => {
            const textContent = card.textContent.toLowerCase();
            card.style.display = textContent.includes(searchQuery) ? '' : 'none';
        });
    });
</script>