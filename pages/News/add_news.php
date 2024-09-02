<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $News_name = $_POST['News_name'];
    $News_detail = $_POST['News_detail'];
    $News_images = $_FILES['News_images']['name'];
    $News_images_tmp = $_FILES['News_images']['tmp_name'];

    if (!empty($News_images)) {
        // Generate a unique key
        $unique_key = uniqid();

        // Get the file extension
        $file_extension = pathinfo($News_images, PATHINFO_EXTENSION);

        // Create a new file name
        $new_file_name = pathinfo($News_images, PATHINFO_FILENAME) . '_' . $unique_key . '.' . $file_extension;

        // Define the upload directory
        $upload_dir = __DIR__ . '/../../uploads/News//';

        // Create the directory if it does not exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Define the path to save the uploaded file
        $file_path = $upload_dir . $new_file_name;

        // Move the uploaded file to the new location
        if (move_uploaded_file($News_images_tmp, $file_path)) {
            // Create the URL of the uploaded file
            $News_images_url = '../../uploads/News/' . $new_file_name;
        } else {
            die('Error: Failed to move uploaded file.');
        }
    } else {
        $News_images_url = '';
    }

    // Save the news data to the database
    $sql = "INSERT INTO news (News_name, News_detail, News_images) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $News_name, $News_detail, $News_images_url);

    if ($stmt->execute()) {
        echo "<script>window.location.href='?page=Manage_News&status=1';</script>";
    } else {
        // echo "Error: " . $stmt->error;
        echo "<script>window.location.href='?page=Manage_News&status=0';</script>";
    }
}
?>
<div id="newsModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
    <!-- <div class="container mx-auto p-4"> -->
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Add New News</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="News_name" class="block text-gray-700 dark:text-gray-400">News Name</label>
                <input type="text" name="News_name" id="News_name" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div class="mb-4">
                <label for="News_detail" class="block text-gray-700 dark:text-gray-400">News Detail</label>
                <textarea name="News_detail" id="News_detail" rows="4" required class="form-textarea mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
            </div>
            <div class="mb-4">
                <label for="News_images" class="block text-gray-700 dark:text-gray-400">News Image</label>
                <input type="file" name="News_images" id="News_images" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">Add News</button>
        </form>
    </div>
    <!-- </div> -->
</div>