<?php

// รับค่า student_id จากพารามิเตอร์ URL
$student_id = $_GET['id'];

// คำสั่ง SQL สำหรับดึงข้อมูลของผู้ใช้ที่ต้องการแก้ไข
$sql = "SELECT * FROM students WHERE student_id = $student_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "No record found";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $grade_level = $_POST['grade_level'];
    $section = $_POST['section'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $nicknames = $_POST['nicknames'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];

    // คำสั่ง SQL สำหรับอัพเดตข้อมูล
    $sql = "UPDATE students SET grade_level='$grade_level', section='$section', username='$username', fullname='$fullname', nicknames='$nicknames', email='$email', phone_number='$phone_number', date_of_birth='$date_of_birth', gender='$gender' WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully'); window.location.href='admin.php?page=ManageUsers';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Edit User</h1>
    <form action="" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Grade Level:</label>
            <input type="text" name="grade_level" value="<?php echo htmlspecialchars($row['grade_level']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Section:</label>
            <input type="text" name="section" value="<?php echo htmlspecialchars($row['section']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Full Name:</label>
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($row['fullname']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Nicknames:</label>
            <input type="text" name="nicknames" value="<?php echo htmlspecialchars($row['nicknames']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Phone Number:</label>
            <input type="text" name="phone_number" value="<?php echo htmlspecialchars($row['phone_number']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Date of Birth:</label>
            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Gender:</label>
            <select name="gender" class="mt-1 p-2 w-full border border-gray-300 rounded">
                <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Update User</button>
    </form>
</div>