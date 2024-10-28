<?php

// ตรวจสอบว่ามีการส่งข้อมูล POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $lesson_id = isset($_POST['lesson_id']) ? intval($_POST['lesson_id']) : 0;
    $meeting_link = isset($_POST['meeting_link']) ? trim($_POST['meeting_link']) : '';
    $meeting_date = isset($_POST['meeting_date']) ? $_POST['meeting_date'] : '';
    $meeting_time = isset($_POST['meeting_time']) ? $_POST['meeting_time'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : 'active';

    // ตรวจสอบและปรับค่า meeting_link
    $youtube_prefix = "https://www.youtube.com/watch?v=";
    if (strpos($meeting_link, $youtube_prefix) === 0) {
        $meeting_link = str_replace($youtube_prefix, '', $meeting_link);
    }

    // ตรวจสอบค่าที่ได้รับ
    if (empty($meeting_link) || empty($meeting_date) || empty($meeting_time)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');</script>";
    } else {
        // เตรียม SQL statement
        $stmt = $conn->prepare("INSERT INTO online_meetings (lesson_id, meeting_link, meeting_date, meeting_time, status) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("issss", $lesson_id, $meeting_link, $meeting_date, $meeting_time, $status);

            // ประมวลผล SQL statement
            if ($stmt->execute()) {
                echo "<script>window.location.href='?page=lesson_detail&id=$lesson_id&status=1';</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาด: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการเตรียม SQL: " . $conn->error . "');</script>";
        }
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มแบบฝึกหัด</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <button onclick="closeModal()" class="float-right text-gray-500 hover:text-gray-700">×</button>

    <!-- Modal -->
    <div class="bg-white max-w-md w-full mx-auto p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-purple-700 mb-6 text-center">เพิ่มข้อมูลการเรียนออนไลน์</h2>
        <form method="POST">
            <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson_id); ?>">
            <div class="mb-5">
                <label class="block mb-2 text-gray-700">ลิงก์การประชุม:</label>
                <input type="text" name="meeting_link" required class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300" placeholder="กรุณากรอกลิงก์การประชุม">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-gray-700">วันที่:</label>
                <input type="date" name="meeting_date" required class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-gray-700">เวลา:</label>
                <input type="time" name="meeting_time" required class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-gray-700">สถานะ:</label>
                <select name="status" class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition duration-300">
                    <option value="active">ใช้งาน</option>
                    <option value="inactive">ไม่ใช้งาน</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg mr-2 hover:bg-gray-400 transition duration-300">ยกเลิก</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">บันทึก</button>
            </div>
        </form>
    </div>

</body>

</html>