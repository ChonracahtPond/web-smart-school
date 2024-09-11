<?php
// ตรวจสอบว่ามีการส่งฟอร์มแบบ POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $nnet_scores_id = $_POST['nnet_scores_id'];  // เปลี่ยนจาก student_id เป็น nnet_scores_id
    $score = $_POST['score'];
    $exam_date = $_POST['exam_date'];

    // ตรวจสอบความถูกต้องของข้อมูล
    if (empty($nnet_scores_id) || empty($score) || empty($exam_date)) {
        die('กรุณากรอกข้อมูลให้ครบถ้วน');
    }

    // ตรวจสอบว่ามีการส่งค่า nnet_scores_id มาอย่างถูกต้อง
    if (!is_numeric($nnet_scores_id)) {
        die('ข้อมูล nnet_scores_id ไม่ถูกต้อง');
    }

    // อัปเดตข้อมูลคะแนนในฐานข้อมูล
    $query = "UPDATE nnet_scores 
              SET score = ?, exam_date = ? 
              WHERE nnet_scores_id = ?";  // เปลี่ยน student_id เป็น nnet_scores_id

    // เตรียมคำสั่ง
    if ($stmt = $conn->prepare($query)) {
        // ผูกค่าพารามิเตอร์
        $stmt->bind_param('dsi', $score, $exam_date, $nnet_scores_id);  // ผูกค่ากับ nnet_scores_id

        // รันคำสั่ง SQL
        if ($stmt->execute()) {
            // หลังจากอัปเดตเสร็จให้ redirect ไปยังหน้าแสดงข้อมูล
            echo "<script>window.location.href='?page=scores_management&status=1';</script>";
        } else {
            // แจ้งข้อผิดพลาดหากไม่สามารถรันคำสั่ง SQL ได้
            echo "Error: " . $stmt->error;
        }

        // ปิด statement
        $stmt->close();
    } else {
        // แจ้งข้อผิดพลาดหากไม่สามารถเตรียม statement ได้
        echo "Error: " . $conn->error;
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
} else {
    // ถ้าไม่ใช่การส่งแบบ POST ให้ redirect ไปยังหน้าแสดงข้อมูล
    echo "<script>window.location.href='?page=scores_management&status=1';</script>";
}
?>


<!-- โมดอลสำหรับแก้ไขข้อมูล -->
<div id="editScoreModal" class="modal fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="modal-content bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <div class="modal-header flex justify-between items-center border-b pb-2">
            <h5 class="text-xl font-semibold">แก้ไขคะแนน</h5>
            <button id="closeEditScoreModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <div class="modal-body mt-4">
            <form id="editScoreForm" method="POST" action="edit_score.php">
                <input type="hidden" id="edit_id" name="nnet_scores_id">
                <div class="mb-4">
                    <label for="edit_student_id" class="block text-sm font-medium text-gray-700">รหัสนักเรียน</label>
                    <input type="text" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="edit_student_id" name="student_id" required>
                </div>
                <div class="mb-4">
                    <label for="edit_exam_id" class="block text-sm font-medium text-gray-700">รหัสการสอบ</label>
                    <input type="text" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="edit_exam_id" name="exam_id" required>
                </div>
                <div class="mb-4">
                    <label for="edit_score" class="block text-sm font-medium text-gray-700">คะแนน</label>
                    <input type="number" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="edit_score" name="score" required>
                </div>
                <div class="mb-4">
                    <label for="edit_exam_date" class="block text-sm font-medium text-gray-700">วันที่สอบ</label>
                    <input type="date" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="edit_exam_date" name="exam_date" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">อัปเดต</button>
            </form>
        </div>
    </div>
</div>