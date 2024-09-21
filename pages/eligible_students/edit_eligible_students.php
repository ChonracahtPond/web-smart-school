<?php


// ตรวจสอบว่ามีการส่งข้อมูลแบบ POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eligible_students_id = $_POST['eligible_students_id'];
    $student_id = $_POST['studentId'];
    $enrollment_id = $_POST['enrollmentId'];
    $exam_id = $_POST['examId'];
    $date_time = $_POST['dateTime'];

    // อัปเดตข้อมูลนักเรียนที่มีสิทธิสอบ
    $sql = "UPDATE eligible_students SET student_id = ?, enrollment_id = ?, exam_id = ?, created_at = ? WHERE eligible_students_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $student_id, $enrollment_id, $exam_id, $date_time, $eligible_students_id);

    if ($stmt->execute()) {
        // ถ้าสำเร็จ ให้เปลี่ยนเส้นทางกลับไปที่หน้า eligible_students
        echo "<script>window.location.href='?page=eligible_students&status=1';</script>";
    } else {
        echo "<p class='text-red-500'>การอัปเดตล้มเหลว: " . htmlspecialchars($stmt->error) . "</p>";
    }

    $stmt->close();
} else if (isset($_GET['id'])) {
    // ถ้าหากมีการเรียกหน้าเพื่อแก้ไข ให้ดึงข้อมูลนักเรียน
    $eligible_students_id = $_GET['id'];

    $sql = "SELECT es.eligible_students_id, es.student_id, es.enrollment_id, es.exam_id, es.created_at AS date_time 
            FROM eligible_students es WHERE es.eligible_students_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eligible_students_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        echo "<p class='text-red-500'>ไม่พบข้อมูลนักเรียน</p>";
        exit;
    }
}
?>

<div class="p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold mb-4 text-indigo-600">แก้ไขนักเรียนที่มีสิทธิสอบ</h2>
    <form id="editEligibleStudentForm" method="POST">
        <input type="hidden" name="eligible_students_id" value="<?php echo htmlspecialchars($data['eligible_students_id']); ?>">

        <div class="mb-4">
            <label for="studentId" class="block text-gray-700">รหัสนักเรียน</label>
            <input type="text" id="studentId" name="studentId" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" value="<?php echo htmlspecialchars($data['student_id']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="enrollmentId" class="block text-gray-700">รหัสการลงทะเบียน</label>
            <input type="text" id="enrollmentId" name="enrollmentId" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" value="<?php echo htmlspecialchars($data['enrollment_id']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="examId" class="block text-gray-700">รหัสการสอบ</label>
            <input type="text" id="examId" name="examId" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" value="<?php echo htmlspecialchars($data['exam_id']); ?>" required>
        </div>

        <div class="mb-4">
            <label for="dateTime" class="block text-gray-700">วันที่และเวลา</label>
            <input type="datetime-local" id="dateTime" name="dateTime" class="border rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" value="<?php echo date('Y-m-d\TH:i', strtotime($data['date_time'])); ?>" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">บันทึก</button>
            <button type="button" id="closeEditModal" class="bg-red-500 text-white font-bold py-2 px-4 rounded ml-2 hover:bg-red-600 transition duration-200">ยกเลิก</button>
        </div>
    </form>
</div>