<?php

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง access_rights
$sql = "SELECT status, student_id, role FROM access_rights";
$result = $conn->query($sql);

// คำสั่ง SQL สำหรับดึงข้อมูลผู้ใช้จากตาราง students
$students_sql = "SELECT student_id, fullname FROM students";
$students_result = $conn->query($students_sql);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Manage Access Rights</h1>

    <!-- ปุ่มเพิ่ม -->
    <a href="admin.php?page=add_access_right" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Add New Access Right</a>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">Access ID</th>
                    <th class="px-4 py-2 border-b">Student ID</th>
                    <th class="px-4 py-2 border-b">Full Name</th>
                    <th class="px-4 py-2 border-b">Role</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <?php
                                // หาชื่อเต็มของผู้ใช้
                                $student_name_query = "SELECT fullname FROM students WHERE student_id = " . $row['student_id'];
                                $student_name_result = $conn->query($student_name_query);
                                $student_name = $student_name_result->fetch_assoc();
                                echo htmlspecialchars($student_name['fullname']);
                                ?>
                            </td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['role']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <!-- ปุ่มแก้ไข -->
                                <a href="edit_access_right.php?id=<?php echo htmlspecialchars($row['status']); ?>" class="text-blue-500 hover:underline">Edit</a> |
                                <!-- ปุ่มลบ -->
                                <a href="delete_access_right.php?id=<?php echo htmlspecialchars($row['status']); ?>" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this access right?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>