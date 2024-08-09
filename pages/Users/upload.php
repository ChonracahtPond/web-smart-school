<?php
// ตรวจสอบว่าการร้องขอเป็น POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ตรวจสอบว่าไฟล์ถูกส่งมาหรือไม่
    if (isset($_FILES['file_images']) && $_FILES['file_images']['error'] == 0) {
        // กำหนดไดเร็กทอรีสำหรับอัพโหลด
        $uploadDir = '../uploads/';

        // ตรวจสอบว่าไดเร็กทอรีสำหรับอัพโหลดมีอยู่แล้วหรือไม่
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // กำหนดชื่อไฟล์ที่อัพโหลด
        $fileName = basename($_FILES['file_images']['name']);
        $uploadFile = $uploadDir . $fileName;

        // ตรวจสอบประเภทไฟล์ (ให้แน่ใจว่าเป็นไฟล์ภาพ)
        $fileType = mime_content_type($_FILES['file_images']['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fileType, $allowedTypes)) {
            // ย้ายไฟล์จากชั่วคราวไปยังไดเร็กทอรีที่ต้องการ
            if (move_uploaded_file($_FILES['file_images']['tmp_name'], $uploadFile)) {
                echo "ไฟล์ '$fileName' ถูกอัพโหลดเรียบร้อยแล้ว.";
            } else {
                echo "เกิดข้อผิดพลาดในการอัพโหลดไฟล์.";
            }
        } else {
            echo "ประเภทไฟล์ไม่อนุญาต.";
        }
    } else {
        echo "ไม่พบไฟล์ที่อัพโหลดหรือเกิดข้อผิดพลาดในการอัพโหลด.";
    }
} else {
    echo "การร้องขอไม่ถูกต้อง.";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Upload Image</title>
    <script>
        function confirmUpload() {
            return confirm("คุณต้องการอัพโหลดไฟล์นี้หรือไม่?");
        }
    </script>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data" onsubmit="return confirmUpload();">
        <input type="file" name="file_images" required>
        <input type="submit" value="Upload Image">
    </form>
</body>

</html>
