<?php

// ดึงข้อมูลจากตาราง students
$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Students List</h1>

    <!-- Table of students -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4">List of Students</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nicknames</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" onclick="window.location.href='?page=student_details&id=<?php echo urlencode($row['student_id']); ?>'">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['student_id']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['grade_level']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['section']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['username']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['fullname']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['nicknames']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['phone_number']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                <?php if ($row['file_images']) : ?>
                                    <img src="<?php echo htmlspecialchars($row['file_images']); ?>" alt="Student Image" class="w-16 h-16 object-cover rounded-full">
                                <?php else : ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['student_name']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>