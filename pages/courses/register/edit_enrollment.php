<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $status = $_POST['status'];
    $teacher_id = $_POST['teacher_id'];

    $sql = "UPDATE enrollments SET student_id = ?, course_id = ?, semester = ?, academic_year = ?, status = ?, teacher_id = ? WHERE enrollment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iisssii', $student_id, $course_id, $semester, $academic_year, $status, $teacher_id, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Enrollment updated successfully'); window.location.href='?page=Manage_enrollments';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$sql = "SELECT * FROM enrollments WHERE enrollment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Fetch students for dropdown
$students_result = $conn->query("SELECT student_id, fullname FROM students");

// Fetch courses for dropdown
$courses_result = $conn->query("SELECT course_id, CONCAT(course_name, ' (', course_code, ')') AS course_info FROM courses");

// Fetch teachers for dropdown
$teachers_result = $conn->query("SELECT teacher_id, teacher_name FROM teachers");
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">แก้ไขการลงทะเบียน</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <form method="POST" action="?page=edit_enrollment&id=<?php echo htmlspecialchars($id); ?>">
            <div class="mb-4">
                <label for="student_id" class="block text-gray-700 dark:text-gray-400">ชื่อผู้ลงทะเบียน</label>
                <select name="student_id" id="student_id" required class="form-select mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <?php while ($student = $students_result->fetch_assoc()): ?>
                        <option value="<?php echo $student['student_id']; ?>" <?php if ($student['student_id'] == $row['student_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($student['fullname']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="course_id" class="block text-gray-700 dark:text-gray-400">ชื่อรายวิชา</label>
                <select name="course_id" id="course_id" required class="form-select mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <?php while ($course = $courses_result->fetch_assoc()): ?>
                        <option value="<?php echo $course['course_id']; ?>" <?php if ($course['course_id'] == $row['course_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($course['course_info']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="semester" class="block text-gray-700 dark:text-gray-400">เทอม</label>
                <input type="text" name="semester" id="semester" value="<?php echo htmlspecialchars($row['semester']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="academic_year" class="block text-gray-700 dark:text-gray-400">ปีการศึกษา</label>
                <input type="text" name="academic_year" id="academic_year" value="<?php echo htmlspecialchars($row['academic_year']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 dark:text-gray-400">สถานะ</label>
                <input type="text" name="status" id="status" value="<?php echo htmlspecialchars($row['status']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="teacher_id" class="block text-gray-700 dark:text-gray-400">ชื่อครู</label>
                <select name="teacher_id" id="teacher_id" required class="form-select mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <?php while ($teacher = $teachers_result->fetch_assoc()): ?>
                        <option value="<?php echo $teacher['teacher_id']; ?>" <?php if ($teacher['teacher_id'] == $row['teacher_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($teacher['teacher_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">อัปเดตข้อมูล</button>
        </form>
    </div>
</div>