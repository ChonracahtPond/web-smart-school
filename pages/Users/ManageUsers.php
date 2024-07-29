<?php
// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง students
$sql = "SELECT student_id, grade_level, section, username, fullname, nicknames, email, phone_number, date_of_birth, gender FROM students";
$result = $conn->query($sql);
?>

<div class="container mx-auto ">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-10">ข้อมูลนักเรียน</h1>

    <!-- ปุ่มเพิ่ม -->
    <a href="admin.php?page=add_user" class="bg-blue-500  text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">เพิ่มข้อมูลนักเรียน</a>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 my-4 ">
        <table class="w-full mt-4 border-collapse ">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">Student ID</th>
                    <th class="px-4 py-2 border-b">Grade Level</th>
                    <th class="px-4 py-2 border-b">Section</th>
                    <th class="px-4 py-2 border-b">Username</th>
                    <th class="px-4 py-2 border-b">Full Name</th>
                    <th class="px-4 py-2 border-b">Nicknames</th>
                    <th class="px-4 py-2 border-b">Email</th>
                    <th class="px-4 py-2 border-b">Phone Number</th>
                    <th class="px-4 py-2 border-b">Date of Birth</th>
                    <th class="px-4 py-2 border-b">Gender</th>
                    <th class="px-4 py-2 border-b">Actions</th> <!-- คอลัมน์สำหรับปุ่มแก้ไขและลบ -->
                </tr>
            </thead>
            <tbody class=" w-screen mt-5">
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="mt-5 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['grade_level']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['section']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['username']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['nicknames']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['phone_number']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <!-- ปุ่มแก้ไข -->
                                <a href="admin.php?page=edit_user&id=<?php echo htmlspecialchars($row['student_id']); ?>" class="text-blue-500 hover:underline">Edit</a> |
                                <!-- ปุ่มลบ -->
                                <a href="admin.php?page=delete_user&id=<?php echo htmlspecialchars($row['student_id']); ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="11" class="px-4 py-2 text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>