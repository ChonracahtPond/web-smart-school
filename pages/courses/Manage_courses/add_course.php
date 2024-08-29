<?php
// ดึงข้อมูลครู
$sql_teachers = "SELECT teacher_id, teacher_name FROM teachers";
$teachers_result = $conn->query($sql_teachers);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ดึงข้อมูลจากฟอร์ม
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];
    $teacher_id = $_POST['teacher_id'];
    $course_type = $_POST['course_type'];
    $course_code = $_POST['course_code'];
    $credits = $_POST['credits'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $status = 0; // ค่าเริ่มต้นของสถานะ

    // คำสั่ง SQL สำหรับเพิ่มข้อมูล
    $sql = "INSERT INTO courses (course_name, course_description, teacher_id, course_type, course_code, credits, semester, academic_year, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisssss", $course_name, $course_description, $teacher_id, $course_type, $course_code, $credits, $semester, $academic_year, $status);

    if ($stmt->execute()) {
        // // เปลี่ยนเส้นทางหลังจากเพิ่มข้อมูลสำเร็จ
        // header("Location: system.php?page=manage_courses");
        // exit();
        // echo "<script>window.location.href='system.php?page=equipment_management&status=1';</script>";
        echo "<script>window.location.href='education.php?page=Manage_courses&status=1';</script>";
    } else {
        // แสดงข้อผิดพลาดหากเกิดปัญหา
        echo "Error: " . $stmt->error;
    }
}
?>
<!-- Modal -->
<div id="courseModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">เพิ่มหลักสูตรใหม่</h2>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="course_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ชื่อหลักสูตร</label>
                <input type="text" id="course_name" name="course_name" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="course_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">คำอธิบาย</label>
                <textarea id="course_description" name="course_description" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required></textarea>
            </div>
            <div class="mb-4">
                <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ครู</label>
                <select id="teacher_id" name="teacher_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    <?php while ($teacher = $teachers_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($teacher['teacher_id']); ?>"><?php echo htmlspecialchars($teacher['teacher_name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="course_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ประเภทหลักสูตร</label>
                <select name="course_type" id="course_type" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    <option value="" disabled selected>------- เลือกประเภทหลักสูตร -------</option>
                    <option value="mandatory">บังคับ</option>
                    <option value="elective">วิชาเลือก</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="course_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">รหัสหลักสูตร</label>
                <input type="text" id="course_code" name="course_code" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="credits" class="block text-sm font-medium text-gray-700 dark:text-gray-300">หน่วยกิต</label>
                <input type="number" id="credits" name="credits" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ภาคเรียน</label>
                <input type="text" id="semester" name="semester" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="academic_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ปีการศึกษา</label>
                <input type="text" id="academic_year" name="academic_year" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">เพิ่มหลักสูตร</button>
            <button type="button" id="closeModal" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600">ปิด</button>
        </form>
    </div>
</div>