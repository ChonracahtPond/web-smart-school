<?php

// ดึงข้อมูลครู
$sql_teachers = "SELECT teacher_id, teacher_name FROM teachers";
$teachers_result = $conn->query($sql_teachers);

// ดึงข้อมูลหลักสูตรที่ต้องการแก้ไข
$course_result = [];
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // ดึงข้อมูลหลักสูตรที่ต้องการแก้ไข
    $sql = "SELECT * FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $course_result = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];
    $teacher_id = $_POST['teacher_id'];
    $course_type = $_POST['course_type'];
    $course_code = $_POST['course_code'];
    $credits = $_POST['credits'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $status = $_POST['status'];

    // คำสั่ง SQL สำหรับอัพเดตข้อมูล
    $sql = "UPDATE courses SET course_name = ?, course_description = ?, teacher_id = ?, course_type = ?, course_code = ?, credits = ?, semester = ?, academic_year = ?, status = ? WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisssssi", $course_name, $course_description, $teacher_id, $course_type, $course_code, $credits, $semester, $academic_year, $status, $course_id);

    if ($stmt->execute()) {
        // เปลี่ยนเส้นทางหลังจากอัพเดตข้อมูลสำเร็จ
        echo "<script>alert('courses update successfully'); window.location.href='system.php?page=Manage_courses';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Edit Course</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <form method="POST" action="">
            <div class="mb-4">
                <label for="course_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Name</label>
                <input type="text" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course_result['course_name']); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="course_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea id="course_description" name="course_description" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required><?php echo htmlspecialchars($course_result['course_description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teacher</label>
                <select id="teacher_id" name="teacher_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    <?php while ($teacher = $teachers_result->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($teacher['teacher_id']); ?>" <?php echo ($teacher['teacher_id'] == $course_result['teacher_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($teacher['teacher_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="course_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Type</label>
                <select name="course_type" id="course_type" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    <option value="mandatory" <?php echo ($course_result['course_type'] == 'mandatory') ? 'selected' : ''; ?>>Mandatory</option>
                    <option value="elective" <?php echo ($course_result['course_type'] == 'elective') ? 'selected' : ''; ?>>Elective</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="course_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Course Code</label>
                <input type="text" id="course_code" name="course_code" value="<?php echo htmlspecialchars($course_result['course_code']); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="credits" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Credits</label>
                <input type="number" id="credits" name="credits" value="<?php echo htmlspecialchars($course_result['credits']); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Semester</label>
                <input type="text" id="semester" name="semester" value="<?php echo htmlspecialchars($course_result['semester']); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="academic_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Academic Year</label>
                <input type="text" id="academic_year" name="academic_year" value="<?php echo htmlspecialchars($course_result['academic_year']); ?>" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    <option value="0" <?php echo ($course_result['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                    <option value="1" <?php echo ($course_result['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Update Course</button>
        </form>
    </div>
</div>