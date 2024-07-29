<?php

// ตรวจสอบว่ามีการส่งคำค้นหามาหรือไม่
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง courses พร้อมการค้นหา
$sql = "SELECT c.course_id, c.course_name, c.course_description, c.teacher_id, c.course_type, c.course_code, c.credits, c.semester, c.academic_year, c.status, t.teacher_name
        FROM courses c
        LEFT JOIN teachers t ON c.teacher_id = t.teacher_id
        WHERE c.course_name LIKE ? OR c.course_description LIKE ? OR t.teacher_name LIKE ?";

// เตรียมการค้นหาข้อมูล
$searchTerm = "%$search%";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Manage Courses</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <a href="admin.php?page=add_course" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 inline-block">Add New Course</a>

        <!-- ฟอร์มค้นหา -->
        <form method="GET" action="" class="mb-4">
            <div class="flex items-center">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Search by course name, description, or teacher">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 ml-2">Search</button>
            </div>
        </form>

        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">Course ID</th>
                    <th class="px-4 py-2 border-b">Course Name</th>
                    <th class="px-4 py-2 border-b">Description</th>
                    <th class="px-4 py-2 border-b">Teacher</th>
                    <th class="px-4 py-2 border-b">Type</th>
                    <th class="px-4 py-2 border-b">Course Code</th>
                    <th class="px-4 py-2 border-b">Credits</th>
                    <th class="px-4 py-2 border-b">Semester</th>
                    <th class="px-4 py-2 border-b">Academic Year</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['course_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['course_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['course_description']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <?php
                                // แสดงประเภทหลักสูตร
                                $course_type = htmlspecialchars($row['course_type']);
                                echo ($course_type === 'mandatory') ? 'Mandatory' : 'Elective';
                                ?>
                            </td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['course_code']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['credits']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['academic_year']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <?php echo htmlspecialchars($row['status']) == 1 ? 'Active' : 'Inactive'; ?>
                            </td>
                            <td class="px-4 py-2 border-b">
                                <a href="admin.php?page=edit_course&id=<?php echo htmlspecialchars($row['course_id']); ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                                |
                                <a href="admin.php?page=delete_course&id=<?php echo htmlspecialchars($row['course_id']); ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
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