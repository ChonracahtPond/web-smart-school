<?php

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $student_id = $_POST['student_id'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT); // เข้ารหัสรหัสผ่านใหม่

    // คำสั่ง SQL สำหรับอัพเดตรหัสผ่าน
    $sql = "UPDATE students SET password='$new_password' WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Password reset successfully'); window.location.href='manage_users.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// คำสั่ง SQL สำหรับดึงข้อมูลผู้ใช้จากตาราง students
$students_sql = "SELECT student_id, fullname FROM students";
$students_result = $conn->query($students_sql);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Reset Password</h1>
    <form action="reset_password.php" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Student:</label>
            <select name="student_id" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                <?php while ($student = $students_result->fetch_assoc()) : ?>
                    <option value="<?php echo htmlspecialchars($student['student_id']); ?>">
                        <?php echo htmlspecialchars($student['fullname']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">New Password:</label>
            <input type="password" name="new_password" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Reset Password</button>
    </form>
</div>
</body>