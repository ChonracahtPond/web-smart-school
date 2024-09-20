<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ตรวจสอบว่าฟอร์มถูกส่งหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $evaluation_name = trim($_POST['evaluation_name']);
    $evaluation_date = trim($_POST['evaluation_date']);
    $evaluation_score = floatval($_POST['evaluation_score']);
    $comments = trim($_POST['comments']);
    $google_form_link = trim($_POST['google_form_link']);

    // อัปเดตข้อมูลการประเมินผล
    $sql = "UPDATE evaluations SET evaluation_name = ?, evaluation_date = ?, evaluation_score = ?, comments = ?, google_form_link = ? WHERE evaluation_id = ?";
    $stmt = $conn->prepare($sql);
    // bind_param ต้องการให้ประเภทข้อมูลสำหรับ google_form_link เป็น 's'
    $stmt->bind_param('ssdsss', $evaluation_name, $evaluation_date, $evaluation_score, $comments, $google_form_link, $id);

    if ($stmt->execute()) {
        echo "<script> window.location.href='?page=Evaluation_management&status=1';</script>";
    } else {
        echo "Error: " . $stmt->error;
        echo "<script> window.location.href='?page=Evaluation_management&status=0';</script>";
    }
}

// ดึงข้อมูลการประเมินจากฐานข้อมูล
$sql = "SELECT * FROM evaluations WHERE evaluation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">แก้ไขการประเมินผล</h1>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4 mt-4">
        <form method="POST" action="?page=edit_Evaluation&id=<?php echo htmlspecialchars($id); ?>">

            <!-- ฟิลด์สำหรับกรอกชื่อการประเมินผล -->
            <div class="mb-4">
                <label for="evaluation_name" class="block text-gray-700 dark:text-gray-400">ชื่อการประเมิน</label>
                <input type="text" name="evaluation_name" id="evaluation_name" value="<?php echo htmlspecialchars($row['evaluation_name']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <!-- ฟิลด์สำหรับกรอกวันที่ประเมิน -->
            <div class="mb-4">
                <label for="evaluation_date" class="block text-gray-700 dark:text-gray-400">วันที่ประเมิน</label>
                <input type="date" name="evaluation_date" id="evaluation_date" value="<?php echo htmlspecialchars($row['evaluation_date']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <!-- ฟิลด์สำหรับกรอกคะแนนการประเมิน -->
            <div class="mb-4">
                <label for="evaluation_score" class="block text-gray-700 dark:text-gray-400">คะแนนการประเมิน</label>
                <input type="number" step="0.01" name="evaluation_score" id="evaluation_score" value="<?php echo htmlspecialchars($row['evaluation_score']); ?>" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <!-- ฟิลด์สำหรับกรอกความคิดเห็น -->
            <div class="mb-4">
                <label for="comments" class="block text-gray-700 dark:text-gray-400">ความคิดเห็น</label>
                <textarea name="comments" id="comments" rows="4" required class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"><?php echo htmlspecialchars($row['comments']); ?></textarea>
            </div>

            <!-- ฟิลด์สำหรับกรอกลิงก์ Google Form -->
            <div class="mb-4">
                <label for="google_form_link" class="block text-gray-700 dark:text-gray-400">ลิงก์ Google Form</label>
                <input type="text" name="google_form_link" id="google_form_link" value="<?php echo htmlspecialchars($row['google_form_link']); ?>" class="form-input mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-600">อัปเดตข้อมูล</button>
        </form>
    </div>
</div>