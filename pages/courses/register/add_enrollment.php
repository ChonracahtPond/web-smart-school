<?php

// ดึงข้อมูลจากตาราง courses
$sql_courses = "SELECT course_id, course_name FROM courses";
$result_courses = $conn->query($sql_courses);

// ดึงข้อมูลจากตาราง students
$sql_students = "SELECT student_id, student_name FROM students";
$result_students = $conn->query($sql_students);

$echo_value = null; // กำหนดค่าเริ่มต้นให้กับตัวแปร

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_ids = $_POST['course_id']; // เปลี่ยนชื่อเป็น course_ids เป็น array
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];

    // Prepare the SQL statement for multiple courses
    $sql = "INSERT INTO enrollments (student_id, course_id, semester, academic_year) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameters in a loop
        foreach ($course_ids as $course_id) {
            $stmt->bind_param('iiss', $student_id, $course_id, $semester, $academic_year);
            if (!$stmt->execute()) {
                $echo_value = 0; // Failure
                break;
            }
        }

        if ($echo_value !== 0) {
            $echo_value = 1; // Success
        }

        $stmt->close();
    } else {
        $echo_value = 0; // Failure due to prepare error
    }

    $conn->close();
}
?>

<div id="myModaladdEnrollment" class="modal fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 w-full max-w-md mx-auto mt-20">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">เพิ่มการลงทะเบียนใหม่</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="student_id" class="block text-gray-700 dark:text-gray-400">นักเรียน</label>
                <select name="student_id" id="student_id" required class="form-select mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="">เลือกนักเรียน</option>
                    <?php while ($row = $result_students->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($row['student_id']); ?>">
                            <?php echo htmlspecialchars($row['student_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="course_id" class="block text-gray-700 dark:text-gray-400">รายวิชา</label>
                <select name="course_id[]" id="course_id" multiple required class="form-select mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <?php while ($row = $result_courses->fetch_assoc()) : ?>
                        <option value="<?php echo htmlspecialchars($row['course_id']); ?>">
                            <?php echo htmlspecialchars($row['course_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="semester" class="block text-gray-700 dark:text-gray-400">เทอม</label>
                <input type="text" name="semester" id="semester" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="academic_year" class="block text-gray-700 dark:text-gray-400">ปีการศึกษา</label>
                <input type="text" name="academic_year" id="academic_year" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">เพิ่มการลงทะเบียน</button>
            <button type="button" id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-gray-600 ml-2">ปิด</button>
        </form>
    </div>
</div>

<script>
    // JavaScript สำหรับเปิดและปิด Modal
    document.getElementById('openModal').addEventListener('click', function() {
        document.getElementById('myModaladdEnrollment').classList.remove('hidden');
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('myModaladdEnrollment').classList.add('hidden');
    });
</script>