<?php

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

    // คำสั่ง SQL สำหรับเพิ่มข้อมูลใหม่
    $sql = "INSERT INTO students (grade_level, section, username, fullname, nicknames, email, phone_number, date_of_birth, gender)
            VALUES ('$grade_level', '$section', '$username', '$fullname', '$nicknames', '$email', '$phone_number', '$date_of_birth', '$gender')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully'); window.location.href='admin.php?page=ManageUsers';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">เพิ่มข้อมูลนักเรียน</h1>
    <form action="" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Grade Level:</label>
            <input type="text" name="grade_level" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Section:</label>
            <input type="text" name="section" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Username:</label>
            <input type="text" name="username" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Full Name:</label>
            <input type="text" name="fullname" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Nicknames:</label>
            <input type="text" name="nicknames" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Email:</label>
            <input type="email" name="email" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Phone Number:</label>
            <input type="text" name="phone_number" class="mt-1 p-2 w-full border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Date of Birth:</label>
            <input type="date" name="date_of_birth" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300">Gender:</label>
            <select name="gender" class="mt-1 p-2 w-full border border-gray-300 rounded">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Add User</button>
    </form>
</div>