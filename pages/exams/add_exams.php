<?php
// ดึงข้อมูลจากตาราง courses
$sql = "SELECT course_id, course_name FROM courses WHERE status = 0";
$result = $conn->query($sql);

// ฟังก์ชันสำหรับดึงข้อมูล enrollments ถ้าเลือก course
$enrollmentData = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course'])) {
    $course_id = $_POST['course'];

    // ใช้ JOIN เพื่อดึงข้อมูล student_name จากตาราง students
    $sql1 = "SELECT e.enrollment_id, e.student_id, s.student_name 
              FROM enrollments e
              JOIN students s ON e.student_id = s.student_id
              WHERE e.course_id = ? AND e.status = 1";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $resultEnrollments = $stmt->get_result();

    // แสดงข้อมูล enrollment ในตัวแปร $enrollmentData
    while ($row = $resultEnrollments->fetch_assoc()) {
        $enrollmentData .= "<tr>";
        $enrollmentData .= "<td class='py-2 px-4 border'>" . htmlspecialchars($course_id) . "</td>"; // Course ID
        $enrollmentData .= "<td class='py-2 px-4 border'>" . htmlspecialchars($row['student_id']) . "</td>"; // Student ID
        $enrollmentData .= "<td class='py-2 px-4 border'>" . htmlspecialchars($row['student_name']) . "</td>"; // Student Name
        $enrollmentData .= "<td class='py-2 px-4 border'><input type='text' name='exam_score[]' class='border border-gray-300 rounded-lg p-1' placeholder='คะแนนจากการสอบ'></td>"; // Input field
        $enrollmentData .= "</tr>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['totalMarks'])) {
    // รับค่าจากฟอร์ม
    $totalMarks = $_POST['totalMarks'] ?? '';
    $passingCriteria = $_POST['passingCriteria'] ?? '';
    $passingPercentage = $_POST['passingPercentage'] ?? '';
    $exam_scores = $_POST['exam_score'] ?? [];

    // Echo ข้อมูลที่ได้รับจากฟอร์ม
    echo "<div class='mt-4'>";
    echo "<h3 class='text-lg font-semibold'>ข้อมูลการสอบ:</h3>";
    echo "<p>คะแนนเต็ม: " . htmlspecialchars($totalMarks) . "</p>";
    echo "<p>เกณฑ์การผ่าน (คะแนน): " . htmlspecialchars($passingCriteria) . "</p>";
    echo "<p>เกณฑ์การผ่าน (เปอร์เซ็น): " . htmlspecialchars($passingPercentage) . "%</p>";

    // แสดงคะแนนของนักเรียน
    // echo "<h4 class='mt-4'>คะแนนจากการสอบ:</h4>";
    foreach ($exam_scores as $index => $score) {
        echo "<p>คะแนนนักเรียน " . ($index + 1) . ": " . htmlspecialchars($score) . "</p>";
    }
    echo "</div>";


    if ($passingCriteria >= 0) {
        $total = $totalMarks -  $passingCriteria;
    } else if ($passingPercentage >= 0) {
    }

    echo $total;
}
?>

<div class="bg-white rounded-lg p-6 w-full flex flex-col justify-between">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800 flex items-center">
        <i class="fas fa-plus-circle mr-2"></i> <!-- ไอคอนเพิ่ม -->
        เพิ่มข้อมูลการสอบ
    </h2>
    <form method="POST" id="courseForm" class="flex-grow">
        <div class="mb-4">
            <label for="course" class="block text-gray-700 font-medium mb-2">เลือกคอร์ส:</label>
            <select name="course" id="course" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                <option value="">-- เลือกคอร์ส --</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['course_id'] . "'" . (isset($course_id) && $course_id == $row['course_id'] ? ' selected' : '') . ">" . htmlspecialchars($row['course_id']) . " " . htmlspecialchars($row['course_name']) . "</option>";
                    }
                } else {
                    echo "<option value=''>ไม่มีคอร์ส</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="totalMarks" class="block">คะแนนเต็ม</label>
            <input type="number" name="totalMarks" id="totalMarks" placeholder='คะแนน' class="border rounded w-full p-2" required>
        </div>

        <p class="text-red-500">** เลือกกรอกอย่างใดอย่างนึ่ง **</p>
        <div class="mb-4">
            <label for="passingCriteria" class="block">เกณฑ์การผ่าน (คะแนน)</label>
            <div class="flex">
                <input type="number" name="passingCriteria" placeholder='คะแนน' class="border rounded w-full p-2">
                <span class="text-center mt-1 ml-2 text-2xl">คะแนน</span>
            </div>
        </div>
        <div class="mb-4">
            <label for="passingPercentage" class="block">เกณฑ์การผ่าน (เปอร์เซ็น) <span class="text-red-500">ไม่ต้องใส่สัญลักษณ์ %</span></label>
            <div class="flex">
                <input type="text" name="passingPercentage" placeholder='เปอร์เซ็น' class="border rounded w-full p-2">
                <span class="text-center mt-1 ml-2 text-2xl">%</span>
            </div>
        </div>

        <table class="min-w-full bg-white border border-gray-300 mb-4">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-2 px-4 border">รหัสวิชา</th>
                    <th class="py-2 px-4 border">รหัสนักศึกษา</th>
                    <th class="py-2 px-4 border">ชื่อ-นามสกุล</th>
                    <th class="py-2 px-4 border">คะแนน</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $enrollmentData; ?>
            </tbody>
        </table>

        <div class="flex justify-end space-x-2 mt-4">
            <button type="button" id="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-lg" onclick="closeModal()">ยกเลิก</button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg">ยืนยัน</button>
        </div>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    function closeModal() {
        document.getElementById('addExamModal').classList.add('hidden');
    }
</script>