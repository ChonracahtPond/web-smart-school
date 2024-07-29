<?php


// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง activities
$sql = "SELECT activity_id, activity_name, description, activity_Credits,activity_hour, start_date, end_date, location, created_at, updated_at FROM activities";
$result = $conn->query($sql);
?>


<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Manage Activities</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <a href="admin.php?page=add_activity" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 inline-block">Add New Activity</a>
        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">Activity ID</th>
                    <th class="px-4 py-2 border-b">Activity Name</th>
                    <th class="px-4 py-2 border-b">Description</th>
                    <th class="px-4 py-2 border-b">activity_hour</th>
                    <th class="px-4 py-2 border-b">Credits</th>
                    <th class="px-4 py-2 border-b">Start Date</th>
                    <th class="px-4 py-2 border-b">End Date</th>
                    <th class="px-4 py-2 border-b">Location</th>
                    <th class="px-4 py-2 border-b">Created At</th>
                    <th class="px-4 py-2 border-b">Updated At</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['description']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_hour']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['activity_Credits']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['start_date']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['end_date']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['location']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['updated_at']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <a href="admin.php?page=edit_activity&id=<?php echo htmlspecialchars($row['activity_id']); ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                                |
                                <a href="admin.php?page=delete_activity&id=<?php echo htmlspecialchars($row['activity_id']); ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this activity?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="px-4 py-2 text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>