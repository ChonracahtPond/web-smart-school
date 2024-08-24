<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $News_name = $_POST['News_name'];
    $News_detail = $_POST['News_detail'];
    $News_images = $_FILES['News_images']['name'];
    $News_images_tmp = $_FILES['News_images']['tmp_name'];

    // การอัพโหลดไฟล์ไปยัง URL
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

        // ตรวจสอบว่าการอัพโหลดสำเร็จหรือไม่
        if ($response === false) {
            die('Error: ' . curl_error($ch));
        }

        // สร้าง URL ของไฟล์ที่อัพโหลด
        $News_images_url = $url . $News_images;
    } else {
        $News_images_url = '';
    }

    // บันทึกข้อมูลลงฐานข้อมูล
    $sql = "INSERT INTO news (News_name, News_detail, News_images) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $News_name, $News_detail, $News_images_url);

    if ($stmt->execute()) {
        echo "<script>alert('News added successfully'); window.location.href='system.php?page=Manage_News';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Add New News</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <form method="POST" action="system.php?page=add_news" enctype="multipart/form-data">
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
</div>