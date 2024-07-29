<?php
$New_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($New_id > 0) {
    $sql_img = "SELECT News_images FROM news WHERE New_id = ?";
    $stmt_img = $conn->prepare($sql_img);
    $stmt_img->bind_param('i', $New_id);
    $stmt_img->execute();
    $img_result = $stmt_img->get_result();
    $img_row = $img_result->fetch_assoc();
    $News_images = $img_row['News_images'];

    $sql = "DELETE FROM news WHERE New_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $New_id);

    if ($stmt->execute()) {
        // ลบไฟล์ภาพ
        if (!empty($News_images) && file_exists("uploads/" . $News_images)) {
            unlink("uploads/" . $News_images);
        }
        echo "<script>alert('News deleted successfully'); window.location.href='admin.php?page=Manage_News';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "<script>alert('Invalid news ID'); window.location.href='admin.php?page=manage_news';</script>";
}
