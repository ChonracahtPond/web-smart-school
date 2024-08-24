<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $student_id = $_POST['student_id'];
    $role = $_POST['role'];

    // คำสั่ง SQL สำหรับเพิ่มข้อมูลใหม่
    $sql = "INSERT INTO access_rights (student_id, role) VALUES ('$student_id', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New access right added successfully'); window.location.href='system.php?page=manage_access_rights';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// คำสั่ง SQL สำหรับดึงข้อมูลผู้ใช้จากตาราง students
$students_sql = "SELECT student_id, fullname FROM students";
$students_result = $conn->query($students_sql);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Add New Access Right</h1>
    <form action="add_access_right.php" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">นักเรียน:</label>
            <select name="student_id" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                <?php while ($student = $students_result->fetch_assoc()) : ?>
                    <option value="<?php echo htmlspecialchars($student['student_id']); ?>">
                        <?php echo htmlspecialchars($student['fullname']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Role:</label>
            <input type="text" name="role" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Add Access Right</button>
    </form>
</div>