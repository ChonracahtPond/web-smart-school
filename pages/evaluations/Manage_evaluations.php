<?php

// ดึงข้อมูลจากตาราง evaluations
$sql = "SELECT * FROM evaluations";
$result = $conn->query($sql);

// ตรวจสอบการเพิ่ม, แก้ไข, และลบข้อมูล
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // ลบการประเมินผล
        $evaluation_id = $_POST['delete'];
        $delete_sql = "DELETE FROM evaluations WHERE evaluation_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param('i', $evaluation_id);
        $stmt->execute();
        $stmt->close();
        header('Location: Manage_evaluations.php'); // รีเฟรชหน้า
        exit();
    } elseif (isset($_POST['add'])) {
        // เพิ่มการประเมินผล
        $evaluation_name = $_POST['evaluation_name'];
        $description = $_POST['description'];
        $insert_sql = "INSERT INTO evaluations (evaluation_name, description) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param('ss', $evaluation_name, $description);
        $stmt->execute();
        $stmt->close();
        header('Location: Manage_evaluations.php'); // รีเฟรชหน้า
        exit();
    }
}
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Manage Evaluations</h1>

    <!-- Form to add new evaluation -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Add New Evaluation</h2>
        <form action="Manage_evaluations.php" method="POST">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="evaluation_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Evaluation Name</label>
                    <input type="text" id="evaluation_name" name="evaluation_name" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></textarea>
                </div>
            </div>
            <button type="submit" name="add" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Evaluation</button>
        </form>
    </div>

    <!-- Table of evaluations -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 px-6 py-4">List of Evaluations</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluation Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['evaluation_id']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['evaluation_name']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars($row['description']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                <!-- Edit and Delete Buttons -->
                                <form action="Manage_evaluations.php" method="POST" class="inline-block">
                                    <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row['evaluation_id']); ?>">
                                    <button type="submit" name="edit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">Edit</button>
                                </form>
                                <form action="Manage_evaluations.php" method="POST" class="inline-block ml-2">
                                    <input type="hidden" name="delete" value="<?php echo htmlspecialchars($row['evaluation_id']); ?>">
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>