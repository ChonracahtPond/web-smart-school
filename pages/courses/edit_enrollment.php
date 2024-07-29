<?php

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $grade = $_POST['grade'];
    $status = $_POST['status'];
    $teacher_id = $_POST['teacher_id'];

    $sql = "UPDATE enrollments SET student_id = ?, course_id = ?, semester = ?, academic_year = ?, grade = ?, status = ?, teacher_id = ? WHERE enrollment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iissdiii', $student_id, $course_id, $semester, $academic_year, $grade, $status, $teacher_id, $id);

    if ($stmt->execute()) {
        echo "<script>alert('courses update successfully'); window.location.href='admin.php?page=Manage_enrollments';</script>";
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
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Edit Enrollment</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <form method="POST" action="admin.php?page=edit_enrollment&id=<?php echo htmlspecialchars($id); ?>">
            <div class="mb-4">
                <label for="student_id" class="block text-gray-700 dark:text-gray-400">Student ID</label>
                <input type="number" name="student_id" id="student_id" value="<?php echo htmlspecialchars($row['student_id']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="course_id" class="block text-gray-700 dark:text-gray-400">Course ID</label>
                <input type="number" name="course_id" id="course_id" value="<?php echo htmlspecialchars($row['course_id']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="semester" class="block text-gray-700 dark:text-gray-400">Semester</label>
                <input type="text" name="semester" id="semester" value="<?php echo htmlspecialchars($row['semester']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="academic_year" class="block text-gray-700 dark:text-gray-400">Academic Year</label>
                <input type="text" name="academic_year" id="academic_year" value="<?php echo htmlspecialchars($row['academic_year']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="grade" class="block text-gray-700 dark:text-gray-400">Grade</label>
                <input type="number" step="0.01" name="grade" id="grade" value="<?php echo htmlspecialchars($row['grade']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="status" class="block text-gray-700 dark:text-gray-400">Status</label>
                <input type="text" name="status" id="status" value="<?php echo htmlspecialchars($row['status']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="teacher_id" class="block text-gray-700 dark:text-gray-400">Teacher ID</label>
                <input type="number" name="teacher_id" id="teacher_id" value="<?php echo htmlspecialchars($row['teacher_id']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Update Enrollment</button>
        </form>
    </div>
</div>
