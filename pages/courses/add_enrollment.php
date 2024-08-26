<?php
// รวม modal.php
include 'modal.php';

// ดึงข้อมูลจากตาราง courses
$sql_courses = "SELECT course_id, course_name FROM courses";
$result_courses = $conn->query($sql_courses);

// ดึงข้อมูลจากตาราง students
$sql_students = "SELECT student_id, student_name FROM students";
$result_students = $conn->query($sql_students);

// ดึงข้อมูลจากตาราง teachers
$sql_teachers = "SELECT teacher_id, teacher_name FROM teachers";
$result_teachers = $conn->query($sql_teachers);

$echo_value = null; // กำหนดค่าเริ่มต้นให้กับตัวแปร

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $grade = $_POST['grade'];
    $status = $_POST['status'];
    $teacher_id = $_POST['teacher_id'];

    $sql = "INSERT INTO enrollments (student_id, course_id, semester, academic_year, grade, status, teacher_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('iissdii', $student_id, $course_id, $semester, $academic_year, $grade, $status, $teacher_id);

        if ($stmt->execute()) {
            $echo_value = 1; // Success
        } else {
            $echo_value = 0; // Failure
        }

        $stmt->close();
    } else {
        $echo_value = 0; // Failure due to prepare error
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Enrollment</title>
    <!-- Include Tailwind CSS or any other styling library here -->
</head>

<body>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Add New Enrollment</h1>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="student_id" class="block text-gray-700 dark:text-gray-400">Student</label>
                    <select name="student_id" id="student_id" required class="form-select mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">Select Student</option>
                        <?php while ($row = $result_students->fetch_assoc()) : ?>
                            <option value="<?php echo htmlspecialchars($row['student_id']); ?>">
                                <?php echo htmlspecialchars($row['student_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="course_id" class="block text-gray-700 dark:text-gray-400">Course</label>
                    <select name="course_id" id="course_id" required class="form-select mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">Select Course</option>
                        <?php while ($row = $result_courses->fetch_assoc()) : ?>
                            <option value="<?php echo htmlspecialchars($row['course_id']); ?>">
                                <?php echo htmlspecialchars($row['course_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="semester" class="block text-gray-700 dark:text-gray-400">Semester</label>
                    <input type="text" name="semester" id="semester" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="academic_year" class="block text-gray-700 dark:text-gray-400">Academic Year</label>
                    <input type="text" name="academic_year" id="academic_year" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="grade" class="block text-gray-700 dark:text-gray-400">Grade</label>
                    <input type="number" step="0.01" name="grade" id="grade" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 dark:text-gray-400">Status</label>
                    <input type="text" name="status" id="status" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="teacher_id" class="block text-gray-700 dark:text-gray-400">Teacher</label>
                    <select name="teacher_id" id="teacher_id" required class="form-select mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <option value="">Select Teacher</option>
                        <?php while ($row = $result_teachers->fetch_assoc()) : ?>
                            <option value="<?php echo htmlspecialchars($row['teacher_id']); ?>">
                                <?php echo htmlspecialchars($row['teacher_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Add Enrollment</button>
            </form>
        </div>
    </div>

    <!-- Include modal.php -->
    <?php include 'modal.php'; ?>
</body>

</html>