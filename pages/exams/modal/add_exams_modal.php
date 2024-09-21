<?php
// ดึงข้อมูลจากตาราง courses
$sql = "SELECT course_id, course_name FROM courses WHERE status = 1";
$result = $conn->query($sql);

// ฟังก์ชันสำหรับดึงข้อมูล enrollments ถ้าเลือก course
$enrollmentData = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course'])) {
    $course_id = $_POST['course'];

    $sql1 = "SELECT enrollment_id, student_id FROM enrollments WHERE course_id = ? AND status = 1";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $resultEnrollments = $stmt->get_result();

    // แสดงข้อมูล enrollment ในตัวแปร $enrollmentData
    while ($row = $resultEnrollments->fetch_assoc()) {
        $enrollmentData .= "<tr>";
        $enrollmentData .= "<td class='py-2 px-4 border'>" . htmlspecialchars($course_id) . "</td>"; // Course ID
        $enrollmentData .= "<td class='py-2 px-4 border'>" . htmlspecialchars($row['enrollment_id']) . "</td>"; // Enrollment ID
        $enrollmentData .= "<td class='py-2 px-4 border'>" . htmlspecialchars($row['student_id']) . "</td>"; // Student ID
        $enrollmentData .= "</tr>";
    }
}
?>

<div id="addExamModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">เพิ่มข้อมูลการสอบ</h2>
        <form method="POST" id="courseForm">
            <div class="mb-4">
                <label for="course" class="block text-gray-700 font-medium mb-2">เลือกคอร์ส:</label>
                <select name="course" id="course" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                    <option value="">-- เลือกคอร์ส --</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['course_id'] . "'" . (isset($course_id) && $course_id == $row['course_id'] ? ' selected' : '') . ">" . $row['course_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>ไม่มีคอร์ส</option>";
                    }
                    ?>
                </select>
            </div>

            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 border">Course ID</th>
                        <th class="py-2 px-4 border">Enrollment ID</th>
                        <th class="py-2 px-4 border">Student ID</th>
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
</div>

<script>
    function closeModal() {
        document.getElementById('addExamModal').classList.add('hidden');
    }
</script>