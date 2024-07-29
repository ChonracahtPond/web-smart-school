<?php

// ดึงข้อมูลข่าวสารทั้งหมด
$sql_news = "SELECT New_id , News_name, News_detail, News_images FROM news";
$result_news = $conn->query($sql_news);
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Manage News</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <a href="admin.php?page=add_news" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 mb-4 inline-block">Add New News</a>

        <!-- ฟอร์มค้นหา -->
        <form method="GET" action="" class="mb-4">
            <div class="flex items-center">
                <input type="text" name="search" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Search by news name">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600 ml-2">Search</button>
            </div>
        </form>

        <table class="w-full mt-4 border-collapse">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <th class="px-4 py-2 border-b">News ID</th>
                    <th class="px-4 py-2 border-b">News Name</th>
                    <th class="px-4 py-2 border-b">News Detail</th>
                    <th class="px-4 py-2 border-b">News Image</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_news->num_rows > 0) : ?>
                    <?php while ($row = $result_news->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['New_id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['News_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['News_detail']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <?php if (!empty($row['News_images'])) : ?>
                                    <img src="<?php echo htmlspecialchars($row['News_images']); ?>" alt="News Image" class="w-32 h-auto">
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 border-b">
                                <a href="admin.php?page=edit_news&id=<?php echo htmlspecialchars($row['New_id']); ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                                |
                                <a href="admin.php?page=delete_news&id=<?php echo htmlspecialchars($row['New_id']); ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this news?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No news found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>