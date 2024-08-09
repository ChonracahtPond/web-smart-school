<?php

// Fetch news items
$sql = "SELECT New_id, News_name, News_detail, News_images FROM news";
$result = $conn->query($sql);

$newsItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $newsItems[] = $row;
    }
}

?>

<!-- This is an example component -->

<div class="w-[500px] max-w-2xl mx-auto md:py-24">
    <div class="font-bold text-gray-800 text-xl mb-4">
        ข่าวสารและกิจกรรม
    </div>
    <div class="p-4 max-w-xl bg-gray-50 rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">ข่าวสารภายใน</h3>
            <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                View all
            </a>
        </div>
        <div class="bg-gray-200 w-[100px] h-0.5"></div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php foreach ($newsItems as $news): ?>
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" src="<?php echo htmlspecialchars($news['News_images']); ?>" alt="<?php echo htmlspecialchars($news['News_name']); ?>">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    <?php echo htmlspecialchars($news['News_name']); ?>
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    <?php echo htmlspecialchars($news['News_detail']); ?>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>