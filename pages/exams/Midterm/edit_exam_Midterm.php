<?php
if (isset($_GET['id'])) {
    $exam_id = $_GET['id'];

    // ดึงข้อมูลการสอบจากตาราง exams รวมกับ enrollments และ students เพื่อดึง student_name
    $sql = "SELECT exams.*, enrollments.enrollment_id, enrollments.student_id, students.student_name 
            FROM exams 
            INNER JOIN enrollments ON exams.enrollment_id = enrollments.enrollment_id 
            INNER JOIN students ON enrollments.student_id = students.student_id 
            WHERE exam_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $exam = $result->fetch_assoc();

    // ตรวจสอบว่าพบข้อมูลหรือไม่
    if (!$exam) {
        echo "ไม่พบข้อมูลการสอบที่ต้องการแก้ไข.";
        exit;
    }

    // ปิด statement
    $stmt->close();
} else {
    echo "ไม่พบการสอบที่ต้องการแก้ไข.";
    exit;
}

// ตรวจสอบการส่งฟอร์มเพื่ออัปเดตข้อมูล
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // รับค่าจาก POST
    $total_marks1 = $_POST['total_marks'];
    $score1 = $_POST['score'];
    $criterion1 = $_POST['criterion'] ?? '';

    $status1 = "ไม่ผ่าน"; // ตั้งค่าเริ่มต้นเป็น "ไม่ผ่าน"

    if (strpos($criterion1, '%') !== false) { // ตรวจสอบว่ามี "%" หรือไม่
        // ลบเครื่องหมาย '%' ออก
        $cleanedCriterion = str_replace('%', '', $criterion1);
        $total1 = $total_marks1 * ($cleanedCriterion / 100);

        // ตรวจสอบว่าคะแนนผ่านหรือไม่
        if ($score1 >= $total1) {
            $status1 = "ผ่าน"; // หากคะแนนมากกว่าหรือเท่ากับเกณฑ์ที่คำนวณได้ แสดงว่าผ่าน
        }
    } else {
        if ($score1 >= $criterion1) {
            $status1 = "ผ่าน"; // หากคะแนนมากกว่าหรือเท่ากับเกณฑ์ที่คำนวณได้ แสดงว่าผ่าน
        }
    }

    // เก็บค่า exams_status เป็นผลลัพธ์
    $exams_status = $status1;

    // เตรียมข้อมูลสำหรับการอัปเดต
    $exam_type = $_POST['exam_type'];
    $exam_date = $_POST['exam_date'];
    $exam_id = $_POST['exam_id']; // Get exam_id from POST

    // เตรียม statement สำหรับการอัปเดต
    $updateSQL = "UPDATE exams SET exam_type = ?, exam_date = ?, total_marks = ?, score = ?, exams_status = ? WHERE exam_id = ?";
    $stmt = $conn->prepare($updateSQL);

    // ผูกพารามิเตอร์ให้ตรงกับลำดับใน SQL statement
    $stmt->bind_param("sssssi", $exam_type, $exam_date, $total_marks1, $score1, $exams_status, $exam_id);

    // อัปเดตข้อมูล
    if ($stmt->execute()) {
        echo "<script>window.location.href='?page=Manage_exam_Midterm&status=1';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!-- หน้าแก้ไขการสอบ -->
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">แก้ไขการสอบ</h2>
    <form method="POST" action="" class="bg-white shadow-md rounded-lg p-8 space-y-6">
        <input type="hidden" name="exam_id" value="<?php echo htmlspecialchars($exam['exam_id']); ?>">

        <div class="mb-4">
            <label for="student_name" class="block text-gray-700 font-medium">ชื่อ-นามสกุล</label>
            <input type="text" name="student_name" id="student_name" value="<?php echo htmlspecialchars($exam['student_name']); ?>" class="border border-gray-300 rounded w-full p-3 bg-gray-300" readonly>
        </div>

        <div class="mb-4">
            <label for="exam_type" class="block text-gray-700 font-medium">ประเภทการสอบ</label>
            <input type="text" name="exam_type" id="exam_type" value="<?php echo htmlspecialchars($exam['exam_type']); ?>" class="border border-gray-300 rounded w-full p-3 bg-gray-300" readonly>
        </div>

        <div class="mb-4">
            <label for="exam_date" class="block text-gray-700 font-medium">วันที่สอบ</label>
            <input type="date" name="exam_date" id="exam_date" value="<?php echo htmlspecialchars($exam['exam_date']); ?>" class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>

        <div class="mb-4">
            <label for="total_marks" class="block text-gray-700 font-medium">คะแนนเต็ม</label>
            <input type="number" name="total_marks" id="total_marks" value="<?php echo htmlspecialchars($exam['total_marks']); ?>" class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>

        <div class="mb-4">
            <label for="criterion" class="block text-gray-700 font-medium">เกณฑ์การผ่าน</label>
            <input type="text" name="criterion" id="criterion" value="<?php echo htmlspecialchars($exam['criterion']); ?>" class="border border-gray-300 rounded w-full p-3 bg-gray-300" readonly>
        </div>

        <div class="mb-4">
            <label for="score" class="block text-gray-700 font-medium">คะแนนจากการสอบ</label>
            <input type="number" name="score" id="score" value="<?php echo htmlspecialchars($exam['score']); ?>" class="border border-gray-300 rounded w-full p-3 focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>

        <div class="flex justify-between">
            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600 transition duration-200">บันทึกการเปลี่ยนแปลง</button>
            <a href="?page=Manage_exam_Midterm" class="mt-2 bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded hover:bg-gray-400 transition duration-200">ยกเลิก</a>
        </div>
    </form>
</div> 