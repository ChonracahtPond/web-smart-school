<?php
$New_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $News_name = $_POST['News_name'];
    $News_detail = $_POST['News_detail'];
    $News_images = $_FILES['News_images']['name'];
    $News_images_tmp = $_FILES['News_images']['tmp_name'];

    if (!empty($News_images)) {
        $url = 'https://challgroup.net/api_app_mobile/assets/images/News/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'file' => new CURLFile($News_images_tmp, $_FILES['News_images']['type'], $News_images)
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            die('Error: ' . curl_error($ch));
        }

        $News_images_url = $url . $News_images;
    } else {
        $sql_img = "SELECT News_images FROM news WHERE New_id = ?";
        $stmt_img = $conn->prepare($sql_img);
        $stmt_img->bind_param('i', $New_id);
        $stmt_img->execute();
        $img_result = $stmt_img->get_result();
        $img_row = $img_result->fetch_assoc();
        $News_images_url = $img_row['News_images'];
    }

    $sql = "UPDATE news SET News_name = ?, News_detail = ?, News_images = ? WHERE New_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $News_name, $News_detail, $News_images_url, $New_id);

    if ($stmt->execute()) {
        echo "<script>alert('News updated successfully'); window.location.href='admin.php?page=Manage_News';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$sql_news = "SELECT * FROM news WHERE New_id = ?";
$stmt = $conn->prepare($sql_news);
$stmt->bind_param('i', $New_id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Edit News</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <form method="POST" action="admin.php?page=edit_news&id=<?php echo htmlspecialchars($New_id); ?>" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="News_name" class="block text-gray-700 dark:text-gray-400">News Name</label>
                <input type="text" name="News_name" id="News_name" value="<?php echo htmlspecialchars($news['News_name']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="News_detail" class="block text-gray-700 dark:text-gray-400">News Detail</label>
                <textarea name="News_detail" id="News_detail" rows="4" required class="form-textarea mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"><?php echo htmlspecialchars($news['News_detail']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="News_images" class="block text-gray-700 dark:text-gray-400">News Image</label>
                <input type="file" name="News_images" id="News_images" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <?php if (!empty($news['News_images'])) : ?>
                    <img src="<?php echo htmlspecialchars($news['News_images']); ?>" alt="News Image" class="w-32 h-auto mt-2">
                <?php endif; ?>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Update News</button>
        </form>
    </div>
</div>